<?php


if(!isset($_POST['login'])){ //si no se introdujo el login
	include_once '../Views/REGISTER_View.php';
	$register = new Register();//muestra la vista de registro
}
else{
		
	include_once '../Models/USER_Model.php'; //incluye el modelo de usuarios

	/*if($_REQUEST['action'] == 'BACK'){ //si el usuario pulsa en volver
		header('Location: ./Login_Controller.php'); //lo redirige al controlador de login

	}else{ //si envía el formulario
        */
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

	$rol_ID = 2;

	$USER = new USER_Model(
		$login, 
		$password,
		$nombre, 
		$apellidos,
		$genero,
		$rol_ID
		);


		$respuesta = $USER->ADD(); //añade al usuario en la BD
		include_once '../Views/MESSAGE_View.php';
		//new MESSAGE($respuesta['mensaje'], '../index.php');
		new MESSAGE($respuesta, '../index.php');
		//}	
	//}
}

?>