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

	function ADD(){ // --- TODO --- Implementar Verificación de parametros introducidos
		$sql = "INSERT INTO PISTA (ID,NOMBRE,TIPO) VALUES (NULL,'$this->nombre','$this->tipo')";
		if(!$resultado = $this->mysqli->query($sql) ){
			return 'ERROR: Fallo en la consulta sobre la base de datos';
		}else{
			return 'Pista creada correctamente';
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
