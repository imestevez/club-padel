<?php

class PARTIDO_Model{
    var $id;
    var $fecha;
    var $reserva_ID;
    var $horario;
    var $pista_ID;
    var $inscripciones;
    var $mensaje;
    var $mysqli;

    function __construct($id, $fecha,$reserva_ID, $horario_ID, $pista_ID,$inscripciones){
        $this->id = $id;
        if($fecha <> NULL){   //si viene la fecha entera le cambiamos el formato para que se adecue al de la bd
            $aux = explode("/", $fecha);
            $this->fecha = date('Y-m-d',mktime(0,0,0,$aux[1],$aux[0],$aux[2]));
        }
    	$this->reserva_ID = $reserva_ID;
        $this->horario_ID = $horario_ID;
        $this->pista_ID = $pista_ID;
        $this->inscripciones = $inscripciones;

        include_once '../Functions/Access_DB.php';
        $this->mysqli = ConnectDB();
    }

    function ADD()
    {
        if (($this->fecha <> '') || ($this->horario_ID <> '') || ($this->pista_ID <> '') ){ // si los atributos estan vacios
            // construimos el sql para buscar esa clave en la tabla
            $sql = "SELECT * FROM PARTIDO 
                    WHERE       (FECHA = '$this->fecha') 
                            AND (HORARIO_ID = '$this->horario_ID')
                            AND (PISTA_ID = '$this->pista_ID')";

            if (!$result = $this->mysqli->query($sql)){ //si da error la ejecución de la query
                return 'ERROR: No se ha podido conectar con la base de datos'; //error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
            }else { //si la ejecución de la query no da error
                    
                        $sql = "INSERT INTO PARTIDO(
                        ID,
                        FECHA,
                        RESERVA_ID,
                        HORARIO_ID,
                        PISTA_ID,
                        INSCRIPCIONES) VALUES(
                                            NULL,
                                            '$this->fecha',
                                            NULL,
                                            '$this->horario_ID',
                                            '$this->pista_ID',
                                            '0'
                                            )";
                        if (!($result = $this->mysqli->query($sql))){ //ERROR en la consulta ADD
                            //Si no hay atributos Clave y unique duplicados es que hay campos sin completar
                            $this->mensaje['mensaje'] = 'ERROR: No se podido registrar el partido';
                            return $this->mensaje; // introduzca un valor para el usuario
                        }else{
                            //$this->mensaje['partido_ID'] = mysql_insert_id();
    	                    $this->mensaje['mensaje'] = 'Registrado correctamente';
                            return $this->mensaje; // introduzca un valor para el usuario
                        }

            }
        }else{ //Si no se introduce un login
                $this->mensaje['mensaje'] = 'ERROR: Introduzca todos los valores de todos los campos'; // Itroduzca un valor para el usuario
                return $this->mensaje;
        }
                    
    } // fin del metodo ADD


    function SHOWALL(){

    $sql = "SELECT P.ID, P.FECHA, P.PISTA_ID, P.HORARIO_ID, P.INSCRIPCIONES, H.HORA_INICIO, H.HORA_FIN
            FROM PARTIDO P, HORARIO H
            WHERE      (H.ID = P.HORARIO_ID)
            ORDER BY P.ID";

            // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
            return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }  
    }// fin del método SHOWALL_Horarios

    function DELETE(){

        $sql = "DELETE FROM PARTIDO WHERE (ID = $this->id)";

        if(!$resultado = $this->mysqli->query($sql) ){
            return 'ERROR: Fallo en la consulta sobre la base de datos'; 
        }else{
            return 'Borrado correctamente';
        }
    }// fin del método DELETE
}
?>