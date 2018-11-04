<?php

class RESERVE_Model{
    var $user_login;
    var $pista_ID;
    var $fecha;
    var $mensaje;
    var $mysqli;

    function __construct($user_login,$pista_ID,$fecha){
    	$this->user_login = $user_login;
    	$this->pista_ID = $pista_ID;
    	$this->mensaje['reserva_ID'] = NULL;
    	$this->fecha = $fecha;

        include_once '../Functions/Access_DB.php';
        $this->mysqli = ConnectDB();
    }



    function ADD()
    {
	 if (($this->user_login <> '') || ($this->pista_ID <> '')){ // si los atributos vienen vacios
	            // construimos el sql para buscar esa clave en la tabla
	            $sql = "SELECT * FROM RESERVA";
	            if (!$result = $this->mysqli->query($sql)){ //si da error la ejecución de la query
	                return 'ERROR: No se ha podido conectar con la base de datos'; //error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
	            }else { //si la ejecución de la query no da error
	                $num_rows = mysqli_num_rows($result);

	                if ($num _rows == 0){ //miramos si no existe el login
	                    //Construimos la sentencia sql de inserción en la bd
	                    $sql = "INSERT INTO RESERVA(
	                    USUARIO_LOGIN,
	                    PISTA_ID,
	                    FECHA) VALUES(
	                                        '$this->user_login',
	                                        '$this->pista_ID',
	                                        '$this->fecha'
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
} 

?>