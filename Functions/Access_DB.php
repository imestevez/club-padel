<?php

//Script que realiza la conexion a la BD con los datos de usuario y contraseña para poder acceder a ella

include_once '../Views/MESSAGE_View.php';
//funcion para conectar a la BD
function ConnectDB(){
   $conexion = mysqli_connect("localhost", "root", "", "abp41") or (new MESSAGE('ERROR: No se ha podido conectar con la base de datos', '../index.php')); //realiza la conexion

 if ($conexion->connect_errno) {//si se produce un error
    	return false;
 }else{
 	return $conexion;
 }
}
?>