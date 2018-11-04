<?php
                
    session_start();

    include '../Models/RESERVE_Model.php';
    include '../Models/MATCH_Model.php';

    include '../Views/PROMOTE_MATCHES/PROMOTE_MATCHES_ALTA_View.php'; 
    include '../Views/PROMOTE_MATCHES/PROMOTE_MATCHES_SHOWALL_View.php'; 

function get_data_form(){
    if(isset( $_REQUEST['login'])){
            $login = $_REQUEST['login'];
    }else{
        $login = NULL;
    }
    if(isset( $_REQUEST['fecha'])){
        $fecha = $_REQUEST['fecha'];
    }else{
        $fecha = NULL;
    }
    if(isset( $_REQUEST['pista_ID'])){
        $pista_ID = $_REQUEST['pista_ID'];
    }else{
        $pista_ID = NULL;
    }
    $RESERVE = new RESERVE_Model(
        $login, 
        $pista_ID,
        $fecha
        );

    return $RESERVE;
}

    if(isset($_REQUEST["action"]))  {//Si trae acción, se almacena el valor en la variable action
        $action = $_REQUEST["action"];
    }else{//Si no trae accion
        $action = '';
    }
    switch ($action) {
    	case 'ADD':
    		if (!$_POST){ //si viene del showall (no es un post)
    			new PROMOTE_MATCHES_ADD();
			}
			else{ //si viene del add 
				$RESERVE = get_data_form(); //get data from form
				$message = $RESERVE->ADD(); //recupera una lista de datos de la reserva añadid
                if($message['reserva_ID'] <> NULL){
                    if(isset($_REQUEST['fecha'])){
                        $fecha = $_REQUEST['fecha'];
                        $reserva_ID = $message['reserva_ID'];
                        $MATCH = new MATCH_Model($fecha,$reserva_ID);
                        $message = $MATCH->ADD();
                    }
                }
				$users = new MESSAGE($message, '../Controllers/PPROMOTE_MATCHES.php'); //muestra el mensaje despues de la sentencia sql
			}
    		break;
    	case 'DELETE':
    		# code...
    		break;
    	case 'SHOWCURRENT':
    		# code...
    		break;
    	default:
            $MATCH = new MATCH_Model('','');
            $tuplas = $MATCH->SHOWALL();



            new PROMOTE_MATCHES();
    		break;
    }
    ?>