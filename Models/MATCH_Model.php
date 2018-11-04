<?php

class MATCH_Model{
    var $fecha;
    var $reserva_ID;
    var $mensaje;
    var $mysqli;

    function __construct($fecha,$reserva_ID){
    	$this->fecha = $fecha;
    	$this->reserva_ID = $reserva_ID;

        include_once '../Functions/Access_DB.php';
        $this->mysqli = ConnectDB();
    }

    function ADD()
    {
        if (($this->FECHA <> '') || ($this->reserva_ID <> '')){ // si los atributos estan vacios
            // construimos el sql para buscar esa clave en la tabla
            $sql = "SELECT * FROM PARTDO";
            if (!$result = $this->mysqli->query($sql)){ //si da error la ejecución de la query
                return 'ERROR: No se ha podido conectar con la base de datos'; //error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
            }else { //si la ejecución de la query no da error
                $num_rows = mysqli_num_rows($result);

                    $sql = "INSERT INTO USUARIO(
                    FECHA,
                    RESERVA_ID) VALUES(
                                        '$this->fecha',
                                        '$this->reserva_ID'
                                        )";
                    
                    if (!($result = $this->mysqli->query($sql))){ //ERROR en la consulta ADD
                        //Si no hay atributos Clave y unique duplicados es que hay campos sin completar
                        $this->mensaje['mensaje'] = 'ERROR: Introduzca todos los valores de todos los campos';
                        return $this->mensaje; // introduzca un valor para el usuario
                    }
                    else{
                        $this->mensaje['partido_ID'] = mysql_insert_id();
	                    $this->mensaje['mensaje'] = 'Registrado correctamente';
                        return $this->mensaje; // introduzca un valor para el usuario
                    }
                }else{ //si hay un login igual
                	$this->mensaje['mensaje'] = 'ERROR: El login introducido ya existe';
                    return $this->mensaje; 
                }
            }
        }else{ //Si no se introduce un login
                $this->mensaje['mensaje'] = 'ERROR: Introduzca todos los valores de todos los campos'; // Itroduzca un valor para el usuario
                return $this->mensaje;
        }
                    
    } // fin del metodo ADD


    function SHOWALL(){

        $sql = 'SELECT PA.FECHA, PI.NOMBRE
                FROM PARTIDO PA, RESERVA R, PISTA PI
                WHERE (PA.RESERVA_ID = R.ID) AND (R.PISTA_ID = PI.ID)
                GROUP BY PA.ID';
    }
}
?>