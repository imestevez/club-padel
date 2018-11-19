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
		$sql_par = "SELECT * FROM PAREJA WHERE (
			(JUGADOR_1='$this->login') OR (JUGADOR_2='$this->login')
		)";

		$result_par = $this->mysqli->query($sql_par);


		while($row = mysqli_fetch_array($result_par)){
			$id_par = $row['ID'];
			$sql = "SELECT U.NOMBRE AS NOMBRE_USUARIO, CAT.NIVEL, CAT.GENERO, CAM.NOMBRE
	                FROM USUARIO U, PAREJA P, INSCRIPCION I, CATEGORIA CAT, CAMPEONATO_CATEGORIA CAM_CAT, CAMPEONATO CAM
	                WHERE      ( (P.ID = '$id_par')
	                		AND (U.LOGIN = P.JUGADOR_2) 
	                        AND (P.ID = I.PAREJA_ID)
	                        AND (CAT.ID = I.CAM_CAT_ID) 
	                        AND (CAT.ID = CAM_CAT.CATEGORIA_ID)
	                        AND (CAM.ID = CAM_CAT.CAMPEONATO_ID))     
	                ORDER BY CAM.NOMBRE";
	            // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
	        if (!($resultado = $this->mysqli->query($sql))){
	            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
	            return $this->mensaje; 
	        }
	        else{ // si la busqueda es correcta devolvemos el recordset resultado
	            if($resultado <> NULL) {
	            	$i =0;
	                  while($row = mysqli_fetch_array($resultado)){                                
	                    $listCampeonatos[$row[$i]] = array($row["NOMBRE_USUARIO"],$row["NIVEL"],$row["GENERO"],$row["NOMBRE"]);
	                    $i++;
	                    }   
	                }

	        }  
	    }
		return $listCampeonatos;

	}

}

?>