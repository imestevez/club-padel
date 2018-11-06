<?php

class USER_ROLE_Model{
    var $login;
    var $rol_id;
    var $mysqli;

    function __construct($login,$rol_id){
        $this->login = $login;
        $this->rol_id = $rol_id;

        include_once '../Functions/Access_DB.php';
        $this->mysqli = ConnectDB();
    }

    function ES_ADMIN($login){

        $sql = "SELECT * FROM USUARIO_ROL WHERE (
            (LOGIN = '$login') AND (ROL_ID = '2')
        )";

        $res = $this->mysqli->query($sql);
        $num_rows = mysqli_num_rows($res);

        if ($num_rows == 0){ //si hay 0 tuplas con ese login
            return 'ERROR: No tienes permiso';
        }
        else{//si no hay 0 tuplas
            return true;   
        }    
    }

    function ADD()
    {
                   
    } // fin del metodo ADD

}

?>