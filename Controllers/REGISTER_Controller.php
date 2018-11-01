<?php


if(!isset($_POST['dni'])){ //si no se introdujo el login
	include_once '../Views/REGISTER_View.php';
	$register = new Register();//muestra la vista de registro
}
else{
		
	include_once '../Models/USER_Model.php'; //incluye el modelo de usuarios

	/*if($_REQUEST['action'] == 'BACK'){ //si el usuario pulsa en volver
		header('Location: ./Login_Controller.php'); //lo redirige al controlador de login

	}else{ //si envía el formulario
        */
	$name = $_REQUEST['name'];
	$email = $_REQUEST['email'];
	$dni = $_REQUEST['dni'];
	$password = $_REQUEST['password'];

	$USER = new USER_Model(
		$name, 
		$email, 
		$dni, 
		$password);

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