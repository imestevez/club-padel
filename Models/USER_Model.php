<?php

class USER_Model{

    var $name;
    var $dni;
    var $email;
    var $password;
    var $mysqli;

    function __construct($name,$email,$dni,$password){
        $this->name = $name;
        $this->email = $email;
        $this->dni = $dni;
        $this->password = $password;

        include_once '../Functions/Access_DB.php';
        $this->mysqli = ConnectDB();
    }

    function login(){

        $sql = "SELECT * FROM USUARIO WHERE (
            (dni = '$this->dni')
        )";
        //edit
        $res = $this->mysqli->query($sql);
        $num_rows = mysqli_num_rows($res);

        if ($num_rows == 0){ //si hay 0 tuplas con ese login
            return 'ERROR: El login no existe';
        }
        else{//si no hay 0 tuplas
            $tupla = $res->fetch_array();
            if ($tupla['password'] == $this->password){//si coinciden las contraseñas
                return true;
            }
            else{//si no coinciden las contraseñas
                return 'ERROR: La contraseña para este usuario no es correcta';
            }
        }    
    }

    function ADD()
    {
        if (($this->dni <> '')){ // si el atributo clave de la entidad no esta vacio
            // construimos el sql para buscar esa clave en la tabla
            $sql = "SELECT * FROM USUARIO WHERE (dni = '$this->dni')"; //comprobar que no hay claves iguales

            if (!$result = $this->mysqli->query($sql)){ //si da error la ejecución de la query
                return 'ERROR: No se ha podido conectar con la base de datos'; //error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
            }else { //si la ejecución de la query no da error
                $num_rows = mysqli_num_rows($result); 
                if ($num_rows == 0){ //miramos si no existe el login
                    //Construimos la sentencia sql de inserción en la bd
                    $sql = "INSERT INTO USUARIO(
                    name,
                    email,
                    dni,
                    password) VALUES(
                                        '$this->name',
                                        '$this->email',
                                        '$this->dni',
                                        '$this->password'
                                    )";
                    
                    if (!($result = $this->mysqli->query($sql))){ //ERROR en la consulta ADD
                        //Si no hay atributos Clave y unique duplicados es que hay campos sin completar
                        return 'ERROR: Introduzca todos los valores de todos los campos'; // introduzca un valor para el usuario
                    }
                    else{
                        return "Registrado correctamente";
                    }
                }else{ //si hay un login igual
                    return 'ERROR: Hay un login igual'; 
                }
            }
        }else{ //Si no se introduce un login
                return 'ERROR: Introduzca todos los valores de todos los campos'; // introduzca un valor para el usuario
        }
                    
    } // fin del metodo ADD

}

?>