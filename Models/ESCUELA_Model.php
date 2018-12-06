<?php

class ESCUELA_Model{
    var $id;
    var $nombre;
    var $horario;
    var $pista_ID;
    var $inscripciones;
    var $mensaje;
    var $mysqli;

    function __construct($id,$nombre, $horario_ID, $pista_ID ,$inscripciones){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->horario_ID = $horario_ID;
        $this->pista_ID = $pista_ID;
        $this->inscripciones = $inscripciones;

        include_once '../Functions/Access_DB.php';
        $this->mysqli = ConnectDB();
      //  $this->UPDATE();

    }

    function ADD()
    {
        if (($this->nombre <> '') || ($this->horario_ID <> '') || ($this->pista_ID <> '') ){ // si los atributos estan vacios
            // construimos el sql para buscar esa clave en la tabla
            $sql = "SELECT * FROM ESCUELA 
                    WHERE      (HORARIO_ID = '$this->horario_ID')
                            AND (PISTA_ID = '$this->pista_ID')";


            if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
                return 'ERROR: No se ha podido conectar con la base de datos'; //error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
            }else { //si la ejecución de la query no da error
                    $num_rows = mysqli_num_rows($resultado);
                    if($num_rows == 0){
                        $sql = "INSERT INTO ESCUELA(
                        ID,
                        NOMBRE,
                        HORARIO_ID,
                        PISTA_ID,
                        INSCRIPCIONES) VALUES(
                                            NULL,
                                            '$this->nombre',
                                            '$this->horario_ID',
                                            '$this->pista_ID',
                                            '0'
                                            )";
                        if (!($resultado = $this->mysqli->query($sql))){ //ERROR en la consulta ADD
                            //Si no hay atributos Clave y unique duplicados es que hay campos sin completar
                            $this->mensaje['mensaje'] = 'ERROR: No se podido registrar la escuela deportiva';
                            return $this->mensaje; // introduzca un valor para el usuario
                        }else{
                            //$this->mensaje['partido_ID'] = mysql_insert_id();
    	                    $this->mensaje['mensaje'] = 'Registrada correctamente';
                            return $this->mensaje; // introduzca un valor para el usuario
                        }
                    }else{
                            $this->mensaje['mensaje'] = 'ERROR: Ya existe una escuela en esa pista y horario';
                            return $this->mensaje; // introduzca un valor para el usuario
                    }

            }
        }else{ //Si no se introduce un login
                $this->mensaje['mensaje'] = 'ERROR: Introduzca todos los valores de todos los campos'; // Itroduzca un valor para el usuario
                return $this->mensaje;
        }
                    
    } // fin del metodo ADD

    function RESERVAR(){

    }// fin del metodo reservar

    function SHOWALL(){

        $sql = "SELECT E.ID, E.NOMBRE, E.INSCRIPCIONES, H.HORA_INICIO, H.HORA_FIN, P.NOMBRE AS NOMBRE_PISTA 
                FROM ESCUELA E, HORARIO H, PISTA P 
                WHERE       (E.HORARIO_ID = H.ID)
                        AND (E.PISTA_ID = P.ID)";
        if (!($resultado = $this->mysqli->query($sql))){ //ERROR en la consulta ADD
            return 'ERROR: No se ha podido conectar con la base de datos';
        }else{
            return $resultado;
        }

    }//fin del metodo SHOWALL
     function DELETE(){
        $sql = "DELETE FROM ESCUELA WHERE (ID = '$this->id')";

        if(!$resultado = $this->mysqli->query($sql) ){
          return 'ERROR: Fallo en la consulta sobre la base de datos'; 
        }else{
            $this->mensaje['mensaje'] = 'Borrado correctamente';
            return $this->mensaje;
        }
    }// fin del método DELETE
    
    /*
    function UPDATE(){

        $sql = "SELECT * FROM ESCUELA";

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

                    $sql = "UPDATE ESCUELA SET INSCRIPCIONES = (SELECT COUNT(*) 
                                                                    FROM USUARIO_ESCUELA 
                                                                    WHERE (ESCUELA_ID = '$key')  ) 
                            WHERE ID = '$key'";
                    if(!$resultado = $this->mysqli->query($sql)){
                       $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos';
                    }
                }//fin del foreach
            }//fin del id
        }//fin else
    }  // fin del metodo UPDATE   
    
    function EDIT(){
        $sql = "UPDATE ESCUELA SET RESERVA_ID = '$this->reserva_ID'
                WHERE ID = '$this->id'";
            if(!$resultado = $this->mysqli->query($sql)){
               return  'ERROR: Fallo en la consulta sobre la base de datos';
            }else{
                return true;
            }
    }// fin del método EDIT
    function SHOWALL_Inscripciones(){

        $sql = "SELECT P.ID, UP.USUARIO_LOGIN, P.NOMBRE, P.PISTA_ID, PI.NOMBRE, P.HORARIO_ID, 
                        P.INSCRIPCIONES, H.HORA_INICIO, H.HORA_FIN
                FROM ESCUELA P, HORARIO H, USUARIO_ESCUELA UP, PISTA PI
                WHERE      (H.ID = P.HORARIO_ID) AND (P.ID = UP.ESCUELA_ID)  AND (PI.ID = P.PISTA_ID)
                GROUP BY P.ID
                ORDER BY P.NOMBRE DESC, H.HORA_INICIO, P.PISTA_ID";
            // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
            return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }  
    }// fin del método SHOWALL_Inscripciones
    
    function SHOWALL_Login($login){

        $sql = "SELECT P.ID, P.NOMBRE, P.PISTA_ID, P.HORARIO_ID, P.INSCRIPCIONES, PI.NOMBRE, H.HORA_INICIO, H.HORA_FIN
                FROM ESCUELA P, HORARIO H, USUARIO_ESCUELA U, PISTA PI
                WHERE      (H.ID = P.HORARIO_ID) AND (U.ESCUELA_ID = P.ID) AND (U.USUARIO_LOGIN = '$login')  AND (PI.ID = P.PISTA_ID)
                GROUP BY P.ID
                ORDER BY P.NOMBRE DESC, H.HORA_INICIO, P.PISTA_ID";
            // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
            return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }  
    }// fin del método SHOWALL_Partidos

    function SHOW_FuturosLogin($login){
        $nombre_completa = getdate();
        $hora = date('H:i:s');
        $nombre = date('Y-m-d');
            
        $sql = "SELECT * FROM USUARIO_ESCUELA WHERE USUARIO_LOGIN = '$login'";
            // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado1 = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
            return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            $num_rows1 = mysqli_num_rows($resultado1);


            $sql = "SELECT P.ID, P.NOMBRE, P.PISTA_ID, P.HORARIO_ID, PI.NOMBRE, P.INSCRIPCIONES, H.HORA_INICIO, H.HORA_FIN
                FROM ESCUELA P, HORARIO H, PISTA PI
                WHERE      ( (H.ID = P.HORARIO_ID) 
                        AND (P.INSCRIPCIONES < 4) 
                        AND (PI.ID = P.PISTA_ID) )
                        AND 
                          ( ( (H.HORA_INICIO > '$hora') AND (P.NOMBRE = '$nombre') )
                        ||  (P.NOMBRE > '$nombre'))
                GROUP BY P.ID        
                ORDER BY P.NOMBRE DESC, H.HORA_INICIO, P.PISTA_ID";

                if (!($resultado2 = $this->mysqli->query($sql))){
                    $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
                    return $this->mensaje; 
                }
                else{  //si se ejecuta la query
                    $listPartidos = NULL;
                    $listInscripcion = NULL;

                    if($resultado1 <> NULL){ //si hay tuplas
                        while($row = mysqli_fetch_array($resultado1)){
                            $listInscripcion[$row["ESCUELA_ID"]] = "Inscrito";
                        }
                    }

                    if($resultado2 <> NULL) {
                        if($listInscripcion == NULL ){ //si no esta inscrito en ningun partido
                            while($row = mysqli_fetch_array($resultado2)){                                
                                $listPartidos[$row["ID"]] = array($row["NOMBRE"],$row["HORA_INICIO"],$row["HORA_FIN"],$row["NOMBRE"],$row["INSCRIPCIONES"]);
                            }   
                        }else{ //si esta inscrito en algun partido
                             while($row = mysqli_fetch_array($resultado2)){
                                if( !array_key_exists($row["ID"],  $listInscripcion)){
                                    $listPartidos[$row["ID"]] = array($row["NOMBRE"],$row["HORA_INICIO"],$row["HORA_FIN"],$row["NOMBRE"],$row["INSCRIPCIONES"]);
                                }
                            }//fin del while
                        }//fin del else
                    }
                    return $listPartidos;
                }//fin del else
            return NULL;
        }  
    }// fin del método SHOW_Futuros

    function SHOW_Futuros(){
        $nombre_completa = getdate();
        $hora = date('H:i:s');
        $nombre = date('Y-m-d');
        $listPartidos = NULL;
        $sql = "SELECT P.ID, P.NOMBRE, P.PISTA_ID, P.HORARIO_ID, PI.NOMBRE, P.INSCRIPCIONES, H.HORA_INICIO, H.HORA_FIN
                FROM ESCUELA P, HORARIO H, PISTA PI
                WHERE      ( (H.ID = P.HORARIO_ID) 
                        AND (P.INSCRIPCIONES < 4)
                        AND (PI.ID = P.PISTA_ID) )
                        AND 
                          ( ( (H.HORA_INICIO > '$hora') AND (P.NOMBRE = '$nombre') )
                        ||  (P.NOMBRE > '$nombre'))
                GROUP BY P.ID        
                ORDER BY P.NOMBRE DESC, H.HORA_INICIO, P.PISTA_ID";
            // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
            return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            if($resultado <> NULL) {
                  while($row = mysqli_fetch_array($resultado)){                                
                    $listPartidos[$row["ID"]] = array($row["NOMBRE"],$row["HORA_INICIO"],$row["HORA_FIN"],$row["NOMBRE"],$row["INSCRIPCIONES"]);
                    }   
                }
                return $listPartidos;
        }  
    }// fin del método SHOW_Futuros

    function SHOW_Usuarios_Diponibles(){


        $sql = "SELECT U.LOGIN, U.NOMBRE, U.APELLIDOS
                FROM USUARIO_ESCUELA UP, USUARIO U
                WHERE  (UP.USUARIO_LOGIN = U.LOGIN)  AND (UP.ESCUELA_ID = '$this->id') 
                ORDER BY U.LOGIN";

        if(!$resultado = $this->mysqli->query($sql) ){
            return 'ERROR: Fallo en la consulta sobre la base de datos'; 
        }else{
            $usuariosLibres = NULL;
            $usuariosPartido = NULL;

            $sql2   = "SELECT U.LOGIN, U.NOMBRE, U.APELLIDOS FROM USUARIO U, ROL R
                        WHERE (U.ROL_ID = R.ID)  AND (R.NOMBRE = 'DEPORTISTA') 
                        ORDER BY LOGIN";
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
            return NULL;
    }// fin del métodoSHOW_Usuarios_Diponibles
   
    function ADD_RESERVA(){
        $sql = "SELECT * FROM ESCUELA WHERE ID = '$this->id' ";
          if(!$resultado = $this->mysqli->query($sql) ){
            return NULL; 
        }else{
            $row = mysqli_fetch_array($resultado);
            return $row;
        }        
    }//fin del metodo ADD_RESERVA
    */
}
?>