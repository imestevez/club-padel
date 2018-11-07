<?php

class CHAMPIONSHIP_Model{

    var $nombre;
	var $fecha;
    var $mensaje;

	var $mysql;

	function __construct($nombre,$fecha){

        $this->nombre = $nombre;
    	$this->fecha = $fecha;

        include_once '../Functions/Access_DB.php';

        $this->mysqli = ConnectDB();
    }

    //Función añadir un campeonato a la bd
    function ADD(){
 
        $sql = "INSERT INTO CAMPEONATO(ID,NOMBRE, FECHA) 
                VALUES( 0,
                        '$this->nombre',
                        '$this->fecha')"; 

        $result = $this->mysqli->query($sql);

        if($result){
            $this->mensaje = "Campeonato registrado correctamente";
        }
        else{
           $this->mensaje = "ERROR: No se ha realizado el registro correctamente"; 
        }
        return $this->mensaje;                      
    }

    //Mostramos todos los campeonatos
    function SHOWALL(){

        $sql = "SELECT * FROM CAMPEONATO";
        $result = $this->mysqli->query($sql);
        if($result){
            //Devolvemos recordset de campeonatos
            return $result;
        }
        else{
            $this->mensaje = "ERROR: En la consulta de la base de datos.";
        }

    }
}

?>