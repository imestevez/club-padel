<?php

	session_start();
	include "../Views/CAMPEONATO/ADDCHAMPIONSHIP_View.php";
    include "../Views/CAMPEONATO/CAMPEONATOSCERRADOS_View.php";
    include "../Views/ENFRENTAMIENTO/SHOWALLENF_View.php";

    include "../Models/ENFRENTAMIENTO_Model.php";
    include "../Models/CAMPEONATO_Model.php";
    include "../Views/INDEX_View.php";


	if(isset($_REQUEST['action']))  {//Si trae acción, se almacena el valor en la variable action
        $action = $_REQUEST['action'];
    }else{//Si no trae accion
        $action = '';
    }

    if(isset($_REQUEST['id']))  {
        $id = $_REQUEST['id'];
    }else{//Si no trae accion
        $id = '';
    }

    if(isset($_REQUEST['nombre']))  {
        $nombre = $_REQUEST['nombre'];
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
            $conenf = $CAMPEONATO->CAMP_ENFRENTAMIENTOS();
            $sinenf = $CAMPEONATO->CAMP_NOENFRENTAMIENTOS();

            new CampeonatosCerrados($conenf,$sinenf);
            break; 

        case 'GENERAR':
            $CAMPEONATO = new CAMPEONATO_Model('','');
            $mensaje = $CAMPEONATO->GENERAR_GRUPOS($id);
            new MESSAGE($mensaje, "../Controllers/CAMPEONATO_Controller.php?action=CAMPEONATOSCERRADOS");
            break;

        case 'SHOWALLENF':
            $CAMPEONATO = new ENFRENTAMIENTO_Model('','','','','');
            $enfrentamientos = $CAMPEONATO->SHOWALL_ENFRENTAMIENTOS($id);
            new EnfrentamientosCampeonato($nombre,$enfrentamientos);
            break;         
    }


?>