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

    if(isset($_REQUEST['fecha']))  {
        $fecha = $_REQUEST['fecha'];
        $fechaTrozos = explode("/", $fecha);
        $fecha = $fechaTrozos[2]."-".$fechaTrozos[0]."-".$fechaTrozos[1];
    }

    if(isset($_REQUEST['categorias'])){
        $categorias = $_REQUEST['categorias'];
    }

    //Función para recoger los datos del formulario de add de campeonatos
    function get_data_form(){

        $this->nombre = '';
        $this->fecha = '';

        if(isset($_REQUEST['nombre'])){
            $this->nombre = $_REQUEST['nombre'];
        }

        if(isset($_REQUEST['fecha'])){
            $this->fecha = $_REQUEST['fecha'];
        }


    }


    switch ($action) {
    	case 'Añadir':   		
            $CAMPEONATO = new CAMPEONATO_Model($nombre, $fecha);
            $mensaje = $CAMPEONATO->ADD($categorias);
            new MESSAGE($mensaje, "../Controllers/CAMPEONATOUSUARIO_Controller.php?action=CAMPEONATOSABIERTOS");

    		break;

    	case 'FORMADD':
            $CAMPEONATO = new CAMPEONATO_Model('','');
            $categorias = $CAMPEONATO->GET_CATEGORIASADD();
            new ChampionshipAdd($categorias);
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