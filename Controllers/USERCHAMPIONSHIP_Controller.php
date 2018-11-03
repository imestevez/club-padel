<?php
                
    session_start();

    include '../Views/CHAMPIONSHIP/USERCHAMPIONSHIP_View.php'; 
    include '../Views/CHAMPIONSHIP/OPENCHAMPIONSHIP_View.php'; 

    if(isset($_REQUEST["action"]))  {//Si trae acción, se almacena el valor en la variable action
        $action = $_REQUEST["action"];
    }else{//Si no trae accion
        $action = '';
    }

    Switch($action){
        case 'USERCHAMPIONSHIPS':
            new UserChampionship();
        break;
        case 'OPENCHAMPIONSHIPS':
            new OpenChampionship();
        break;

    }
    
    ?>