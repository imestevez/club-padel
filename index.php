<?php

date_default_timezone_set("Europe/Spain");
session_start();

include './Functions/Authentication.php';

if (!IsAuthenticated()){
	header('Location:./Controllers/INDEX_Controller.php?');
}
else{
	header('Location:./Controllers/INDEX_Controller.php?');
}
?>