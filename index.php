<<?php

session_start();

include './Functions/Authentication.php';

if (!IsAuthenticated()){
	header('Location:./Controllers/LOGIN_Controller.php');
}
else{
	header('Location:./Controllers/INDEX_Controller.php');
}

?>