<?php

class PAREJA_Model{

	var $login1;
	var $login2;
	var $captain;

	var $mensaje;
	var $mysqli;

	function __construct($login1, $login2, $captain){

		$this->login1 = $login1;
		$this->login2 = $login2;
		$this->captain = $captain;

		include_once '../Functions/Access_DB.php';
        $this->mysqli = ConnectDB();

	}

	//Función para registar una nueva pareja
	function ADD(){

		//Comprobación de que los logins introducidos están registrados como usuarios
		$sql_log1 = "SELECT * FROM USUARIO WHERE (login='$this->login1')";
		$sql_log2 = "SELECT * FROM USUARIO WHERE (login='$this->login2')";
		$sql_cap = "SELECT * FROM USUARIO WHERE (login='$this->captain')";

		$result_log1 = $this->mysqli->query($sql_log1);
		$result_log2 = $this->mysqli->query($sql_log2);
		$result_cap = $this->mysqli->query($sql_cap);

		//Sentencias de comprobacón de tuplas coincidentes con los datos recibidos
		$sql_c1 = "SELECT * FROM PAREJA WHERE 
			(
				(JUGADOR_1 = '$this->login1') AND
				(JUGADOR_2 = '$this->login2') AND
				(CAPITAN = '$this->captain') 
			)";

		$sql_c2 = "SELECT * FROM PAREJA WHERE 
			(
				(JUGADOR_2 = '$this->login1') AND
				(JUGADOR_1 = '$this->login2') AND
				(CAPITAN = '$this->captain') 
			)";

		$result_c1 = $this->mysqli->query($sql_c1);
		$result_c2 = $this->mysqli->query($sql_c2);	

		//Sentencia de creación de la pareja
		$sql = "INSERT INTO PAREJA(ID,JUGADOR_1, JUGADOR_2, CAPITAN) VALUES(0,'$this->login1','$this->login2','$this->captain')";

		if($result_log1 and $result_log2 and $result_cap){
			//Comprobación de que los miembros de la pareja son usuarios distintos

			if($this->login1 <> $this->login2){
				//Comprobación de que alguno de los miembros del equipo es el capitan
				if( ($this->login1 == $this->captain) or ($this->login2 == $this->captain) ){
					//Comprobacón de tuplas coincidentes con los datos recibidos
					if($result_c1 and $result_c2){
						$num_rows_c1 = mysqli_num_rows($result_c1);
						$num_rows_c2 = mysqli_num_rows($result_c2);
						if(($num_rows_c1 == 0) and ($num_rows_c2 == 0)){
							//Creación de la pareja
							if(!($result = $this->mysqli->query($sql))){
								$this->mensaje = "ERROR: En la sentencia sql.";
							}
							else{
								$this->mensaje = "Pareja registrada con éxito";
							}
						}
						else{
							$this->mensaje = "ERROR: Esa pareja ya ha sido registrada.";
						}
					}
					else{
						$this->mensaje = "ERROR: Los logins proporcionados no pertenecen a usuarios del sistema.";	
					}
				}
				else{
					$this->mensaje = "ERROR: El capitan debe ser un de los miembros de la pareja.";	
				}
			}
			else{
				$this->mensaje = "ERROR: Los miembros de la pareja deben ser distintos usuarios.";
			}
		}
		else{
			$this->mensaje = "ERROR: Alguno de los miembros de la pareja no está registrado como usuario.";
		}
		return $this->mensaje;
	}
	function SHOW_DEPORTISTAS($pareja_ID){
		$sql = "SELECT * FROM PAREJA WHERE (ID = '$pareja_ID')";
		if (!($resultado = $this->mysqli->query($sql))){
            return 'ERROR: Fallo en la consulta sobre la base de datos'; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        } 
	}

	function GET_ID(){
        
		$sql = "SELECT ID FROM PAREJA WHERE (
				((JUGADOR_1 = '$this->login1') AND
				(JUGADOR_2 = '$this->login2') AND
				(CAPITAN = '$this->captain') ) 
				OR
				((JUGADOR_2 = '$this->login1') AND
				(JUGADOR_1 = '$this->login2') AND
				(CAPITAN = '$this->captain')) 
				) ";
		if (!($resultado = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
           return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
        	$row=mysqli_fetch_array($resultado);
            return $row["ID"];
        } 
	}
}

?>