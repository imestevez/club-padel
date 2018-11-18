<?php
                
    session_start();

    include '../Models/PARTIDO_Model.php';
    include '../Models/RESERVA_Model.php';
    include '../Models/USUARIO_PARTIDO_Model.php';

    include '../Views/INSCRIBIRSE_PARTIDOS/INSCRIBIRSE_PARTIDOS_ADD_View.php'; 
    include '../Views/INSCRIBIRSE_PARTIDOS/INSCRIBIRSE_PARTIDOS_SHOWALL_View.php'; 
    include '../Views/INSCRIBIRSE_PARTIDOS/INSCRIBIRSE_PARTIDOS_SHOW_Partidos_View.php'; 

    include '../Views/MESSAGE_View.php'; 


function get_data_form(){
    if(isset( $_REQUEST['login'])){
        $login = $_REQUEST['login'];
    }elseif($_SESSION['login']){
        $login = $_SESSION['login'];
    }else{
          $login= NULL;
    }    
     if(isset( $_REQUEST['partido_ID'])){
        $partido_ID = $_REQUEST['partido_ID'];
    }else{
        $partido_ID = NULL;
    }

    $USUARIO_PARTIDO = new USUARIO_PARTIDO_Model(
        NULL,
        $login,
        $partido_ID
        );

    return $USUARIO_PARTIDO;
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
                    if(isset($_REQUEST["partido_ID"])){//si se inserta el ID del partido
                        $PARTIDO = new PARTIDO_Model($_REQUEST["partido_ID"],'','','','','');
                        $resultado = $PARTIDO->SHOW_Usuarios_Diponibles();
                        if(!is_string( $resultado)){
                            new INSCRIBIRSE_PARTIDOS_ADD($resultado,$_REQUEST["partido_ID"]);
                        }else{
                          $result = new MESSAGE($resultado, '../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php'); //muestra el mensaje despues de la sentencia sql
                        }
                    }//si no trae el id del partido
                    else{
                        $resultado = "ERROR: El ID del partido no se ha podido encontrar";
                        $result = new MESSAGE($resultado, '../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php'); //muestra el mensaje despues de la sentencia sql
                    }
                }else{
                        $resultado = "ERROR: No tienes privilegios de Administrador";
                        $result = new MESSAGE($resultado, '../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php'); //muestra el mensaje despues de la sentencia sql
                }
            }else{ //si  viene del post
  
                    $USUARIO_PARTIDO = get_data_form();
                    $resultado =  $USUARIO_PARTIDO->ADD();
                    $num_inscripciones = $USUARIO_PARTIDO->CHECK_INSCRIPCIONES();
                    if($num_inscripciones == '4'){
                        if(isset($_REQUEST['partido_ID'])){
                            $PARTIDO = new PARTIDO_Model($_REQUEST['partido_ID'], '', '', '', '', '');
                            $tupla = $PARTIDO->ADD_RESERVA();
                            $RESERVA = get_data_recordset($tupla);
                            $resultado = $RESERVA->ADD();
                            if(isset($resultado['reserva_ID'])){
                                $PARTIDO = new PARTIDO_Model($_REQUEST['partido_ID'], '', $resultado['reserva_ID'], '', '', '');
                                $PARTIDO->EDIT();
                            }
                            $result = new MESSAGE($resultado, '../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php'); //muestra el mensaje despues de la sentencia sql
                        }else{
                            $resultado = "ERROR: El ID del partido no se ha podido encontrar";
                            $result = new MESSAGE($resultado, '../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php'); 
                        }
                    }else{
                        $result = new MESSAGE($resultado, '../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php'); //muestra el mensaje despues de la sentencia sql
                    }
            }
    		break;
    	case 'SHOW_PARTIDOS':
                if($_SESSION["rol"] == 'ADMIN'){
                    $PARTIDO = new PARTIDO_Model('','','', '', '', '');
                    $partidos = $PARTIDO->SHOW_Futuros();
                    $VIEW = new INSCRIBIRSE_PARTIDOS($partidos);
                    $VIEW->renderAdmin();
                }else{
                    $PARTIDO = new PARTIDO_Model('','','', '', '', '');
                    $partidos = $PARTIDO->SHOW_FuturosLogin($_SESSION['login']);
                    $VIEW = new INSCRIBIRSE_PARTIDOS($partidos);
                    $VIEW->render();
                }
    		break;
        case 'DELETE':
            if (!$_POST){ //si viene del showall (no es un post)
                if($_SESSION["rol"] == 'ADMIN'){
                    if(isset($_REQUEST["partido_ID"]) && isset($_REQUEST["usuario_login"])){
                         $USUARIO_PARTIDO = new USUARIO_PARTIDO_Model('',$_REQUEST["usuario_login"],$_REQUEST["partido_ID"]);
                        $resultado = $USUARIO_PARTIDO->DELETE();
                        $result = new MESSAGE($resultado, '../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php'); //muestra el mensaje despues de la sentencia sql
                    }
                 }else{//si no es admin
                    if(isset($_REQUEST["partido_ID"])){
                        $USUARIO_PARTIDO = new USUARIO_PARTIDO_Model('',$_SESSION["login"],$_REQUEST["partido_ID"]);
                        $resultado = $USUARIO_PARTIDO->DELETE();
                        $result = new MESSAGE($resultado, '../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php'); //muestra el mensaje despues de la sentencia sql
                     }
                 }
             }
            break;

    	default:
            if($_SESSION["rol"] == 'ADMIN'){
                $PARTIDO = new PARTIDO_Model('','','', '', '', '');
                $partidos = $PARTIDO->SHOWALL_Inscripciones();
                if(!is_array($partidos)){
                    $VIEW = new SHOW_INSCRIPCIONES($partidos);
                    $VIEW->renderAdmin();
                }else{
                    $result = new MESSAGE($partidos, '../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php'); //muestra el mensaje despues de la sentencia sql
                }
            }else{
                $PARTIDO = new PARTIDO_Model('','','', '', '', '');
                $partidos = $PARTIDO->SHOWALL_Login($_SESSION["login"]);
                if(!is_array($partidos)){
                    $VIEW = new SHOW_INSCRIPCIONES($partidos);
                    $VIEW->render();
                }  else{
                    $result = new MESSAGE($partidos, '../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php'); //muestra el mensaje despues de la sentencia sql
                }
            }
        	break;
        }//fin switch case
    
    ?>