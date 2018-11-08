<?php

class USERCHAMPONSHIP_Model{

	var $login;

	var $categoria;
	var $pareja_id;
	var $campeonato_id;

	var $mysqli;

	function __construct($login){
		
		include_once '../Functions/Access_DB.php';
        $this->mysqli = ConnectDB();
	}


	switch ($action) {
		case 'SHOWALL':
			
			break;
		
		default:
			# code...
			break;
	}

	//Función para obtener los campeonatos en los que participa un usuario
	function SHOWALL(){
		//Buscamos parejas registradas del usuario
		$sql_par = "SELECT * FROM PAREJA WHERE (
			(JUGADOR_1='$this->login') OR (JUGADOR_2='$this->login')
		)";

		$result_par = $this->mysqli->query($sql_par);
		$num_rows_par = mysqli_num_rows($result_par);

		while($num_rows_par and $row_par = mysqli_fetch_array($resultado)){
			$id_par = $row['ID'];

			//Buscamos las inscripciones 
			$sql_camp = "SELECT * FROM INSCRIPCION WHERE (PAREJA_ID = '$this->id_par')";
			$result_camp = $this->mysqli->query($sql_camp);
		}

		//Buscamos campeonatos de las parejas
	}

}

?>