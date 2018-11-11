<?php
                
    session_start();

    include '../Models/RESERVA_Model.php';
    include '../Models/PARTIDO_Model.php';
    include '../Models/PISTA_Model.php';
    include '../Models/HORARIO_Model.php';
    include '../Models/USUARIO_PARTIDO_Model.php';

   // include '../Views/INSCRIBIRSE_PARTIDOS/INSCRIBIRSE_PARTIDOS_Horario_View.php'; 
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

    if(isset($_REQUEST["action"]))  {//Si trae acción, se almacena el valor en la variable action
        $action = $_REQUEST["action"];
    }else{//Si no trae accion
        $action = '';
    }
    switch ($action) {
    	case 'ADD':
    		if (!$_POST){ //si viene del showall (no es un post)
                if($_SESSION["rol"] == 'ADMIN'){ //si es el admin
                    if(isset($_REQUEST['id'])){
                        $PARTIDO = new PARTIDO_Model($_REQUEST['id'],'','','','','');
                        $resultado = $PARTIDO->SHOW_Usuarios_Diponibles();
                        if(!is_string( $resultado)){
                            new INSCRIBIRSE_PARTIDOS_ADD($resultado,$_REQUEST['id']);
                        }else{
                          $result = new MESSAGE($resultado, '../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php'); //muestra el mensaje despues de la sentencia sql
                        }
                    }//
                }else{ //si no es el admin
                    
                    $USUARIO_PARTIDO = get_data_form();
                    $resultado =  $USUARIO_PARTIDO->ADD();
                    $result = new MESSAGE($resultado, '../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php'); //muestra el mensaje despues de la sentencia sql
                }
            }else{ //si  viene del post
                $USUARIO_PARTIDO = get_data_form();
                $resultado =  $USUARIO_PARTIDO->ADD();
                $result = new MESSAGE($resultado, '../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php'); //muestra el mensaje despues de la sentencia sql

            }
    		break;
    	case 'DELETE':
            if (!$_POST){ //si viene del showall (no es un post)
                if(isset($_REQUEST["id"])){

                }
            }
    		break;
    	case 'SHOW_PARTIDOS':
                $PARTIDO = new PARTIDO_Model('','','', '', '', '');
                $partidos = $PARTIDO->SHOW_Futuros();
                new INSCRIBIRSE_PARTIDOS($partidos, '../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php');
    		break;
    	default:

            if($_SESSION["rol"] == 'ADMIN'){
                $PARTIDO = new PARTIDO_Model('','','', '', '', '');
                $partidos = $PARTIDO->SHOWALL();
                new SHOW_INSCRIPCIONES($partidos, '../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php');
            }else{
                $PARTIDO = new PARTIDO_Model('','','', '', '', '');
                $partidos = $PARTIDO->SHOWALL_Login($_SESSION["login"]);
                new SHOW_INSCRIPCIONES($partidos, '../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php');
                }
        	break;
        }
    
    ?>