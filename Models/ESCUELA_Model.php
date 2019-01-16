<?php

class ESCUELA_Model{
    var $id;
    var $nombre;
    var $horario;
    var $dia;
    var $pista_ID;
    var $inscripciones;
    var $max_inscripciones;

    var $mensaje;
    var $mysqli;

    function __construct($id,$nombre, $dia,$horario_ID, $pista_ID ,$inscripciones){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->dia = $dia;
        $this->horario_ID = $horario_ID;
        $this->pista_ID = $pista_ID;
        $this->inscripciones = $inscripciones;
        $this->max_inscripciones = 4;


        include_once '../Functions/Access_DB.php';
        include_once '../Models/NOTICIA_Model.php';
        $this->mysqli = ConnectDB();
        $this->UPDATE();

    }
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
    function ADD()
    {
        if (($this->nombre <> '') || ($this->horario_ID <> '') || ($this->pista_ID <> '') || ($this->dia <> '')){ // si los atributos estan vacios
            // construimos el sql para buscar esa clave en la tabla
            $sql = "SELECT * FROM ESCUELA 
                    WHERE      (HORARIO_ID = '$this->horario_ID')
                            AND (DIA = '$this->dia' )
                            AND (PISTA_ID = '$this->pista_ID')";


            if (!$resultado = $this->mysqli->query($sql)){ //si da error la ejecución de la query
                return 'ERROR: No se ha podido conectar con la base de datos'; //error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
            }else { //si la ejecución de la query no da error
                    $num_rows = mysqli_num_rows($resultado);
                    if($num_rows == 0){
                        $sql = "INSERT INTO ESCUELA(
                        ID,
                        NOMBRE,
                        DIA,
                        HORARIO_ID,
                        PISTA_ID,
                        INSCRIPCIONES) VALUES(
                                            NULL,
                                            '$this->nombre',
                                            '$this->dia',
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

                            //Generar noticia
                            $titulo = "Nueva clase";
                            $descripcion = "Nueva clase ".$this->dia." ".$this->horario_ID.", pista: ".$this->pista_ID;
                            $link = "../Controllers/INSCRIBIRSE_ESCUELAS_Controller.php";
                            $NOTICIA = new NOTICIA_Model(NULL, $titulo, $descripcion, $link);
                            $NOTICIA->ADD();

    	                    $this->mensaje['mensaje'] = 'Registrada correctamente';
                            return $this->mensaje; // introduzca un valor para el usuario
                        }
                    }else{
                            $this->mensaje['mensaje'] = 'ERROR: Ya existe una escuela en esa pista, dia y horario';
                            return $this->mensaje; // introduzca un valor para el usuario
                    }

            }
        }else{ //Si no se introduce un login
                $this->mensaje['mensaje'] = 'ERROR: Introduzca todos los valores de todos los campos'; // Itroduzca un valor para el usuario
                return $this->mensaje;
        }
                    
    } // fin del metodo ADD

    function SHOWALL(){

        $sql = "SELECT E.ID, E.NOMBRE, E.DIA, E.INSCRIPCIONES, H.HORA_INICIO, H.HORA_FIN, PI.NOMBRE AS NOMBRE_PISTA 
                FROM ESCUELA E, HORARIO H, PISTA PI 
                WHERE       (E.HORARIO_ID = H.ID)
                        AND (E.PISTA_ID = PI.ID)";
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
                $sql2 = "SELECT * FROM ESCUELA_RESERVA WHERE (ESCUELA_ID = '$this->id')";
                $resultado2 = $this->mysqli->query($sql2);

                $sql3 = "DELETE FROM ESCUELA_RESERVA WHERE (ESCUELA_ID = '$this->id')";
                $resultado3 = $this->mysqli->query($sql3);

                if(!$resultado = $this->mysqli->query($sql) ){
                    return 'ERROR: Fallo en la consulta sobre la base de datos'; 
                }else{
                    if($resultado2 <> NULL){
                        while($row = mysqli_fetch_array($resultado2)){
                            $reserva_id = $row['RESERVA_ID'];
                            $sql4 = "DELETE FROM RESERVA WHERE (ID = '$reserva_id')";
                            if(!$resultado4 = $this->mysqli->query($sql4) ){
                                return 'ERROR: Fallo en la consulta sobre la base de datos';
                            }
                        }
                    }
                }
            $this->mensaje['mensaje'] = 'Borrado correctamente';
            return $this->mensaje;
        }
    }// fin del método DELETE
     function SHOWALL_Inscripciones(){

        $sql = "SELECT E.ID, UE.USUARIO_LOGIN, E.NOMBRE, E.DIA, E.PISTA_ID, PI.NOMBRE AS NOMBRE_PISTA, E.HORARIO_ID, 
                        E.INSCRIPCIONES, H.HORA_INICIO, H.HORA_FIN
                FROM ESCUELA E, HORARIO H, USUARIO_ESCUELA UE, PISTA PI
                WHERE      (H.ID = E.HORARIO_ID) AND (E.ID = UE.ESCUELA_ID)  AND (PI.ID = E.PISTA_ID)
                GROUP BY E.ID
                ORDER BY E.NOMBRE DESC, H.HORA_INICIO, E.PISTA_ID";
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

        $sql = "SELECT E.ID, E.NOMBRE, E.PISTA_ID, E.DIA,E.HORARIO_ID, E.INSCRIPCIONES, PI.NOMBRE AS NOMBRE_PISTA, H.HORA_INICIO, H.HORA_FIN
                FROM ESCUELA E, HORARIO H, USUARIO_ESCUELA U, PISTA PI
                WHERE      (H.ID = E.HORARIO_ID) AND (U.ESCUELA_ID = E.ID) AND (U.USUARIO_LOGIN = '$login')  AND (PI.ID = E.PISTA_ID)
                GROUP BY E.ID
                ORDER BY E.NOMBRE DESC, H.HORA_INICIO, E.PISTA_ID";
            // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
            return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }  
    }// fin del método SHOWALL_Login

    function SHOWALL_Disponibles(){

        $sql = "SELECT E.ID, E.NOMBRE, E.PISTA_ID, E.DIA, E.HORARIO_ID, PI.NOMBRE AS NOMBRE_PISTA , E.INSCRIPCIONES, H.HORA_INICIO, H.HORA_FIN
                FROM ESCUELA E, HORARIO H, PISTA PI
                WHERE      ( (H.ID = E.HORARIO_ID) 
                        AND (E.INSCRIPCIONES < '$this->max_inscripciones')
                        AND (PI.ID = E.PISTA_ID) )
                GROUP BY E.ID        
                ORDER BY H.HORA_INICIO, E.PISTA_ID";
            // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
            return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
                return $resultado;
        }  
    }// fin SHOWALL_Disponibles

   function SHOWALL_DisponiblesLogin($login){
        $sql = "SELECT E.ID, E.NOMBRE, E.PISTA_ID, E.DIA, E.HORARIO_ID, PI.NOMBRE AS NOMBRE_PISTA , E.INSCRIPCIONES, H.HORA_INICIO, H.HORA_FIN
            FROM ESCUELA E, HORARIO H, PISTA PI, USUARIO_ESCUELA UE
            WHERE      ( (H.ID = E.HORARIO_ID) 
                    AND (E.INSCRIPCIONES < '$this->max_inscripciones')
                    AND (PI.ID = E.PISTA_ID) 
                    AND  (E.ID NOT IN (SELECT ESCUELA_ID FROM  USUARIO_ESCUELA WHERE (USUARIO_LOGIN = '$login') ))
                      )
            GROUP BY E.ID        
            ORDER BY H.HORA_INICIO, E.PISTA_ID";

        // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
            return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
                return $resultado;
        }  

    }// fin SHOWALL_DisponiblesLogin

    function SHOW_Usuarios_Diponibles(){


        $sql = "SELECT U.LOGIN, U.NOMBRE, U.APELLIDOS
                FROM USUARIO_ESCUELA UE, USUARIO U
                WHERE  (UE.USUARIO_LOGIN = U.LOGIN)  AND (UE.ESCUELA_ID = '$this->id') 
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



    function GET_ESCUELA(){
        $sql = "SELECT * FROM ESCUELA WHERE ID = '$this->id' ";
          if(!$resultado = $this->mysqli->query($sql) ){
            return NULL; 
        }else{
            $row = mysqli_fetch_array($resultado);
            return $row;
        }        
    }//fin del metodo ADD_RESERVA
    
}
?>