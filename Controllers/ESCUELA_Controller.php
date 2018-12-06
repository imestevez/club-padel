<?php
                
    session_start();

    include '../Models/PISTA_Model.php';
    include '../Models/HORARIO_Model.php';
    include '../Models/ESCUELA_Model.php';

    include '../Views/ESCUELA/ESCUELA_ADD_View.php'; 
    include '../Views/ESCUELA/ESCUELA_SHOWALL_View.php'; 
    include '../Views/ESCUELA/ESCUELA_SHOW_Inscritos_View.php';

    include '../Views/MESSAGE_View.php'; 


function get_data_form(){
  
    if(isset( $_REQUEST['nombre'])){
        $nombre = $_REQUEST['nombre'];
    }else{
        $nombre = NULL;
    }
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
    if(isset( $_REQUEST['inscripciones'])){
        $inscripciones = $_REQUEST['inscripciones'];
    }else{
        $inscripciones = 0;
    }

    $ESCUELA = new ESCUELA_Model(
        NULL,
        $nombre,
        $horario_ID, 
        $pista_ID,
        $inscripciones
        );

    return $ESCUELA;
}
function get_data_recordset($tupla){
    if($tupla <> NULL){
        $RESERVA = new RESERVA_Model(
            NULL,
            $tupla["FECHA"],
            $_SESSION["login"],
            $tupla["PISTA_ID"],
            $tupla["HORARIO_ID"]
            );
    }else{
        $RESERVA = new RESERVA_Model('','','','','');
    }
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
                if($_SESSION["rol"] == 'ADMIN'){ //si es el admin
                    $HORARIO = new HORARIO_Model('','','');
                    $PISTA = new PISTA_Model('','','');
                    $horarios = $HORARIO->SHOWALL();
                    $pistas = $PISTA->SHOWALL();

                    new ESCUELA_ADD($horarios,$pistas);
                }else{
                        $resultado = "ERROR: No tienes privilegios de Administrador";
                        $result = new MESSAGE($resultado, '../Controllers/ESCUELA_Controller.php'); //muestra el mensaje despues de la sentencia sql
                }
            }else{ //si  viene del post
  
                $ESCUELA = get_data_form(); //get data from form
                $mensaje = $ESCUELA->ADD();
                $resul = new MESSAGE($mensaje, '../Controllers/ESCUELA_Controller.php'); //muestra el mensaje despues de la sentencia sql
            }
    		break;
            case 'SHOW_INSCRITOS':
                if($_SESSION['rol'] == 'ADMIN'){
                  if(isset($_REQUEST["escuela_ID"])){
                        $ESCUELA = new ESCUELA_Model($_REQUEST["escuela_ID"], '','','','');
                        $inscritos = $ESCUELA->SHOW_INSCRITOS();
                        $VIEW = new INSCRITOS_PARTIDO($inscritos);
                        $VIEW->renderAdmin();
                     }
                }else{
                    if(isset($_REQUEST["escuela_ID"])){
                        $ESCUELA = new ESCUELA_Model('','',$_REQUEST["escuela_ID"]);
                        $inscritos = $ESCUELA->SHOW_INSCRITOS();
                        $VIEW = new INSCRITOS_PARTIDO($inscritos);
                        $VIEW->render();
                     }
                }
            break;
        case 'DELETE':
            if (!$_POST){ //si viene del showall (no es un post)
                if($_SESSION["rol"] == 'ADMIN'){
                    if(isset($_REQUEST["escuela_ID"])){
                        $ESCUELA = new ESCUELA_Model($_REQUEST["escuela_ID"],'','','','' );
                        $resultado = $ESCUELA->DELETE();
                        $result = new MESSAGE($resultado, '../Controllers/ESCUELA_Controller.php'); 
                    }
              }else{
                        $resultado = "ERROR: No tienes privilegios de Administrador";
                        $result = new MESSAGE($resultado, '../Controllers/ESCUELA_Controller.php'); //muestra el mensaje despues de la sentencia sql
                }
            break;

    	default:
            if($_SESSION["rol"] == 'ADMIN'){
                $ESCUELA = new ESCUELA_MODEL('','','', '', '', '');
                $partidos = $ESCUELA->SHOWALL();
                if(!is_array($partidos)){
                    $VIEW = new ESCUELA_SHOWALL($partidos);
                }else{
                    $result = new MESSAGE($partidos, '../Controllers/ESCUELA_Controller.php'); //muestra el mensaje despues de la sentencia sql
                }
            }else{
                $PARTIDO = new PARTIDO_Model('','','', '', '', '');
                $partidos = $PARTIDO->SHOWALL_Login($_SESSION["login"]);
                if(!is_array($partidos)){
                    $VIEW = new SHOW_INSCRIPCIONES($partidos);
                    $VIEW->render();
                }  else{
                    $result = new MESSAGE($partidos, '../Controllers/ESCUELA_Controller.php'); //muestra el mensaje despues de la sentencia sql
                }
            }
        	break;
        }//fin switch case
    
    ?>