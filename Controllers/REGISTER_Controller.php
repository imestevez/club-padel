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

    $login = $_REQUEST['login'];
	$password = $_REQUEST['password'];
	$nombre = $_REQUEST['nombre'];
	$apellidos = $_REQUEST['apellidos'];
	$genero = $_REQUEST['genero'];

	$USER = new USER_Model(
		$login, 
		$password,
		$nombre, 
		$apellidos,
		$genero
		);

		//$respuesta = $USER->comprobarRegistro(); //comprueba que los datos están correctamente

	//if ($respuesta == 'true'){ //si estan correctamente
		$respuesta = $USER->ADD(); //añade al usuario en la BD
		include_once '../Views/MESSAGE_View.php';
		//new MESSAGE($respuesta['mensaje'], '../index.php');
		new MESSAGE($respuesta, '../index.php');
		//}	
	//}
}

?>