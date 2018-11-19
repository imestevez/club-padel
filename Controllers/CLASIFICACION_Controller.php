<?php

	session_start();
	include "../Views/CLASIFICACION/GESTIONAR_CLASIFICACIONES_View.php";

    include "../Models/CAMPEONATO_Model.php";



	if(isset($_REQUEST['action']))  {//Si trae acción, se almacena el valor en la variable action
        $action = $_REQUEST['action'];
    }else{//Si no trae accion
        $action = '';
    }


    switch ($action) {
        case 'SHOW':
            $CAMPEONATO = new CAMPEONATO_Model('','','');
            $datos = $CAMPEONATO->SHOWALL();
            new GESTIONAR_CLASIFICACIONES($datos);
            break;

        case 'RANKING':
            $CAMPEONATO = new CAMPEONATO_Model($_REQUEST["campeonato_ID"],'','');
            $categorias = $CAMPEONATO->GET_CATEGORIAS($_REQUEST["campeonato_ID"]);

            new RANKING($categorias);
            break; 
  
    }


?>