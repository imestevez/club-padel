<?php

class CONFRONTATION_Model{

	var $id;
	var $fecha;
	var $nivel;
	var $genero;
	var $grupo;
	var $resultado;
	var $pareja_1;
	var $pareja_2;
	var $reserva_id;

	var $mysql;

	function __construct($id,$fecha,$nivel,$genero,$grupo,$resultado,$pareja_1,$pareja_2,$reserva_id){

    	$this->id = $id;
    	$this->fecha = $fecha;
    	$this->nivel = $nivel;
    	$this->genero = $genero;
    	$this->grupo = $grupo;
    	$this->resultado = $resultado;
    	$this->pareja_1 = $pareja_1;
    	$this->pareja_2 = $pareja_2;
    	$this->reserva_id = $reserva_id;

        include_once '../Functions/Access_DB.php';

        $this->mysqli = ConnectDB();
    }

    function ADD(){
    	
    }
}

?>