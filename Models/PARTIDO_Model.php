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
                GROUP BY P.ID
                ORDER BY P.FECHA, H.HORA_INICIO";

            // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
            return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }  
    }// fin del método SHOWALL_Partidos
    
    function SHOWALL_Login($login){

        $sql = "SELECT P.ID, P.FECHA, P.PISTA_ID, P.HORARIO_ID, P.INSCRIPCIONES, H.HORA_INICIO, H.HORA_FIN
                FROM PARTIDO P, HORARIO H, USUARIO_PARTIDO U
                WHERE      (H.ID = P.HORARIO_ID) AND (U.PARTIDO_ID = P.ID) AND (U.USUARIO_LOGIN = '$login')
                GROUP BY P.ID
                ORDER BY P.FECHA, H.HORA_INICIO";
            // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
            return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }  
    }// fin del método SHOWALL_Partidos

    function SHOW_Futuros(){
        $fecha_completa = getdate();
        $hora = date('H:i:s');
        $fecha = date('Y-m-d');


        $sql = "SELECT P.ID, P.FECHA, P.PISTA_ID, P.HORARIO_ID, P.INSCRIPCIONES, H.HORA_INICIO, H.HORA_FIN
                FROM PARTIDO P, HORARIO H
                WHERE      ( (H.ID = P.HORARIO_ID) 
                        AND (P.INSCRIPCIONES < 4))
                        AND 
                          ( ( (H.HORA_INICIO > '$hora') AND (P.FECHA = '$fecha') )
                        ||  (P.FECHA > '$fecha'))
                GROUP BY P.ID        
                ORDER BY P.FECHA";
            // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
            return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }  
    }// fin del método SHOW_Futuros
    
    function SHOW_Futuros_Login($login){


        $sql = "SELECT P.ID, P.FECHA, P.PISTA_ID, P.HORARIO_ID, P.INSCRIPCIONES, H.HORA_INICIO, H.HORA_FIN
                FROM PARTIDO P, HORARIO H, USUARIO_PARTIDO U
                WHERE      (H.ID = P.HORARIO_ID) AND (U.PARTIDO_ID = P.ID) AND (P.INSCRIPCIONES < 4)
                GROUP BY P.ID        
                ORDER BY P.FECHA, H.HORA_INICIO";

            // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
            return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }
    }     //fin del metodo SHOW_Futuros_Login

    function SHOW_Usuarios_Diponibles(){
        $sql = "SELECT U.LOGIN, U.NOMBRE, U.APELLIDOS
                FROM USUARIO_PARTIDO UP, USUARIO U
                WHERE  (UP.USUARIO_LOGIN = U.LOGIN)  AND (UP.PARTIDO_ID = '$this->id') 
                ORDER BY U.LOGIN";

        if(!$resultado = $this->mysqli->query($sql) ){
            return 'ERROR: Fallo en la consulta sobre la base de datos'; 
        }else{
            $usuariosLibres = NULL;
            $usuariosPartido = NULL;

            $num_rows = mysqli_num_rows($resultado);

            $sql2   = "SELECT * FROM USUARIO ORDER BY LOGIN";

            if ( !($resultado2 = $this->mysqli->query($sql2))  ){
                return 'ERROR: Fallo en la consulta sobre la base de datos'; 
            }else{

                if($resultado <> NULL){
                    while($row = mysqli_fetch_array($resultado)){
                    $usuariosPartido[$row["LOGIN"]] = "No disponible";
                    }//fin del while
                }
                if($resultado2 <> NULL){
                    if($usuariosPartido == NULL ){
                        while($row = mysqli_fetch_array($resultado2)){                                
                            $usuariosLibres[$row["LOGIN"]] = array($row["NOMBRE"],$row["APELLIDOS"]);
                        }
                    }else{
                         while($row = mysqli_fetch_array($resultado2)){                                
                            if(!array_key_exists($row["LOGIN"], $usuariosPartido)){
                                $usuariosLibres[$row["LOGIN"]] = array($row["NOMBRE"],$row["APELLIDOS"]);
                            }
                        }
                    }
                }
                return $usuariosLibres;
             }//fin del else
        }//fin del else
            return $resultado;
    }// fin del métodoSHOW_Usuarios_Diponibles
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