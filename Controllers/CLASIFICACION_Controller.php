<?php

	session_start();
	include "../Views/CLASIFICACION/GESTIONAR_CLASIFICACIONES_View.php";
    include "../Views/CLASIFICACION/RANKING_View.php";

    include "../Models/CAMPEONATO_Model.php";
    include "../Models/CLASIFICACION_Model.php";



	if(isset($_REQUEST['action']))  {//Si trae acción, se almacena el valor en la variable action
        $action = $_REQUEST['action'];
    }else{//Si no trae accion
        $action = '';
    }
    if(isset($_REQUEST['campeonato_ID']))  {//Si trae acción, se almacena el valor en la variable action
        $campeonato_ID = $_REQUEST['campeonato_ID'];
    }

    if(isset($_REQUEST['nombre']))  {//Si trae acción, se almacena el valor en la variable action
        $nombre = $_REQUEST['nombre'];
    }


    switch ($action) {
        case 'SHOW':
            $CAMPEONATO = new CAMPEONATO_Model('','','');
            $datos = $CAMPEONATO->SHOWALL();
            new GESTIONAR_CLASIFICACIONES($datos);
            break;

        case 'RANKING':
            if(isset($_REQUEST["campeonato_ID"])){
                    $CAMPEONATO = new CAMPEONATO_Model($campeonato_ID,$_REQUEST["nombre"],'');
                    $CLASIFICACION = new CLASIFICACION_Model('','','');
                    $nombre_tablas = $CLASIFICACION->CAM_CAT_GRU($campeonato_ID);
                    $clasificaciones = $CLASIFICACION->SHOWALL($campeonato_ID);
                    $num_grupos = $CLASIFICACION->NUM_GRUPOS($campeonato_ID);


                    new RANKING($nombre,$nombre_tablas, $clasificaciones,$num_grupos);
            }
            
            break; 
  
    }
?>