<?php

class PISTA_Model{

	var $nombre;
    var $mysqli;

    function __construct($nombre){
    	$this->nombre = $nombre;

        include_once '../Functions/Access_DB.php';
        $this->mysqli = ConnectDB();
    }


}