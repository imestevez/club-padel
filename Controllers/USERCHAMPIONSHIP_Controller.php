<?php
                
    session_start();

    include '../Views/CHAMPIONSHIP/USERCHAMPIONSHIP_View.php'; 
    include '../Views/CHAMPIONSHIP/OPENCHAMPIONSHIP_View.php';
    include '../Views/CHAMPIONSHIP/INSCRIBIRCAMPEONATO_View.php';
    include '../Models/COUPLE_Model.php';

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

        if(isset($_REQUEST['capitan'])){
            $capitan = $_REQUEST['capitan'];
        }

        return new COUPLE_Model($login,$loginPareja, $capitan);
  

    }

    Switch($action){
        case 'USERCHAMPIONSHIPS':
            new UserChampionship();
        break;
        case 'OPENCHAMPIONSHIPS':
            new OpenChampionship();
        break;
        case 'INSCRIBIRCAMPEONATO':
            new InscribirCampeonato();
        break;
        case 'Añadir':
                $PAREJA = get_data_form();
                $mensaje = $PAREJA->ADD();
                include_once '../Views/MESSAGE_View.php';
                new MESSAGE($mensaje, "../Controllers/USERCHAMPIONSHIP_Controller.php");
        break;
    }
    
    ?>