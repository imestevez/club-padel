<?php
                
    session_start();

    include '../Models/HORARIO_Model.php';
    include '../Views/HORARIO/HORARIO_ADD_View.php'; 
    include '../Views/HORARIO/HORARIO_SHOWALL_View.php'; 
    include '../Views/MESSAGE_View.php'; 


function get_data_form(){
    
     if(isset( $_REQUEST['hora_inicio'])){
        $hora_inicio = $_REQUEST['hora_inicio'];
    }else{
        $hora_inicio = NULL;
    }
    if(isset( $_REQUEST['hora_fin'])){
        $hora_fin = $_REQUEST['hora_fin'];
    }else{
        $hora_fin = NULL;
    }
    $HORARIO = new HORARIO_Model(
        NULL,
        $hora_inicio,
        $hora_fin
        );

    return $HORARIO;
}

    if(isset($_REQUEST["action"]))  {//Si trae acción, se almacena el valor en la variable action
        $action = $_REQUEST["action"];
    }else{//Si no trae accion
        $action = '';
    }
    switch ($action) {
    	case 'ADD':
    		if (!$_POST){ //si viene del showall (no es un post)
                $HORARIO = new HORARIO_Model('','','');
                $horarios = $HORARIO->SHOW_Disponibles();
    			new HORARIO_ADD($horarios);
			}
			else{ //si viene del add 
				$HORARIO = get_data_form(); //get data from form
                $mensaje = $HORARIO->ADD();
				$result = new MESSAGE($mensaje, '../Controllers/HORARIO_Controller.php'); //muestra el mensaje despues de la sentencia sql
			}
    		break;
      
    	case 'DELETE':
            if (!$_POST){ //si viene del showall (no es un post)
                if(isset($_REQUEST["horario_ID"])){
                    $HORARIO = new HORARIO_Model($_REQUEST["horario_ID"], '', '');
                    $mensaje = $HORARIO->DELETE();
                    $result = new MESSAGE($mensaje, '../Controllers/HORARIO_Controller.php'); //muestra el mensaje despues de la sentencia sql
                }
            }
    		break;
    	default:
            $HORARIO = new HORARIO_Model('','','');
            $horarios = $HORARIO->SHOWALL();
            new HORARIO($horarios, '../Controllers/HORARIO_Controller.php');
    		break;
        }
    
    ?>