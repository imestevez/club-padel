<?php

	session_start();
	include "../Views/ENFRENTAMIENTO/ENFRENTAMIENTO_View.php";
    include "../Views/ENFRENTAMIENTO/GESHORARIOS_View.php";
    include "../Models/ENFRENTAMIENTO_Model.php";


	if(isset($_REQUEST["action"]))  {//Si trae acción, se almacena el valor en la variable action
        $action = $_REQUEST["action"];
    }else{//Si no trae accion
        $action = 'SHOW';
    }

    switch ($action) {
    	case 'SHOWPROXIMOS':
    		new EnfrentamientoProximos();
    		break;

        case 'GESHORARIOS':
            $ENFRENTAMIENTO = new ENFRENTAMIENTO_Model('','','','','');
            $tusOfertas1 = $ENFRENTAMIENTO->SHOW_TUSOFERTAS1($_SESSION['login']);
            $tusOfertas2 = $ENFRENTAMIENTO->SHOW_TUSOFERTAS2($_SESSION['login']);
            new GestionHorarios($tusOfertas1,$tusOfertas2,'','');
            break;    
    	
    }


?>