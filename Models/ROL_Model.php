<?php
class ROL_Model{
	var $id;
	var $nombre;
	var $mysqli;

	function __construct($id, $nombre){
		$this->id = $id;
		$this->nombre = $nombre;

		include_once '../Functions/Access_DB.php';
		$this->mysqli = ConnectDB();
	}

	function SHOWALL(){
		$sql = "SELECT * FROM ROL ORDER BY ID";
		if (!($resultado = $this->mysqli->query($sql))){
			$this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos';
			return $this->mensaje;
		}
		else{
			return $resultado;
		}
	}

	}
	?>
