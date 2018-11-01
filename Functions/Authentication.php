<?php
function IsAuthenticated(){
	if (!isset($_SESSION['login'])){ //si no se inserto un login
		//header('Location:USUARIOS_Controller.php?accion=Login');	
		return false;
	}
	else{//si se inserto un login
		return true;
	}
} //end of function IsAuthenticated()
?>