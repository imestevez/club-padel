<?php

	session_start();
	include "../Views/CHAMPIONSHIP/ADDCHAMPIONSHIP_View.php";
    include "../Views/CHAMPIONSHIP/CAMPEONATOSCERRADOS_View.php";
    include "../Models/CAMPEONATO_Model.php";
    include "../Views/INDEX_View.php";


	if(isset($_REQUEST['action']))  {//Si trae acción, se almacena el valor en la variable action
        $action = $_REQUEST['action'];
    }else{//Si no trae accion
        $action = '';
    }

    //Función para recoger los datos del formulario de add de campeonatos
    function get_data_form(){

        $nombre = '';
        $fecha = '';

        if(isset($_REQUEST['nombre'])){
            $nombre = $_REQUEST['nombre'];
        }

        if(isset($_REQUEST['fecha'])){
            $fecha = $_REQUEST['fecha'];
        }

        return new CAMPEONATO_Model($nombre,$fecha);

    }


    switch ($action) {
    	case 'Añadir':

    			$CAMPEONATO = get_data_form();
                $mensaje = $CAMPEONATO->ADD();
                new MESSAGE($mensaje, "../Controllers/USERCHAMPIONSHIP_Controller.php?action=OPENCHAMPIONSHIPS");

    		break;

    	case 'FORMADD':
            new ChampionshipAdd();
            break;

        case 'CAMPEONATOSCERRADOS':
            $CAMPEONATO = new CAMPEONATO_Model('','');
            $datos = $CAMPEONATO->SHOW_CLOSE();
            new CampeonatosCerrados($datos);
            break;    
    }


?>