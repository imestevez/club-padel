<?php


    session_start();

    include '../Models/USER_Model.php';
    include '../Models/ROL_Model.php';
    include '../Views/USER/USER_ADD_View.php'; 
    include '../Views/USER/USER_EDIT_View.php'; 
    include '../Views/USER/USER_SHOWALL_View.php'; 
    include '../Views/MESSAGE_View.php'; 


function get_data_form(){
	if(isset($_REQUEST['login'])){	
   		$login = $_REQUEST['login'];
   	}else{
   		$login = NULL;
   	}
	if(isset($_REQUEST['password'])){
		$password = $_REQUEST['password'];
	}else{
		$password = NULL;
	}
	if(isset($_REQUEST['nombre'])){
		$nombre = $_REQUEST['nombre'];
	}else{
		$nombre = NULL;
	}
	if(isset($_REQUEST['apellidos'])){
		$apellidos = $_REQUEST['apellidos'];
	}else{
		$apellidos = NULL;
	}
	if(isset($_REQUEST['genero'])){
		$genero = $_REQUEST['genero'];
	}else{
		$genero = NULL;
	}

	if(isset($_REQUEST['rol_ID']) && $_REQUEST['rol_ID'] <> '' ){
		$rol_ID = $_REQUEST['rol_ID'];
	}else{
		$rol_ID = 2;
	}

	$USER = new USER_Model(
		$login, 
		$password,
		$nombre, 
		$apellidos,
		$genero,
		$rol_ID
		);
	return $USER;
}

    if(isset($_REQUEST["action"]))  {//Si trae acción, se almacena el valor en la variable action
        $action = $_REQUEST["action"];
    }else{//Si no trae accion
        $action = '';
    }
     switch ($action) {
    	case 'ADD':
    		if (!$_POST){ //si viene del showall (no es un post)
    			$ROL = new ROL_Model('','');
    			$roles = $ROL->SHOWALL();
    			new USER_ADD($roles);
			}
			else{ //si viene del add 
				$USER = get_data_form(); //get data from form
                $mensaje = $USER->ADD();
				$result = new MESSAGE($mensaje, '../Controllers/USER_Controller.php'); //muestra el mensaje despues de la sentencia sql
			}
			break;
      	case 'EDIT':
			if (!$_POST){ //si viene del showall (no es un post)
				if(isset($_REQUEST['login'])){
					$USER = new USER_Model($_REQUEST['login'],'','','','','');
					$ROL = new ROL_Model('','');
					$roles = $ROL->SHOWALL();
					$user = $USER->SHOWCURRENT();
					new USER_EDIT($user,$roles);
				}
			}
			else{ //si viene del edit 
				$USER = get_data_form(); //get data from form
	            $mensaje = $USER->EDIT();
				$result = new MESSAGE($mensaje, '../Controllers/USER_Controller.php'); //muestra el mensaje despues de la sentencia sql
			}
			break;
    	case 'DELETE':
            if (!$_POST){ //si viene del showall (no es un post)
                if(isset($_REQUEST["login"])){
                    $USER = new USER_Model($_REQUEST["login"], '', '', '', '', '');
                    $mensaje = $USER->DELETE();
                    $result = new MESSAGE($mensaje, '../Controllers/USER_Controller.php'); //muestra el mensaje despues de la sentencia sql
                }
            }
    		break;
    	default:
            $USER = new USER_Model('','','','','', '');
            $tuplas = $USER->SHOWALL();
            new USER_SHOWALL($tuplas);
    		break;
        }


?>