<?php

	session_start();
	include "../Views/ENFRENTAMIENTO/ENFRENTAMIENTO_View.php";
    include "../Views/ENFRENTAMIENTO/GESHORARIOS_View.php";
    include "../Views/ENFRENTAMIENTO/PROPONERHUECO_View.php";
    include "../Views/ENFRENTAMIENTO/GESRESULTADOS_View.php";
    include "../Views/ENFRENTAMIENTO/INTRODUCIRRESULTADO_View.php";

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

     function get_data_form(){

        $grupo_id = '';
        $resultado = '';
        $pareja_1 = '';
        $pareja_2 = '';
        $reserva_id = '';

        if(isset($_REQUEST['grupo_id'])){
            $grupo_id = $_REQUEST['grupo_id'];
        }
        if(isset($_REQUEST['resultado'])){
            $resultado = $_REQUEST['resultado'];
        }
        if(isset($_REQUEST['pareja_1'])){
            $pareja_1 = $_REQUEST['pareja_1'];
        }
        if(isset($_REQUEST['pareja_2'])){
            $pareja_2 = $_REQUEST['pareja_2'];
        }
        if(isset($_REQUEST['reserva_id'])){
            $reserva_id = $_REQUEST['reserva_id'];
        }

        return new ENFRENTAMIENTO_Model($grupo_id,$resultado, $pareja_1, $pareja_2, $reserva_id);
    }

     function get_data_form_Resultado(){
        
        if(isset($_REQUEST['enfrentamiento_ID'])){
            $enfrentamiento_ID = $_REQUEST['enfrentamiento_ID'];
        }else{
            $enfrentamiento_ID = NULL;
        }

        if(isset($_REQUEST['set1_1'])){
            $set1_1 = $_REQUEST['set1_1'];
        }else{
            $set1_1 = NULL;
        }

        if(isset($_REQUEST['set1_2'])){
            $set1_2 = $_REQUEST['set1_2'];
        }else{
            $set1_2 = NULL;
        }

        if(isset($_REQUEST['set2_1'])){
            $set2_1 = $_REQUEST['set2_1'];
        }else{
            $set2_1 = NULL;
        }

        if(isset($_REQUEST['set2_2'])){
            $set2_2 = $_REQUEST['set2_2'];
        }else{
            $set2_2 = NULL;
        }

        if(isset($_REQUEST['set3_1'])){
            $set3_1 = $_REQUEST['set3_1'];
        }else{
            $set3_1 = NULL;
        }

        if(isset($_REQUEST['set3_2'])){
            $set3_2 = $_REQUEST['set3_2'];
        }else{
            $set3_2 = NULL;
        }

        $resultado = $set1_1."-".$set1_2."/".$set2_1."-".$set2_2."/".$set3_1."-".$set3_2;

        return $resultado;

     }


  

    switch ($action) {
        case 'SHOW':
            $ENFRENTAMIENTO = new ENFRENTAMIENTO_Model('','','','','');
            $enfrentamientos = $ENFRENTAMIENTO->SHOW();
            new GESRESULTADOS($enfrentamientos);
            break;

    	case 'SHOWPROXIMOS':
            $ENFRENTAMIENTO = new ENFRENTAMIENTO_Model('','','','','');

            $proximos1 =  $ENFRENTAMIENTO->SHOW_PROXIMOS1($_SESSION['login']);
            $proximos2 =  $ENFRENTAMIENTO->SHOW_PROXIMOS2($_SESSION['login']);

            $showall =  $ENFRENTAMIENTO->SHOWALL($_SESSION['login']);


    		new EnfrentamientoProximos($proximos1, $proximos2, $showall);

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

        case 'INTRODUCIRRESULTADO':

            if(isset($_REQUEST["enfrentamiento_ID"])){
                    $VIEW = new IntroducirResultado($_REQUEST["enfrentamiento_ID"]);
            }
        break;
        case 'RESULTADO':
            $resultado = get_data_form_Resultado();
            $ENFRENTAMIENTO = new ENFRENTAMIENTO_Model('','','','','');
            $enfrentamiento = $ENFRENTAMIENTO->SET_RESULTADO($_REQUEST["enfrentamiento_ID"],  $resultado);
            $CLASIFICACION = new CLASIFICACION_Model('','','');
            $clasificacion = $CLASIFICACION->ACTUALIZAR_CLASIFICACION($resultado);

            $VIEW = new MESSAGE($enfrentamiento, '../Controllers/ENFRENTAMIENTO_Controller.php?action=SHOW');

            break;

    
    	
    }


?>