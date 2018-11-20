<?php
                
    session_start();

    include '../Models/CAMPEONATO_Model.php';
    include '../Models/CAMPEONATOUSUARIO_Model.php';
    include '../Models/PAREJA_Model.php';
    include '../Models/INSCRIPCION_Model.php';

    include '../Views/CAMPEONATO/CAMPEONATOUSUARIO_View.php'; 
    include '../Views/CAMPEONATO/CAMPEONATOSABIERTOS_View.php';
    include '../Views/CAMPEONATO/INSCRIBIRCAMPEONATO_View.php';
    include '../Views/CAMPEONATO/CATEGORIA_View.php';

    if(isset($_REQUEST["action"]))  {//Si trae acción, se almacena el valor en la variable action
        $action = $_REQUEST["action"];
    }else{//Si no trae accion
        $action = '';
    }

    function get_data_form(){

        $login = '';
        $loginPareja = '';
        $capitan= '';

        if(isset($_REQUEST['login'])){
            $login = $_REQUEST['login'];
        }

        if(isset($_REQUEST['loginPareja'])){
            $loginPareja = $_REQUEST['loginPareja'];
        }

        return new PAREJA_Model($login,$loginPareja, $login);
    }

    function get_data_form_inscripcion(){
        $fecha_actual=date("d/m/Y"); 
        $pareja_ID = '';
        $cam_cat_ID = '';

        if(isset($_REQUEST['pareja_ID'])){
            $pareja_ID = $_REQUEST['pareja_ID'];
        }

        if(isset($_REQUEST['cam_cat_ID'])){
            $cam_cat_ID = $_REQUEST['cam_cat_ID'];
        }

        return new INSCRIPCION_Model($fecha_actual,$pareja_ID,$cam_cat_ID);
    }

    Switch($action){
        case 'CAMPEONATOUSUARIO':
            $CAMPEONATOSUSUARIO = new CAMPEONATOUSUARIO_Model($_SESSION["login"]);
            $inscripciones = $CAMPEONATOSUSUARIO->SHOWALL();
            $VIEW = new CampeonatoUsuario($inscripciones);
        break;
        case 'CAMPEONATOSABIERTOS':

            $CAMPEONATO = new CAMPEONATO_Model('','','');
            $campeonatos = $CAMPEONATO->SHOWALL();
            if(is_string($campeonatos)){
                $mensajes = new MESSAGE($campeonatos, '../Controllers/CAMPEONATOUSUARIO_Controller.php');
            }else{
                $VIEW = new CampeonatosAbiertos($campeonatos);
            }
            
        break;
        case 'INSCRIBIRCAMPEONATO':

            if(isset($_REQUEST["campeonato_ID"])){
                    $CAMPEONATO = new CAMPEONATO_Model($_REQUEST["campeonato_ID"],$_REQUEST["nombre"],'');
                    $VIEW = new InscribirCampeonato($CAMPEONATO);
            }
        break;
        case 'Añadir':
                $PAREJA = get_data_form();
                $PAREJA->ADD();
                $pareja_ID= $PAREJA->GET_ID();
                if(isset($_REQUEST["campeonato_ID"])){
                    $CAMPEONATO = new CAMPEONATO_Model($_REQUEST["campeonato_ID"],'','');
                    $categorias = $CAMPEONATO->GET_CATEGORIAS($_REQUEST["campeonato_ID"]);
                    $VIEW = new CATEGORIA($categorias,$pareja_ID);
                }
        break;
        case 'CATEGORIA':

                    $INSCRIPCION = get_data_form_inscripcion();
                    $inscripcion=$INSCRIPCION->ADD();
                    $VIEW = new MESSAGE($inscripcion, '../Controllers/CAMPEONATOUSUARIO_Controller.php?action=CAMPEONATOUSUARIO');
        break;
    }
    
    ?>