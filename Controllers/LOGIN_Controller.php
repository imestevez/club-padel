<?php

    session_start();
    include '../Functions/Authentication.php';
    if (IsAuthenticated()){
        header('Location: ../index.php'); //vuelve al index.php
    }
    else{
        if(!isset($_REQUEST['login']) && !(isset($_REQUEST['password']))){ // si no se introdujo un login y contrasña
            include '../Views/LOGIN_View.php';
            $login = new Login(); // muestra la vista de Login
        }
        else{ //si se introdujeron
    
            include '../Views/MESSAGE_View.php'; //incluye la vista de mensajes 
            include '../Functions/Access_DB.php'; //incluye la conexión a la BD
            include '../Models/USER_Model.php'; //incluye el Modelo de usuarios
    
            $usuario = new USER_Model($_REQUEST['login'],$_REQUEST['password'],'','','',''); //crea un usuario con el login y password insertados
            $respuesta = $usuario->login(); //Comprueba que existe el login y se corresponde con las contraseña introducida
            if ($respuesta == 'true'){ //si se introdujeron correctamente
                //session_start(); //inicia sesion
                $respuesta =  $usuario->GET_ROL();
                if($respuesta <> NULL){
                    $_SESSION['login'] = $_REQUEST['login']; //guarda en la variable $_SESSION el nombre de usuario
                    $_SESSION['rol'] = $respuesta;
                    $_SESSION['reserva'] = 0;
                    header('Location:../index.php'); //redirige al index.php (estando autenticado)
                }else{
                    $respuesta = 'ERROR: No se ha podido conectar con la base de datos';
                    new MESSAGE($respuesta, './LOGIN_Controller.php'); //muestra el mensaje correspondiente al usuario y vuelve al Login controller
                }
            }
            else{//si no se introdujeron correctamente
                new MESSAGE($respuesta, './LOGIN_Controller.php'); //muestra el mensaje correspondiente al usuario y vuelve al Login controller
            }
    
        }
    }
    ?>