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
		$listCampeonatos = NULL;

		while($row = mysqli_fetch_array($result_par)){
			$id_par = $row['ID'];
			/*
			$sql = "SELECT U.NOMBRE AS NOMBRE_USUARIO, CAT.NIVEL, CAT.GENERO, CAM.NOMBRE AS NOMBRE_CAMPEONATO
	                FROM USUARIO U, PAREJA P, INSCRIPCION I, CATEGORIA CAT, CAMPEONATO_CATEGORIA CAM_CAT, CAMPEONATO CAM
	                WHERE      ( (P.ID = '$id_par')
	                		AND (U.LOGIN = P.JUGADOR_2) 
	                        AND (P.ID = I.PAREJA_ID)
	                        AND (CAT.ID = I.CAM_CAT_ID) 
	                        AND (CAT.ID = CAM_CAT.CATEGORIA_ID)
	                        AND (CAM.ID = CAM_CAT.CAMPEONATO_ID))     
	                ORDER BY 4,2,3";
	        */
	        $sql = "SELECT  	CM.NOMBRE AS CAMPEONATO_NOMBRE,
	        					CT.NIVEL,
	        					CT.GENERO,
	        					P.JUGADOR_1,
	        					P.JUGADOR_2,
	        					I.GRUPO_ID

	        					FROM
	        					PAREJA P,
	        					INSCRIPCION I,
	        					CAMPEONATO_CATEGORIA CC,
	        					CAMPEONATO CM,
	        					CATEGORIA CT

	        					WHERE
	        					(I.PAREJA_ID = P.ID) AND
	        					(CC.ID = I.CAM_CAT_ID) AND
	        					(CC.CAMPEONATO_ID = CM.ID) AND
	        					(CC.CATEGORIA_ID = CT.ID) AND
	        					(I.PAREJA_ID = '$id_par')";

	            // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
	        if (!($resultado = $this->mysqli->query($sql))){
	            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
	            return $this->mensaje; 
	        }
	        else{ // si la busqueda es correcta devolvemos el recordset resultado
	            if($resultado <> NULL) {
	            	$i =0;
	                  while($row = mysqli_fetch_array($resultado)){   

	                  	$jugador_1 = $row['JUGADOR_1'];
	                  	$jugador_2 = $row['JUGADOR_2'];

	                  	$categoria_nombre = $row['NIVEL']." ".$row['GENERO'];

	                  	$grupo_id = $row['GRUPO_ID'];

	                  	$grupo_nombre = NULL;

	                  	if($grupo_id <> NULL){
	                  		//Buscamos el nombre del grupo
	                  		$sql_gr = "SELECT NOMBRE AS NOMBRE_GRUPO FROM GRUPO WHERE (ID = '$grupo_id')";
	                  		$res_gr = $this->mysqli->query($sql_gr);

	                  		if($row_grupo = mysqli_fetch_array($res_gr)){
	                  			$grupo_nombre = $row_grupo['NOMBRE_GRUPO'];
	                  		}
	                  		
	                  	}
	                  	else{
	                  		$grupo_nombre = "Sin asignar";
	                  	}

	                  	if($this->login == $jugador_1){
	                  		$listCampeonatos[$i] = array($row['CAMPEONATO_NOMBRE'],$categoria_nombre,$grupo_nombre,$jugador_2);
	                    	
	                  	}else{
	                  		$listCampeonatos[$i] = array($row['CAMPEONATO_NOMBRE'],$categoria_nombre,$grupo_nombre,$jugador_1);
	                  	}                             
	                  	$i++;
	                    
	                }   
	            }

	        }  
	    }

		return $listCampeonatos;

	}

}

?>