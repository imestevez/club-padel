<?php
                
    session_start();

    include '../Views/PROMOCIONAR_PARTIDOS/PROMOCIONAR_PARTIDOS_Alta_View.php'; 

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
				$MATCH = get_data_form(); //get data from form
				$list = $TRABAJO->ADD(); //recupera una lista de datos del partido añadido
				$users = new MESSAGE($lista, '../Controllers/PPROMOTE_MATCHES.php'); //muestra el mensaje despues de la sentencia sql
			}
    		break;
    	case 'DELETE':
    		# code...
    		break;
    	case 'SHOWCURRENT':
    		# code...
    		break;
    	case 'SHOWALL':
    		# code...
    		break;
    	default:
    		break;
    }
    ?>