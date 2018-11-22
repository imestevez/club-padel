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
        $this->max_inscripciones = 4;

        include_once '../Functions/Access_DB.php';
        $this->mysqli = ConnectDB();
        $this->UPDATE();
    }
    function CHECK_INSCRIPCIONES(){
        $sql = "SELECT INSCRIPCIONES FROM PARTIDO WHERE ID = '$this->partido_ID'";

        if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            $this->mensaje['mensaje'] = 'ERROR: No se ha podido conectar con la base de datos'; //error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
            return NULL;
        }else { //si la ejecución de la query no da error
            $row = mysqli_fetch_array($resultado);
            return $row[0];
        }
    }//fin CHECK_INSCRIPCIONES

    function ADD()
    {
        if (($this->login <> '') || ($this->partido_ID <> '') ){ // si los atributos estan vacios
            
            if($this->CHECK_INSCRIPCIONES() < $this->max_inscripciones){

                // construimos el sql para buscar esa clave en la tabla
                $sql = "SELECT * FROM USUARIO_PARTIDO 
                        WHERE  (USUARIO_LOGIN = '$this->login') 
                            AND (PARTIDO_ID = '$this->partido_ID')";

                if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
                    return 'ERROR: No se ha podido conectar con la base de datos'; //error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
                }else { //si la ejecución de la query no da error
                     $num_rows = mysqli_num_rows($resultado);
                    if($num_rows == 0){    
                        $sql = "INSERT INTO USUARIO_PARTIDO(
                        ID,
                        USUARIO_LOGIN,
                        PARTIDO_ID) VALUES(
                                            NULL,
                                            '$this->login',
                                            '$this->partido_ID')";
                        if (!($resultado = $this->mysqli->query($sql))){ //ERROR en la consulta ADD
                            //Si no hay atributos Clave y unique duplicados es que hay campos sin completar
                            $this->mensaje['mensaje'] = 'ERROR: No se podido inscribir al usuario';
                            return $this->mensaje; // introduzca un valor para el usuario
                        }else{
                            if($this->UPDATE() == true){
                                $this->mensaje['mensaje'] = "Inscrito en el partido correctamente";
                            }
                            return $this->mensaje; 
                        }
                    }else{
                       $this->mensaje['mensaje'] = 'ERROR: El usuario ya esta inscrito en este partido';
                        return $this->mensaje; // introduzca un valor para el usuario
                    }
                }
            }else{ //si se llego al maximo de inscripciones
                return $this->mensaje;
            }
        }else{ //Si no se introduce un login
                $this->mensaje['mensaje'] = 'ERROR: Introduzca todos los valores de todos los campos'; // Itroduzca un valor para el usuario
                return $this->mensaje;
        }
    } // fin del metodo ADD

    function UPDATE(){

        $sql = "SELECT * FROM PARTIDO";

        if (!($resultado = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
            return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
           $num_rows = mysqli_num_rows($resultado);
            $list = NULL;
           while ($row = mysqli_fetch_array($resultado)) {
                $list[$row["ID"]] = $row["INSCRIPCIONES"];
            } //fin while 
            if($list <> NULL){
                foreach ($list as $key => $value) {
                    $sql = "UPDATE PARTIDO SET INSCRIPCIONES = (SELECT COUNT(*) 
                                                                    FROM USUARIO_PARTIDO 
                                                                    WHERE (PARTIDO_ID = '$key')  ) 
                            WHERE ID = '$key'";
                    if(!$resultado = $this->mysqli->query($sql)){
                       $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos';
                    }
                }//fin del foreach
            }//fin del id
            return true;
        }//fin else
    }  // fin del metodo UPDATE 

    function SHOW_INSCRITOS(){
        $sql = "SELECT * FROM USUARIO_PARTIDO UP , USUARIO U, PARTIDO P, HORARIO H
                WHERE (UP.PARTIDO_ID = '$this->partido_ID') AND (UP.USUARIO_LOGIN = U.LOGIN)  AND (P.ID = '$this->partido_ID') AND (H.ID = P.HORARIO_ID)";
        if(!$resultado = $this->mysqli->query($sql) ){
            return 'ERROR: Fallo en la consulta sobre la base de datos'; 
        }else{
            return $resultado;
        }
    }// fin SHOW_INSCRITOS

    function DELETE(){

        $sql = "DELETE FROM USUARIO_PARTIDO WHERE (USUARIO_LOGIN = '$this->login') AND (PARTIDO_ID = '$this->partido_ID')";
        if(!$resultado = $this->mysqli->query($sql) ){
            return 'ERROR: Fallo en la consulta sobre la base de datos'; 
        }else{
                                //$this->mensaje['partido_ID'] = mysql_insert_id();
           if($this->UPDATE() == true){
                $this->mensaje['mensaje'] = "Dado de baja del partido correctamente";
            }
            return $this->mensaje; // introduzca un valor para el usuario
        }
    }// fin del método DELETE
}
?>