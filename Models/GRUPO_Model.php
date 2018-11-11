<?php

	class Grupo_Model
	{
		var $id;
		var $campeonato_id;
		var $categoria_id;

		var $mysqli;

		function __construct($id,$campeonato_id,$categoria_id)
		{
			$this->id = $id;
			$this->campeonato_id = $campeonato_id;
			$this->categoria_id = $categoria_id;

			include_once '../Functions/Access_DB.php';

        	$this->mysqli = ConnectDB();
		}
	}

	function ADD(){
		
		$sql = "INSERT INTO GRUPO(ID,NOMBRE,CAMPEONATO_ID,CATEGORIA_ID) VALUES(null,'$this->nombre','$this->campeonato_id','$this->categoria_id')";

		$result = $this->mysqli->query($sql);
	}

?>