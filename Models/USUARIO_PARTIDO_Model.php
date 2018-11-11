<?php

class USUARIO_PARTIDO_Model{
    var $id;
    var $login;
    var $partido_ID;
    var $mensaje;
    var $mysqli;

    function __construct($id,$login,$partido_ID){
        $this->id = $id;
        $this->login = $login;
        $this->partido_ID = $partido_ID;

        include_once '../Functions/Access_DB.php';
        $this->mysqli = ConnectDB();
    }

    function ADD()
    {
        if (($this->login <> '') || ($this->partido_ID <> '') ){ // si los atributos estan vacios
            // construimos el sql para buscar esa clave en la tabla
            $sql = "SELECT * FROM USUARIO_PARTIDO ";

            if (!$result = $this->mysqli->query($sql)){ //si da error la ejecución de la query
                return 'ERROR: No se ha podido conectar con la base de datos'; //error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
            }else { //si la ejecución de la query no da error
                    
                $sql = "INSERT INTO USUARIO_PARTIDO(
                ID,
                USUARIO_LOGIN,
                PARTIDO_ID) VALUES(
                                    NULL,
                                    '$this->login',
                                    '$this->partido_ID')";
                var_dump("\n\n\n".$sql);
                if (!($result = $this->mysqli->query($sql))){ //ERROR en la consulta ADD
                    //Si no hay atributos Clave y unique duplicados es que hay campos sin completar
                    $this->mensaje['mensaje'] = 'ERROR: No se podido inscribir al usuario';
                    return $this->mensaje; // introduzca un valor para el usuario
                }else{
                    //$this->mensaje['partido_ID'] = mysql_insert_id();
                    $this->mensaje['mensaje'] = $this->UPDATE_PARTIDO();
                    return $this->mensaje; // introduzca un valor para el usuario
                }
            }
        }else{ //Si no se introduce un login
                $this->mensaje['mensaje'] = 'ERROR: Introduzca todos los valores de todos los campos'; // Itroduzca un valor para el usuario
                return $this->mensaje;
        }
                    
    } // fin del metodo ADD
    function UPDATE_PARTIDO(){
       $sql = "SELECT INSCRIPCIONES FROM PARTIDO WHERE (ID = '$this->partido_ID')";
        if(!$resultado = $this->mysqli->query($sql) ){
            return 'ERROR: Fallo en la consulta sobre la base de datos'; 
        }else{

            $row = mysqli_fetch_array($resultado);
            $inscripciones_old = $row['INSCRIPCIONES'];
            $inscripciones_new =  $inscripciones_old + 1;

            $sql = "UPDATE PARTIDO SET INSCRIPCIONES = '$inscripciones_new'
                    WHERE ID = '$this->partido_ID'";

             if(!$resultado = $this->mysqli->query($sql) ){
                return 'ERROR: Fallo en la consulta sobre la base de datos'; 
            }else{
                return 'Registrado correctamente';
            }
        }
    }//fin del update
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