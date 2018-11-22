<?php
class PISTA_Model{
	var $id;
	var $nombre;
	var $tipo;
	var $mysqli;

	function __construct($id, $nombre, $tipo){
		$this->id = $id;
		$this->nombre = $nombre;
		$this->tipo = $tipo;

		include_once '../Functions/Access_DB.php';
		$this->mysqli = ConnectDB();
	}

	function SHOWALL(){
		$sql = "SELECT * FROM PISTA ORDER BY ID";
		if (!($resultado = $this->mysqli->query($sql))){
			$this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos';
			return $this->mensaje;
		}
		else{
			return $resultado;
		}
	}

	function ADD(){ 
        if (($this->nombre <> '') || ($this->tipo <> '') ){ // si los atributos estan vacios
			
			$sql = "SELECT * FROM PISTA WHERE (NOMBRE = '$this->nombre')";
			 if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
                return 'ERROR: No se ha podido conectar con la base de datos'; //error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
            }else { //si la ejecución de la query no da error
                    $num_rows = mysqli_num_rows($resultado);
                    if($num_rows == 0){
						$sql = "INSERT INTO PISTA (ID,NOMBRE,TIPO) VALUES (NULL,'$this->nombre','$this->tipo')";
						if(!$resultado = $this->mysqli->query($sql) ){
							return 'ERROR: Fallo en la consulta sobre la base de datos';
						}else{
							return 'Pista creada correctamente';
						}
					}else{
						return 'ERROR: Ya existe una pista con ese nombre';
					}
				}
		}else{
			$this->mensaje['mensaje'] = 'ERROR: Introduzca todos los valores de todos los campos'; // Itroduzca un valor para el usuario
            return $this->mensaje;
		}

	}

		function DELETE(){
			$sql = "DELETE FROM PISTA WHERE (ID = $this->id)";
			if(!$resultado = $this->mysqli->query($sql) ){
				return 'ERROR: Fallo en la consulta sobre la base de datos';
			}else{
				return 'Pista borrada correctamente';
			}
		}


		function SEARCH(){ // --- TODO --- Se utiliza en algún caso de uso???
			$sql = "SELECT ID FROM PISTA
			ORDER BY ID";

			if (!($resultado = $this->mysqli->query($sql))){
				$this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos';
				//  return $this->mensaje;
			}
			else{ // si la busqueda es correcta devolvemos el recordset resultado
				// return $resultado;
			}
		}//fin del  método SEARCH


	}
	?>
