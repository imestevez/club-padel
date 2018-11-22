<?php

class HORARIO_Model{
    var $id;
    var $hora_inicio;
    var $hora_fin;
    var $horarios_disponibles;
    var $horarios_full;
    var $horarios_activos;
    var $mensaje;
    var $mysqli;

    function __construct($id, $hora_inicio,$hora_fin){
        $this->id = $id;
    	$this->hora_inicio = $hora_inicio;
    	$this->hora_fin = $hora_fin;
        $this->horarios_activos = NULL;
        $this->horarios_disponibles = NULL;
        $this->horarios_full = array(
            '07:30:00' => '09:00:00',
            '09:00:00' => '10:30:00',
            '10:30:00' => '12:00:00',
            '12:00:00' => '13:30:00',
            '13:30:00' => '15:00:00',
            '15:00:00' => '16:30:00',
            '16:30:00' => '18:00:00',
            '18:00:00' => '19:30:00',
            '19:30:00' => '21:00:00',
            '21:00:00' => '22:30:00',
            '22:30:00' => '00:00:00'
        );
        include_once '../Functions/Access_DB.php';
        $this->mysqli = ConnectDB();
    }
 function ADD()
    {
        if (($this->hora_inicio <> '') || ($this->hora_fin <> '')){ // si los atributos estan vacios
            // construimos el sql para buscar esa clave en la tabla
            $sql = "SELECT * FROM HORARIO 
                    WHERE       (HORA_INICIO = '$this->hora_inicio') 
                            AND (HORA_FIN = '$this->hora_fin')";

            if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
                return 'ERROR: No se ha podido conectar con la base de datos'; //error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
            }else { //si la ejecución de la query no da error
                    $num_rows = mysqli_num_rows($resultado);
                    if($num_rows == 0){
                        $sql = "INSERT INTO HORARIO(
                        ID,
                        HORA_INICIO,
                        HORA_FIN) VALUES(
                                            NULL,
                                            '$this->hora_inicio',
                                            '$this->hora_fin'
                                            )";
                        if (!($resultado = $this->mysqli->query($sql))){ //ERROR en la consulta ADD
                            //Si no hay atributos Clave y unique duplicados es que hay campos sin completar
                            $this->mensaje['mensaje'] = 'ERROR: No se podido registrar el horario';
                            return $this->mensaje; // introduzca un valor para el usuario
                        }else{
                            $this->mensaje['mensaje'] = 'Registrado correctamente';
                            return $this->mensaje; // introduzca un valor para el usuario
                        }
                    }else{
                            $this->mensaje['mensaje'] = 'ERROR: Ya existe un horario con eses datos';
                            return $this->mensaje; // introduzca un valor para el usuario
                    }

            }
        }else{ 
                $this->mensaje['mensaje'] = 'ERROR: Introduzca todos los valores de todos los campos'; // Itroduzca un valor para el usuario
                return $this->mensaje;
        }
                    
    } // fin del metodo ADD

    function DELETE(){
        $sql = "DELETE FROM HORARIO WHERE (ID = $this->id)";

        if(!$resultado = $this->mysqli->query($sql) ){
          return 'ERROR: Fallo en la consulta sobre la base de datos'; 
        }else{
            $this->mensaje['mensaje'] = 'Borrado correctamente';
            return $this->mensaje;
        }
    }// fin del método DELETE

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

    function SHOW_Disponibles(){

        $sql = "SELECT * FROM HORARIO ORDER BY HORA_INICIO";
            // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            return 'ERROR: Fallo en la consulta sobre la base de datos'; 
        }
        else{ 
            if($resultado <> NULL){
                while ($row = mysqli_fetch_array($resultado)) {
                    $this->horarios_activos[$row["HORA_INICIO"]] = $row["HORA_FIN"];

                }//fin del while
            }//fin del if
            if( $this->horarios_activos == NULL){
                return $this->horarios_full;

            }else{
                foreach ($this->horarios_full as $key => $value) {
                    if(!array_key_exists($key, $this->horarios_activos)){

                        $this->horarios_disponibles[$key] = $value;
                    }
                 } 
                 return $this->horarios_disponibles;
            }//fin de else
        }//fin de else
    }// fin del método SHOW_Disponibles
}//fin clase
?>