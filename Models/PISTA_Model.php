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
    function ADD()
    {
	 if (($this->nombre <> '') || ($this->tipo <> '')){ // si los atributos vienen vacios
	            // construimos el sql para buscar esa clave en la tabla
	            $sql = "SELECT * FROM PISTA";
	            if (!$result = $this->mysqli->query($sql)){ //si da error la ejecución de la query
	                return 'ERROR: No se ha podido conectar con la base de datos'; //error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
	            }else { //si la ejecución de la query no da error
	                $num_rows = mysqli_num_rows($result);

	                if ($num_rows == 0){ //miramos si no existe el login
	                    //Construimos la sentencia sql de inserción en la bd
	                    $sql = "INSERT INTO PISTA(
	                    ID,
	                    NOMBRE,
	                    TIPO) VALUES(
	                    					NULL,
	                                        '$this->nombre',
	                                        '$this->tipo'
	                                    )";
	                    
	                    if (!($result = $this->mysqli->query($sql))){ //ERROR en la consulta ADD
		                    $this->mensaje['mensaje'] = 'ERROR: Introduzca todos los valores de todos los campos';
	                        return $this->mensaje; // introduzca un valor para el usuario
	                    }
	                    else{
	                    	$this->mensaje['reserva_ID'] = mysql_insert_id();
                    	    $this->mensaje['mensaje'] = 'Registrado correctamente';
                        return $this->mensaje; // introduzca un valor para el usuario
	                    }
	                }else{ //si hay un login igual
	                   // return 'ERROR: El login introducido ya existe'; 
	                }
	            }
        }else{ //Si no se introduce un login
                $this->mensaje['mensaje'] = 'ERROR: Introduzca todos los valores de todos los campos'; // Itroduzca un valor para el usuario
                return $this->mensaje;
        }
	                    
    } // fin del metodo ADD

    function SEARCH(){
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

      function SHOWALL(){
		$sql = "SELECT * FROM PISTA ORDER BY ID";
        if (!($resultado = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
           return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        } 
    }//fin del  método SHOWALL
}
?>