<?php
                
    session_start();

    include '../Models/ESCUELA_Model.php';
    include '../Models/RESERVA_Model.php';
    include '../Models/USUARIO_ESCUELA_Model.php';

    include '../Views/INSCRIBIRSE_ESCUELA/INSCRIBIRSE_ESCUELA_ADD_View.php'; 
    include '../Views/INSCRIBIRSE_ESCUELA/INSCRIBIRSE_ESCUELA_SHOWALL_View.php'; 
    include '../Views/INSCRIBIRSE_ESCUELA/INSCRIBIRSE_ESCUELA_SHOW_Escuelas_View.php'; 
    include '../Views/INSCRIBIRSE_ESCUELA/INSCRIBIRSE_ESCUELA_SHOW_Inscritos_View.php';

    include '../Views/MESSAGE_View.php'; 


function get_data_form(){
    if(isset( $_REQUEST['login'])){
        $login = $_REQUEST['login'];
    }elseif($_SESSION['login']){
        $login = $_SESSION['login'];
    }else{
          $login= NULL;
    }    
     if(isset( $_REQUEST['escuela_ID'])){
        $escuela_ID = $_REQUEST['escuela_ID'];
    }else{
        $escuela_ID = NULL;
    }

    $USUARIO_PARTIDO = new USUARIO_ESCUELA_Model(
        NULL,
        $login,
        $escuela_ID
        );

    return $USUARIO_PARTIDO;
}
function get_data_recordset($tupla){
    if($tupla <> NULL){
        $fecha = date('Y-m-d');
        $RESERVA = new RESERVA_Model(
            NULL,
            $fecha,
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
                    if(isset($_REQUEST["escuela_ID"])){//si se inserta el ID del partido
                        $ESCUELA = new ESCUELA_Model($_REQUEST["escuela_ID"],'','','','','');
                        $resultado = $ESCUELA->SHOW_Usuarios_Diponibles();
                        if(!is_string( $resultado)){
                            new INSCRIBIRSE_ESCUELA_ADD($resultado,$_REQUEST["escuela_ID"]);
                        }else{
                          $result = new MESSAGE($resultado, '../Controllers/INSCRIBIRSE_ESCUELA_Controller.php'); //muestra el mensaje despues de la sentencia sql
                        }
                    }//si no trae el id del partido
                    else{
                        $resultado = "ERROR: El ID del partido no se ha podido encontrar";
                        $result = new MESSAGE($resultado, '../Controllers/INSCRIBIRSE_ESCUELA_Controller.php'); //muestra el mensaje despues de la sentencia sql
                    }
                }else{
                        $resultado = "ERROR: No tienes privilegios de Administrador";
                        $result = new MESSAGE($resultado, '../Controllers/INSCRIBIRSE_ESCUELA_Controller.php'); //muestra el mensaje despues de la sentencia sql
                }
            }else{ //si  viene del post
  
                    $USUARIO_PARTIDO = get_data_form();
                    $resultado =  $USUARIO_PARTIDO->ADD();
                    $num_inscripciones = $USUARIO_PARTIDO->CHECK_INSCRIPCIONES();
                    if($num_inscripciones >= '3'){
                        if(isset($_REQUEST['escuela_ID'])){
                            $ESCUELA = new ESCUELA_Model($_REQUEST['escuela_ID'], '', '', '', '', '');
                            $tupla = $ESCUELA->ADD_RESERVA();
                            $RESERVA = get_data_recordset($tupla);
                            $resultado = $RESERVA->ADD_MULTI();
                            $result = new MESSAGE($resultado, '../Controllers/INSCRIBIRSE_ESCUELA_Controller.php'); //muestra el mensaje despues de la sentencia sql
                        }else{
                            $resultado = "ERROR: El ID del partido no se ha podido encontrar";
                            $result = new MESSAGE($resultado, '../Controllers/INSCRIBIRSE_ESCUELA_Controller.php'); 
                        }
                    }else{
                        $result = new MESSAGE($resultado, '../Controllers/INSCRIBIRSE_ESCUELA_Controller.php'); //muestra el mensaje despues de la sentencia sql
                    }
            }
    		break;
    	case 'SHOW_ESCUELAS':
                if($_SESSION["rol"] == 'ADMIN'){
                    $ESCUELA = new ESCUELA_Model('','','', '', '', '');
                    $escuelas = $ESCUELA->SHOWALL_Disponibles();
                    $VIEW = new INSCRIBIRSE_ESCUELA($escuelas);
                    $VIEW->renderAdmin();
                }else{
                    $ESCUELA = new ESCUELA_Model('','','', '', '', '');
                    $escuelas = $ESCUELA->SHOWALL_DisponiblesLogin($_SESSION['login']);
                    $VIEW = new INSCRIBIRSE_ESCUELA($escuelas);
                    $VIEW->render();
                }
    		break;
      case 'SHOW_INSCRITOS':
                if($_SESSION['rol'] == 'ADMIN'){
                  if(isset($_REQUEST["escuela_ID"])){
                        $USUARIO_ESCUELA = new USUARIO_ESCUELA_Model('','',$_REQUEST["escuela_ID"]);
                        $inscritos = $USUARIO_ESCUELA->SHOW_INSCRITOS();
                        $VIEW = new INSCRITOS_ESCUELA($inscritos);
                        $VIEW->renderAdmin();
                     }
                }else{
                      if(isset($_REQUEST["escuela_ID"])){
                        $USUARIO_ESCUELA = new USUARIO_ESCUELA_Model('','',$_REQUEST["escuela_ID"]);
                        $inscritos = $USUARIO_ESCUELA->SHOW_INSCRITOS();
                        $VIEW = new INSCRITOS_ESCUELA($inscritos);
                        $VIEW->render();
                     }
                    }
            break;
        case 'DELETE':
            if (!$_POST){ //si viene del showall (no es un post)
                if($_SESSION["rol"] == 'ADMIN'){
                    if(isset($_REQUEST["escuela_ID"]) && isset($_REQUEST["usuario_login"])){
                         $USUARIO_PARTIDO = new USUARIO_ESCUELA_Model('',$_REQUEST["usuario_login"],$_REQUEST["escuela_ID"]);
                        $resultado = $USUARIO_PARTIDO->DELETE();
                        $result = new MESSAGE($resultado, '../Controllers/INSCRIBIRSE_ESCUELA_Controller.php'); //muestra el mensaje despues de la sentencia sql
                    }
                 }else{//si no es admin
                    if(isset($_REQUEST["escuela_ID"])){
                        $USUARIO_PARTIDO = new USUARIO_ESCUELA_Model('',$_SESSION["login"],$_REQUEST["escuela_ID"]);
                        $resultado = $USUARIO_PARTIDO->DELETE();
                        $result = new MESSAGE($resultado, '../Controllers/INSCRIBIRSE_ESCUELA_Controller.php'); //muestra el mensaje despues de la sentencia sql
                     }
                 }
             }
            break;

    	default:
            if($_SESSION["rol"] == 'ADMIN'){
                $ESCUELA = new ESCUELA_Model('','','', '', '', '');
                $escuelas = $ESCUELA->SHOWALL_Inscripciones();
                if(!is_array($escuelas)){
                    $VIEW = new SHOW_INSCRIPCIONES($escuelas);
                    $VIEW->renderAdmin();
                }else{
                    $result = new MESSAGE($escuelas, '../Controllers/INSCRIBIRSE_ESCUELA_Controller.php'); //muestra el mensaje despues de la sentencia sql
                }
            }else{
                $ESCUELA = new ESCUELA_Model('','','', '', '', '');
                $escuelas = $ESCUELA->SHOWALL_Login($_SESSION["login"]);
                if(!is_array($escuelas)){
                    $VIEW = new SHOW_INSCRIPCIONES($escuelas);
                    $VIEW->render();
                }  else{
                    $result = new MESSAGE($escuelas, '../Controllers/INSCRIBIRSE_ESCUELA_Controller.php'); //muestra el mensaje despues de la sentencia sql
                }
            }
        	break;
        }//fin switch case
    
    ?>