<?php

	session_start();
	include "../Views/ENFRENTAMIENTO/ENFRENTAMIENTO_View.php";
    include "../Views/ENFRENTAMIENTO/GESHORARIOS_View.php";
    include "../Views/ENFRENTAMIENTO/PROPONERHUECO_View.php";
    include "../Views/ENFRENTAMIENTO/GESRESULTADOS_View.php";
    include "../Views/ENFRENTAMIENTO/GESRESULTADOSBUS_View.php";
    include "../Views/ENFRENTAMIENTO/INTRODUCIRRESULTADO_View.php";
    include "../Views/ENFRENTAMIENTO/SHOWCAMPEONATOS_View.php";
    include "../Views/ENFRENTAMIENTO/SHOWPAREJA_View.php";
    include "../Views/ENFRENTAMIENTO/SHOW_ENF_CC_View.php";
    include "../Views/ENFRENTAMIENTO/SHOW_ENF_CC_BUS_View.php";



    include "../Models/CLASIFICACION_Model.php";
    include "../Models/CAMPEONATO_Model.php";
    include "../Models/PAREJA_Model.php";



    include "../Models/ENFRENTAMIENTO_Model.php";


	if(isset($_REQUEST["action"]))  {//Si trae acción, se almacena el valor en la variable action
        $action = $_REQUEST["action"];
    }else{//Si no trae accion
        $action = '';
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
        case 'SHOW_ENF_CC':
            if(isset($_REQUEST['campeonato_ID'])){
                $ENFRENTAMIENTO = new ENFRENTAMIENTO_Model('','','','','');
                $enfrentamientos = $ENFRENTAMIENTO->SHOW_ENFS_CAMP($_REQUEST['campeonato_ID']);
                $CAMPEONATO = new CAMPEONATO_Model('','');
                $camp = $CAMPEONATO->GET_NOMBRE($_REQUEST['campeonato_ID']);
                $grupo_cat = $CAMPEONATO->GET_CG($_REQUEST['campeonato_ID']);
                new SHOW_ENF_CC($camp,$enfrentamientos,$grupo_cat,$_REQUEST['campeonato_ID']);
            }
            break;
        case 'SHOW':
            if(isset($_REQUEST['campeonato_ID'])){
                $ENFRENTAMIENTO = new ENFRENTAMIENTO_Model('','','','','');
                $enfrentamientos = $ENFRENTAMIENTO->SHOW_ENFS_CAMP($_REQUEST['campeonato_ID']);
                $CAMPEONATO = new CAMPEONATO_Model('','');
                $camp = $CAMPEONATO->GET_NOMBRE($_REQUEST['campeonato_ID']);
                $grupo_cat = $CAMPEONATO->GET_CG($_REQUEST['campeonato_ID']);
                new GESRESULTADOS($camp,$enfrentamientos,$grupo_cat,$_REQUEST['campeonato_ID']);
            }
            break;
        case 'SHOW_ENF_ETAPAS':
            if (isset($_REQUEST['campeonato_ID'])) {
                $CAMPEONATO = new CAMPEONATO_Model('','');
                $camp = $CAMPEONATO->GET_NOMBRE($_REQUEST['campeonato_ID']);

                $grupo_cat = explode(",", $_REQUEST['grupo_cat']);

                $categoria = $CAMPEONATO->CATEGORIA_FETCH($grupo_cat[1]);
                $grupo =  $CAMPEONATO->GRUPO_NOMBRE($grupo_cat[0]);
                $categorias = $CAMPEONATO->GET_CATEGORIASCAMPEONATO($_REQUEST['campeonato_ID']);
                $grupos = $CAMPEONATO->GET_GRUPOS($_REQUEST['campeonato_ID']);
                //Obtenemos los datos a mostrar de las etapas que haya actualamente en el campeonato
                $ENFRENTAMIENTO = new ENFRENTAMIENTO_Model('','','','','');
                $fase_grupos = $ENFRENTAMIENTO->SHOWALL_ENFRENTAMIENTOS_2($grupo_cat[0]);
                $fase_cuartos = $ENFRENTAMIENTO-> SHOW_ENF_FASE2($grupo_cat[0],'C');
                $fase_semis = $ENFRENTAMIENTO-> SHOW_ENF_FASE2($grupo_cat[0],'S');
                $fase_final = $ENFRENTAMIENTO-> SHOW_ENF_FASE2($grupo_cat[0],'F');
                //Calculamos la etapa actual 
                $actual = $CAMPEONATO->ETAPA_ACT($grupo_cat[0]);
                $grupo_cat = $CAMPEONATO->GET_CG($_REQUEST['campeonato_ID']);
                new SHOW_ENF_CC_BUS($camp,$categoria,$grupo,$fase_grupos,$fase_cuartos,$fase_semis,$fase_final,$actual,$grupo_cat,$_REQUEST['campeonato_ID']);

            }
            break;
        case 'SHOW_ETAPAS':
            if (isset($_REQUEST['campeonato_ID'])) {
                $CAMPEONATO = new CAMPEONATO_Model('','');
                $camp = $CAMPEONATO->GET_NOMBRE($_REQUEST['campeonato_ID']);

                $grupo_cat = explode(",", $_REQUEST['grupo_cat']);

                $categoria = $CAMPEONATO->CATEGORIA_FETCH($grupo_cat[1]);
                $grupo =  $CAMPEONATO->GRUPO_NOMBRE($grupo_cat[0]);
                $categorias = $CAMPEONATO->GET_CATEGORIASCAMPEONATO($_REQUEST['campeonato_ID']);
                $grupos = $CAMPEONATO->GET_GRUPOS($_REQUEST['campeonato_ID']);
                //Obtenemos los datos a mostrar de las etapas que haya actualamente en el campeonato
                $ENFRENTAMIENTO = new ENFRENTAMIENTO_Model('','','','','');
                $fase_grupos = $ENFRENTAMIENTO->SHOW_ENFS_GRUPO($grupo_cat[0]);
                $fase_cuartos = $ENFRENTAMIENTO-> SHOW_ENF_FASE($grupo_cat[0],'C');
                $fase_semis = $ENFRENTAMIENTO-> SHOW_ENF_FASE($grupo_cat[0],'S');
                $fase_final = $ENFRENTAMIENTO-> SHOW_ENF_FASE($grupo_cat[0],'F');
                //Calculamos la etapa actual 
                $actual = $CAMPEONATO->ETAPA_ACT($grupo_cat[0]);
                $grupo_cat = $CAMPEONATO->GET_CG($_REQUEST['campeonato_ID']);
                new GESRESULTADOSBUS($camp,$categoria,$grupo,$fase_grupos,$fase_cuartos,$fase_semis,$fase_final,$actual,$grupo_cat,$_REQUEST['campeonato_ID']);

            }
            break;

         case 'SHOW_PAREJA':
             if(isset($_REQUEST['pareja_ID']) && isset($_REQUEST['campeonato_ID'])){
                $PAREJA = new PAREJA_Model('','','');
                $usuarios = $PAREJA->SHOW_DEPORTISTAS($_REQUEST['pareja_ID']);
                new SHOW_PAREJA($_REQUEST['campeonato_ID'],$usuarios);
            }
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
                $VIEW = new IntroducirResultado($_REQUEST["enfrentamiento_ID"],$_REQUEST["grupo_id"],$_REQUEST["etapa"]);
            }
        break;
        case 'RESULTADO':
            $resultado = get_data_form_Resultado();
            $ENFRENTAMIENTO = new ENFRENTAMIENTO_Model('','','','','');
            $enfrentamiento = $ENFRENTAMIENTO->SET_RESULTADO($_REQUEST["enfrentamiento_ID"],  $resultado);
            $CLASIFICACION = new CLASIFICACION_Model('','','');
            $clasificacion = $CLASIFICACION->ACTUALIZAR_CLASIFICACION($resultado,$_REQUEST["enfrentamiento_ID"]);
            
            //Comprobamos si es el ultimo enfrentamiento en tener resultado
            $CAMPEONATO = new CAMPEONATO_Model('','');
            $promocion_grupo = $CAMPEONATO->COMPROBAR_ETAPA($_REQUEST["grupo_id"],$_REQUEST["etapa"]);
            if( $promocion_grupo == 1){
                $CAMPEONATO->GANADORES_GRUPO($_REQUEST["grupo_id"],$_REQUEST["etapa"]);
                $mensaje_cambio = "Ha terminado una fase del campeonato";
                $campeonato_id = $CAMPEONATO->GET_ID($_REQUEST["grupo_id"]);
                $VIEW = new MESSAGE($mensaje_cambio, '../Controllers/ENFRENTAMIENTO_Controller.php');

            }
            else{
                $VIEW = new MESSAGE($enfrentamiento, '../Controllers/ENFRENTAMIENTO_Controller.php'); 
            }

            break;
        default:
            $CAMPEONATO = new CAMPEONATO_Model('','');
            $conenf = $CAMPEONATO->CAMP_ENFRENTAMIENTOS();
            new CAMPEONATOS_ENFRENT($conenf);
        break;
    	
    }


?>