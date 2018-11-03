<?php

	session_start();
	include "../Views/CONFRONTATION/CONFRONTATION_View.php";

	if(isset($_REQUEST["action"]))  {//Si trae acción, se almacena el valor en la variable action
        $action = $_REQUEST["action"];
    }else{//Si no trae accion
        $action = 'SHOW';
    }

    switch ($action) {
    	case 'SHOW':
    			new Confrontation();
    		break;
    	
    }


?>