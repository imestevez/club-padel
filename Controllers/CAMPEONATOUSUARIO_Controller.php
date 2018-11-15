<?php
                
    session_start();

    include '../Models/CAMPEONATO_Model.php';
    include '../Models/CAMPEONATOUSUARIO_Model.php';
    include '../Models/PAREJA_Model.php';

    include '../Views/CHAMPIONSHIP/CAMPEONATOUSUARIO_View.php'; 
    include '../Views/CHAMPIONSHIP/CAMPEONATOSABIERTOS_View.php';
    include '../Views/CHAMPIONSHIP/INSCRIBIRCAMPEONATO_View.php';

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

    Switch($action){
        case 'CAMPEONATOUSUARIO':
            $CAMPEONATOSUSUARIO = new CAMPEONATOUSUARIO_Model($_SESSION["login"]);
            $inscripciones = $CAMPEONATOSUSUARIO->SHOWALL();
            $VIEW = new CampeonatoUsuario($inscripciones);
        break;
        case 'CAMPEONATOSABIERTOS':

            $CAMPEONATO = new CAMPEONATO_Model('','','');
            $campeonatos = $CAMPEONATO->SHOWALL();
            $VIEW = new CampeonatosAbiertos($campeonatos);
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
                if(isset($_REQUEST["campeonato_ID"])){
                    $CAMPEONATO = new CAMPEONATO_Model($_REQUEST["campeonato_ID"],'','');
                    $categorias = $CAMPEONATO->GET_CATEGORIAS($_REQUEST["campeonato_ID"]);
                    $VIEW = new CATEGORIA($categorias);
                }
        break;
    }
    
    ?>