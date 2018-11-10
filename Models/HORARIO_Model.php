<?php

class HORARIO_Model{
    var $id;
    var $hora_inicio;
    var $hora_fin;
    var $mensaje;
    var $mysqli;

    function __construct($id, $hora_inicio,$hora_fin){
        $this->id = $id;
    	$this->hora_inicio = $hora_inicio;
    	$this->hora_fin = $hora_fin;

        include_once '../Functions/Access_DB.php';
        $this->mysqli = ConnectDB();
    }

    function SHOWALL(){

    $sql = "SELECT * FROM HORARIO ORDER BY HORA_INICIO";
            // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
            return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }  
    }// fin del método SHOWALL

    function SHOW(){

    $sql = "SELECT * FROM HORARIO WHERE ID = '$this->id' ORDER BY HORA_INICIO";
            // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
            return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }  
    }// fin del método SHOW
}//fin clase
?>