<?php

/**
 * 
 */
class FINALISTA_CAMPEONATO_Model 
{

	var $grupo_id;
	var $pareja_id;
	var $etapa;
	var $puntos;
	var $mysqli;
	
	function __construct($grupo_id, $pareja_id, $etapa, $puntos)
	{
		$this->grupo_id = $grupo_id;
		$this->pareja_id = $pareja_id;
		$this->etapa = $etapa;
		$this->puntos = $puntos;

		include_once '../Functions/Access_DB.php';

        $this->mysqli = ConnectDB();
	}

	function ADD(){
        var_dump("AÑDIENDO UN FINALISTA: ".$this->grupo_id." ".$this->pareja_id." ".$this->etapa." ".$this->puntos." ");
        $fecha_act = date("Y-m-d");

		$sql = "INSERT INTO FINALISTA_CAMPEONATO(
								GRUPO_ID,
								PAREJA_ID,
								ETAPA,
								PUNTOS,
								FECHA)
								VALUES(
								'$this->grupo_id',
								'$this->pareja_id',
								'$this->etapa',
								'$this->puntos',
								'$fecha_act'
								)";
								var_dump("SQL DE INSERTAR FIN: ".$sql);
		$result = $this->mysqli->query($sql);								
	}

	//Función que cambia a las parejas de etapa en el campeonato si han ganado
	function GANAR(){

	}
}

?>