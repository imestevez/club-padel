<?php

	class GRUPO_Model
	{
		var $campeonato_id;
		var $categoria_id;
		var $nombre;

		var $mysqli;

		function __construct($nombre,$campeonato_id,$categoria_id)
		{
			$this->nombre = $nombre;
			$this->campeonato_id = $campeonato_id;
			$this->categoria_id = $categoria_id;

			include_once '../Functions/Access_DB.php';
			include_once '../Models/FINALISTA_CAMPEONATO_Model.php';

        	$this->mysqli = ConnectDB();
		}
	

	function ADD(){
		
		$sql = "INSERT INTO GRUPO(ID,NOMBRE,CAMPEONATO_ID,CATEGORIA_ID) VALUES(null,'$this->nombre','$this->campeonato_id','$this->categoria_id')";

		$result = $this->mysqli->query($sql);
	}

	

	
	

	}

?>