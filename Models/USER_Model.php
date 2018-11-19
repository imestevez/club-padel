<?php

class USER_Model{
    var $login;
    var $password;
    var $nombre;
    var $apellidos;
    var $genero;
    var $rol_ID;

    var $mysqli;

    function __construct($login,$password,$nombre,$apellidos, $genero, $rol_ID){
        $this->login = $login;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->genero = $genero;
        $this->rol_ID = $rol_ID;

        include_once '../Functions/Access_DB.php';
        $this->mysqli = ConnectDB();
    }

    function login(){

        $sql = "SELECT * FROM USUARIO WHERE (
            (LOGIN = '$this->login')
        )";

        $res = $this->mysqli->query($sql);
        $num_rows = mysqli_num_rows($res);

        if ($num_rows == 0){ //si hay 0 tuplas con ese login
            return 'ERROR: El login no existe';
        }
        else{//si no hay 0 tuplas
            $tupla = $res->fetch_array();
            if ($tupla['PASSWORD'] == $this->password){//si coinciden las contraseñas
                return true;
            }
            else{//si no coinciden las contraseñas
                return 'ERROR: La contraseña para este usuario no es correcta';
            }
        }    
    }

    function ADD()
    {
        if (  ($this->login <> '') || ($this->password <> '') || ($this->nombre <> '') 
            ||  ($this->apellidos <> '') || ($this->genero <> '') || ($this->rol_ID <> '') ){ // si el atributo clave de la entidad no esta vacio
            // construimos el sql para buscar esa clave en la tabla
            $sql = "SELECT * FROM USUARIO WHERE (login = '$this->login')"; //comprobar que no hay claves iguales

            if (!$result = $this->mysqli->query($sql)){ //si da error la ejecución de la query
                return 'ERROR: No se ha podido conectar con la base de datos'; //error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
            }else { //si la ejecución de la query no da error
                $num_rows = mysqli_num_rows($result); 
                if ($num_rows == 0){ //miramos si no existe el login
                    //Construimos la sentencia sql de inserción en la bd
                    $sql = "INSERT INTO USUARIO(
                    LOGIN,
                    PASSWORD,
                    NOMBRE,
                    APELLIDOS,
                    GENERO,
                    ROL_ID) VALUES(
                                        '$this->login',
                                        '$this->password',
                                        '$this->nombre',
                                        '$this->apellidos',
                                        '$this->genero',
                                        '$this->rol_ID'
                                    )";
                    
                    if (!($result = $this->mysqli->query($sql))){ //ERROR en la consulta ADD
                        //Si no hay atributos Clave y unique duplicados es que hay campos sin completar
                        return 'ERROR: Introduzca todos los valores de todos los campos'; // introduzca un valor para el usuario
                    }
                    else{
                        return "Registrado correctamente";
                    }
                }else{ //si hay un login igual
                    return 'ERROR: El login introducido ya existe'; 
                }
            }
        }else{ //Si no se introduce un login
                return 'ERROR: Introduzca todos los valores de todos los campos'; // introduzca un valor para el usuario
        }
                    
    } // fin del metodo ADD
    function GET_ROL(){
        $sql = "SELECT R.NOMBRE FROM ROL R, USUARIO U
                WHERE (U.LOGIN = '$this->login') AND (U.ROL_ID = R.ID) ";

        if (!($result = $this->mysqli->query($sql))){ 
                return NULL; //error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
        }
        else{
            $rol = mysqli_fetch_array($result); 
            return $rol["NOMBRE"];
        }
    }//fin metodo GET_ROL

    function SHOWALL(){
        $sql = "SELECT *, R.NOMBRE AS ROL FROM ROL R, USUARIO U
                WHERE  (U.ROL_ID = R.ID) ";

        if (!($resultado = $this->mysqli->query($sql))){ 
                return NULL; //error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
        }
        else{
            return $resultado;
        }
    }//fin metodo SHOWALL

    function SHOWCURRENT(){
        $sql = "SELECT * FROM USUARIO
                WHERE  (LOGIN = '$this->login') ";
        if (!($resultado = $this->mysqli->query($sql))){ 
                return NULL; //error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
        }
        else{
            return $resultado;
        }
    }//fin metodo SHOWCURRENT

    function EDIT(){
      if (  ($this->login <> '') || ($this->password <> '') || ($this->nombre <> '') 
            ||  ($this->apellidos <> '') || ($this->genero <> '') || ($this->rol_ID <> '') ){ // si el atributo clave de la entidad no esta vacio
            // construimos el sql para buscar esa clave en la tabla
            $sql = "SELECT * FROM USUARIO"; //comprobar que no hay claves iguales

            if (!$result = $this->mysqli->query($sql)){ //si da error la ejecución de la query
                return 'ERROR: No se ha podido conectar con la base de datos'; //error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
            }else { //si la ejecución de la query no da error
                    //Construimos la sentencia sql de inserción en la bd
                $sql = "UPDATE USUARIO
                        SET
                            PASSWORD = '$this->password',
                            NOMBRE =  '$this->nombre',
                            APELLIDOS = '$this->apellidos',
                            GENERO = '$this->genero',
                            ROL_ID = '$this->rol_ID'
                        WHERE LOGIN = '$this->login'  ";
                
                if (!($result = $this->mysqli->query($sql))){ //ERROR en la consulta ADD
                    //Si no hay atributos Clave y unique duplicados es que hay campos sin completar
                    return 'ERROR: Introduzca todos los valores de todos los campos'; // introduzca un valor para el usuario
                }
                else{
                    return "Editado correctamente";
                }
            }
        }else{ //Si no se introduce un login
                return 'ERROR: Introduzca todos los valores de todos los campos'; // introduzca un valor para el usuario
        }
                    
    }//fin metodo EDIT
    function DELETE(){

        $sql = "DELETE FROM USUARIO WHERE (LOGIN = '$this->login')";

        if(!$resultado = $this->mysqli->query($sql) ){
          return 'ERROR: Fallo en la consulta sobre la base de datos'; 
        }else{
            return 'Borrado correctamente';
        }
     
    }// fin del método DELETE
} //fin de la clase

?>