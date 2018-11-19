<?php

	session_start();
	include "../Views/ENFRENTAMIENTO/ENFRENTAMIENTO_View.php";
    include "../Views/ENFRENTAMIENTO/GESHORARIOS_View.php";
    include "../Views/ENFRENTAMIENTO/PROPONERHUECO_View.php";

    include "../Models/ENFRENTAMIENTO_Model.php";


	if(isset($_REQUEST["action"]))  {//Si trae acción, se almacena el valor en la variable action
        $action = $_REQUEST["action"];
    }else{//Si no trae accion
        $action = 'SHOW';
    }

    if(isset($_REQUEST["enfrentamiento_id"]))  {//Si trae acción, se almacena el valor en la variable action
        $enfrentamiento_id = $_REQUEST["enfrentamiento_id"];
    }

    if(isset($_REQUEST["pareja_id"]))  {//Si trae acción, se almacena el valor en la variable action
        $pareja_id = $_REQUEST["pareja_id"];
    }

  

    switch ($action) {
    	case 'SHOWPROXIMOS':
    		new EnfrentamientoProximos();
    		break;

        case 'GESHORARIOS':
            $ENFRENTAMIENTO = new ENFRENTAMIENTO_Model('','','','','');

            $tusOfertas1 = $ENFRENTAMIENTO->SHOW_TUSOFERTAS1($_SESSION['login']);
            $tusOfertas2 = $ENFRENTAMIENTO->SHOW_TUSOFERTAS2($_SESSION['login']);

            $enfrentamientos1 = $ENFRENTAMIENTO->SHOW_ENFRENTAMIENTOS1($_SESSION['login']);
            $enfrentamientos2 = $ENFRENTAMIENTO->SHOW_ENFRENTAMIENTOS2($_SESSION['login']);

            $tusPropuestas1 = $ENFRENTAMIENTO->SHOW_PROPUESTAS1($_SESSION['login']);
            $tusPropuestas2 = $ENFRENTAMIENTO->SHOW_PROPUESTAS2($_SESSION['login']);

            new GestionHorarios($tusOfertas1,$tusOfertas2,$enfrentamientos1,$enfrentamientos2,$tusPropuestas1,$tusPropuestas2);
            break;

        case 'RECHAZAR':
            $ENFRENTAMIENTO = new ENFRENTAMIENTO_Model('','','','','');
            $ENFRENTAMIENTO->DELETE_HUECOS($enfrentamiento_id);

            new ProponerHueco(null,$enfrentamiento_id,$pareja_id);

            break;    


    
    	
    }


?>