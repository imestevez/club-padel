<?php
                
    session_start();

    include '../Models/RESERVA_Model.php';
    include '../Models/PARTIDO_Model.php';

    include '../Views/PROMOCIONAR_PARTIDOS/PROMOCIONAR_PARTIDOS_ALTA_View.php'; 
    include '../Views/PROMOCIONAR_PARTIDOS/PROMOCIONAR_PARTIDOS_SHOWALL_View.php'; 

function get_data_form(){
    if(isset( $_REQUEST['login'])){
            $login = $_REQUEST['login'];
    }else{
        $login = NULL;
    }
    if(isset( $_REQUEST['fecha'])){
        $fecha = $_REQUEST['fecha'];
    }else{
        $fecha = NULL;
    }
    if(isset( $_REQUEST['pista_ID'])){
        $pista_ID = $_REQUEST['pista_ID'];
    }else{
        $pista_ID = NULL;
    }
    $RESERVA = new RESERVA_Model(
        $login, 
        $pista_ID,
        $fecha
        );

    return $RESERVA;
}

    if(isset($_REQUEST["action"]))  {//Si trae acción, se almacena el valor en la variable action
        $action = $_REQUEST["action"];
    }else{//Si no trae accion
        $action = '';
    }
    switch ($action) {
    	case 'ADD':
    		if (!$_POST){ //si viene del showall (no es un post)
    			new PROMOCIONAR_PARTIDOS_ADD();
			}
			else{ //si viene del add 
				$RESERVA = get_data_form(); //get data from form
				$mensaje = $RESERVA->ADD(); //recupera una lista de datos de la reserva añadid
                if($mensaje['reserva_ID'] <> NULL){
                    if(isset($_REQUEST['fecha'])){
                        $fecha = $_REQUEST['fecha'];
                        $reserva_ID = $mensaje['reserva_ID'];
                        $PARTIDO = new PARTIDO_Model($fecha,$reserva_ID);
                        $mensaje = $PARTIDO->ADD();
                    }
                }
				$users = new mensaje($mensaje, '../Controllers/PPROMOCIONAR_PARTIDOS.php'); //muestra el mensaje despues de la sentencia sql
			}
    		break;
    	case 'DELETE':
    		# code...
    		break;
    	case 'SHOWCURRENT':
    		# code...
    		break;
    	default:
            $PARTIDO = new PARTIDO_Model('','');
            $tuplas = $PARTIDO->SHOWALL();
            new PROMOCIONAR_PARTIDOS($tuplas, '../Controllers/PPROMOCIONAR_PARTIDOS.php');
    		break;
    }
    ?>