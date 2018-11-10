<?php
                
    session_start();

    include '../Models/RESERVA_Model.php';
    include '../Models/PARTIDO_Model.php';
    include '../Models/PISTA_Model.php';
    include '../Models/HORARIO_Model.php';
    include '../Views/PROMOCIONAR_PARTIDOS/PROMOCIONAR_PARTIDOS_Horario_View.php'; 
    include '../Views/PROMOCIONAR_PARTIDOS/PROMOCIONAR_PARTIDOS_ADD_View.php'; 
    include '../Views/PROMOCIONAR_PARTIDOS/PROMOCIONAR_PARTIDOS_SHOWALL_View.php'; 
    include '../Views/MESSAGE_View.php'; 


function get_data_form(){
    if(isset( $_REQUEST['fecha'])){
        $fecha = $_REQUEST['fecha'];
    }else{
        $fecha = NULL;
    }

    $reserva_ID = NULL;
    
     if(isset( $_REQUEST['horario_ID'])){
        $horario_ID = $_REQUEST['horario_ID'];
    }else{
        $horario_ID = NULL;
    }
    if(isset( $_REQUEST['pista_ID'])){
        $pista_ID = $_REQUEST['pista_ID'];
    }else{
        $pista_ID = NULL;
    }
    $PARTIDO = new PARTIDO_Model(
        NULL,
        $fecha,
        NULL, 
        $horario_ID,
        $pista_ID,
        NULL
        );

    return $PARTIDO;
}

    if(isset($_REQUEST["action"]))  {//Si trae acción, se almacena el valor en la variable action
        $action = $_REQUEST["action"];
    }else{//Si no trae accion
        $action = '';
    }
    switch ($action) {
    	case 'ADD':
    		if (!$_POST){ //si viene del showall (no es un post)
                $HORARIO = new HORARIO_Model('','','');
                $RESERVA = new RESERVA_Model('','','','','','');
                $PISTA = new PISTA_Model('','','');
                $PARTIDO = new PARTIDO_Model('','','','','','');
                $horarios = $HORARIO->SHOWALL();
                $reservas = $RESERVA->SHOWALL();
                $pistas =  $PISTA->SHOWALL();
                $partidos =  $PARTIDO->SHOWALL();
    			new PROMOCIONAR_PARTIDOS_Horario($horarios,$reservas,$partidos, $pistas);
			}
			else{ //si viene del add 
				$PARTIDO = get_data_form(); //get data from form
                $mensaje = $PARTIDO->ADD();
				$users = new MESSAGE($mensaje, '../Controllers/PROMOCIONAR_PARTIDOS_Controller.php'); //muestra el mensaje despues de la sentencia sql
			}
    		break;
        case 'SHOW_PISTAS':
            if( (isset($_REQUEST["horario_ID"])) && (isset($_REQUEST["fecha"])) ) {
                $RESERVA = new RESERVA_Model('',$_REQUEST["fecha"], '', '', $_REQUEST["horario_ID"]);
                $pistas_sin_reserva = $RESERVA->SEARCH_PISTAS_LIBRES(); 
                if(is_string($pistas_sin_reserva)){ //Si se envía unicamente un string
                    $mensajes = new MESSAGE($pistas_sin_reserva, '../Controllers/PROMOCIONAR_PARTIDOS_Controller.php'); //muestra el mensaje despues de la sentencia sql
                }else{
                    $HORARIO = new HORARIO_Model($_REQUEST["horario_ID"], '', '');
                    $horario = $HORARIO->SHOW();
                    if(is_string($horario)){ //Si se envía unicamente un string
                        $mensajes = new MESSAGE($horario, '../Controllers/PROMOCIONAR_PARTIDOS_Controller.php'); //muestra el mensaje despues de la sentencia sql
                     }else{
                        new PROMOCIONAR_PARTIDOS_ADD($pistas_sin_reserva, $_REQUEST["fecha"], $horario );
                    }
                }
            }
            break;
    	case 'DELETE':
            if (!$_POST){ //si viene del showall (no es un post)
                if(isset($_REQUEST["id"])){
                    $PARTIDO = new PARTIDO_Model($_REQUEST["id"], '', '', '', '', '');
                    $mensaje = $PARTIDO->DELETE();
                    $partidos = new MESSAGE($mensaje, '../Controllers/PROMOCIONAR_PARTIDOS_Controller.php'); //muestra el mensaje despues de la sentencia sql
                }
            }
    		# code...
    		break;
    	case 'SHOWCURRENT':
    		# code...
    		break;
    	default:
            $PARTIDO = new PARTIDO_Model('','','', '', '', '');
            $partidos = $PARTIDO->SHOWALL();
            new PROMOCIONAR_PARTIDOS($partidos, '../Controllers/PROMOCIONAR_PARTIDOS_Controller.php');
    		break;
        }
    
    ?>