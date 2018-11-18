<?php

class CAMPEONATOUSUARIO_Model{

	var $login;



	var $mysqli;

	function __construct($login){
		$this->login=$login;

		include_once '../Functions/Access_DB.php';
        $this->mysqli = ConnectDB();
	}



	//Función para obtener los campeonatos en los que participa un usuario
	function SHOWALL(){

		//Buscamos parejas registradas del usuario
		$sql_par = "SELECT * FROM PAREJA WHERE (
			(JUGADOR_1='$this->login') OR (JUGADOR_2='$this->login')
		)";

		$result_par = $this->mysqli->query($sql_par);


		while($row = mysqli_fetch_array($result_par)){
			$id_par = $row['ID'];

			//Buscamos campeonatos de las parejas
			$sql_camp = "SELECT * FROM INSCRIPCION WHERE (PAREJA_ID = '$id_par')";

		    if (!($result = $this->mysqli->query($sql_camp))){
		        $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
		        return $this->mensaje; 
		    }
		    else{ // si la busqueda es correcta devolvemos el recordset resultado
		        if($result <> NULL) {
		        	$i=0; 
		              while($row = mysqli_fetch_array($result)){ 
		              	$i++;                              
		                $listInscripciones[$row[$i]] = array($row["PAREJA_ID"],$row["CAM_CAT_ID"]);
		                }

		            }

		    } 
		}
		return $listInscripciones;

	}

}

?>