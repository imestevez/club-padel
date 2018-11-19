<?php

	session_start();
	include "../Views/ENFRENTAMIENTO/OFERTAHUECOS_View.php";
    include "../Models/HUECO_Model.php";


	if(isset($_REQUEST["action"]))  {//Si trae acción, se almacena el valor en la variable action
        $action = $_REQUEST["action"];
    }else{//Si no trae accion
        $action = '';
    }

    if(isset($_REQUEST["enfrentamiento_id"]))  {
        $enfrentamiento_id = $_REQUEST["enfrentamiento_id"];
    }else{
        $enfrentamiento_id = '';
    }

    if(isset($_REQUEST["fecha"]))  {
        $fecha = $_REQUEST["fecha"];
    }else{
        $fecha = '';
    }

    if(isset($_REQUEST["horario_id"]))  {
        $horario_id = $_REQUEST["horario_id"];
    }else{
        $horario_id = '';
    }
    if(isset($_REQUEST["pareja_id"]))  {
        $pareja_id = $_REQUEST["pareja_id"];
    }else{
        $pareja_id = '';
    }

    switch ($action) {
    	case 'GETOFERTAS':
    		$HUECO = new HUECO_Model('',$enfrentamiento_id,$pareja_id,'');
    		$oferta1 = $HUECO->GETOFERTA();
    		new OfertaHuecos($oferta1, $pareja_id);
    		break;  

        case 'ACEPTAR':
            $HUECO = new HUECO_Model($fecha,$enfrentamiento_id,$pareja_id,$horario_id);
            $mensaje = $HUECO->ACEPTAR();
            new MESSAGE($mensaje, '');

    	
    }


?>