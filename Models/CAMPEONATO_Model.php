<?php

class CAMPEONATO_Model{

    var $nombre;
	var $fecha;
    var $mensaje;

    var $lista;

	var $mysql;


	function __construct($nombre,$fecha){
        $this->nombre = $nombre;
    	$this->fecha = $fecha;

        include_once '../Functions/Access_DB.php';
        include_once '../Models/GRUPO_Model.php';
        include_once '../Models/INSCRIPCION_Model.php';
        include_once '../Models/CLASIFICACION_Model.php';
        include_once '../Models/FINALISTA_CAMPEONATO_Model.php';
        include_once '../Models/ENFRENTAMIENTO_Model.php';
        include_once '../Models/NOTICIA_Model.php';


        $this->mysqli = ConnectDB();

        
    }

    //Función para eliminar un campeonato abierto
    function DELETE($campeonato_id){

        $sql_1 = "DELETE FROM INSCRIPCION WHERE CAM_CAT_ID IN (SELECT ID FROM CAMPEONATO_CATEGORIA WHERE CAMPEONATO_ID = '$campeonato_id')";  
        if($result = $this->mysqli->query($sql_1)){
            $sql_2 = "DELETE FROM CAMPEONATO_CATEGORIA WHERE CAMPEONATO_ID = '$campeonato_id'";
            if($result = $this->mysqli->query($sql_2)){
                $sql_3 = "DELETE FROM CAMPEONATO WHERE ID = '$campeonato_id'";
                if($result = $this->mysqli->query($sql_3)){
                    return "EL campeonato ha sido eliminado con éxito";
                }
                else{
                    return "ERROR: Al eliminar el campeonato seleccionado";
                    
                }
            }
            else{
                return "ERROR: Al eliminar el campeonato seleccionado";
                
            }
        }
        else{
            return "ERROR: Al eliminar el campeonato seleccionado";
            

        }
    }

    function GET_ID($grupo_id){
        $sql = "SELECT * FROM GRUPO WHERE ID = '$grupo_id'";
        $result = $this->mysqli->query($sql);
        $row = mysqli_fetch_array($result);
        return $row['CAMPEONATO_ID'];
    }

    //Función para obtener todas las posibles categorías de un campeonato
    function GET_CATEGORIASADD(){
        $sql = "SELECT * FROM CATEGORIA";
        $result = $this->mysqli->query($sql);
        return $result;
    }

    //Función para obtener las categorias de un campeonato
    function GET_CATEGORIASCAMPEONATO($campeonato_id){
        $sql = "SELECT * FROM   CAMPEONATO_CATEGORIA CC,
                                CATEGORIA C
                                WHERE 
                                (CC.CAMPEONATO_ID = '$campeonato_id') AND
                                (CC.CATEGORIA_ID = C.ID)
                                ";
        $result = $this->mysqli->query($sql);
        return $result;

    }

    //Función para obtener las categorías-grupo de un campeonato
    function GET_CG($campeonato_id){
        $sql = "SELECT  G.ID AS GRUPO_ID,
                        C.ID AS CATEGORIA_ID,
                        G.NOMBRE AS GRUPO_NOMBRE,
                        C.NIVEL,
                        C.GENERO        
                        FROM GRUPO G, CATEGORIA C
                                WHERE
                                        (G.CAMPEONATO_ID = '$campeonato_id')
                                    AND (G.CATEGORIA_ID = C.ID)";    
        $result = $this->mysqli->query($sql);
        return $result;                                
                                
    }

    //Función para obtener el nombre de un campeonato
    function GET_NOMBRE($campeonato_id){
        $datos = $this->GET($campeonato_id);
        if($row = mysqli_fetch_array($datos)){
            return $row['NOMBRE'];
        }
    }

    //Función que devuleve los grupos de un camponato
    function GET_GRUPOS($campeonato_id){
        $sql = "SELECT * FROM GRUPO WHERE CAMPEONATO_ID = '$campeonato_id'";
        $result = $this->mysqli->query($sql);

        return $result;

    } 

    function CATEGORIA_FETCH($categoria_id){
        $sql = "SELECT * FROM CATEGORIA WHERE ID = '$categoria_id'";
        
        $result = $this->mysqli->query($sql);
        return $result;
        
    }

    function GRUPO_NOMBRE($grupo_id){
        $sql = "SELECT * FROM GRUPO WHERE ID = '$grupo_id'";
        $result = $this->mysqli->query($sql);
        return $result;
    }

    //Función para calcular la etapa actual de un campeonato
    function ETAPA_ACT($grupo_id){
        //Si etapa final
        $sql = "SELECT * FROM FINALISTA_CAMPEONATO WHERE (ETAPA = 'F') AND (GRUPO_ID = '$grupo_id')";
        $result = $this->mysqli->query($sql);
        if(mysqli_num_rows($result) > 0){
            return 'F';
        }
        //Si etapa de semis
        $sql = "SELECT * FROM FINALISTA_CAMPEONATO WHERE (ETAPA = 'S') AND (GRUPO_ID = '$grupo_id')";
        $result = $this->mysqli->query($sql);
        if(mysqli_num_rows($result) > 0){
            return 'S';
        }
        //Si etapa de cuartos
        $sql = "SELECT * FROM FINALISTA_CAMPEONATO WHERE (ETAPA = 'C') AND (GRUPO_ID = '$grupo_id')";
        $result = $this->mysqli->query($sql);
        if(mysqli_num_rows($result) > 0){
            return 'C';
        }

        return 'G';
    }

    function GANADOR_SET($set_p1, $set_p2){
        if( ($set_p1 >= 6) || ($set_p2 >= 6)) {
            if($set_p1 > $set_p2){
                return 1;
            }
             if($set_p1 < $set_p2){
                return 2;
            }
            return 0;
        }else{
            return 0;
        }
    }

    function GANADOR_SETS($set1,$set2,$set3){
        $cont_p1 = 0;
        $cont_p2 = 0;

        if($set1 == 1){
            $cont_p1 = $cont_p1 + 1;
        }
        if($set1 == 2){
            $cont_p2 = $cont_p2 + 1;
        }
        if($set2 == 1){
            $cont_p1 = $cont_p1 + 1;
        }
       if($set2 == 2){
            $cont_p2 = $cont_p2 + 1;
        }
        if($set3 == 1){
            $cont_p1 = $cont_p1 + 1;
        }
       if($set3 == 2){
            $cont_p2 = $cont_p2 + 1;
        }

        if($cont_p1 > $cont_p2 ){
            return 1;
        }
       if($cont_p1 < $cont_p2 ){
            return 2;
        }

        return 0;
    }

    function GANADOR_PARTIDO($resultado){
        $sets=explode("/", $resultado);
        $set_1=$sets[0];
        $set_2=$sets[1];
        $set_3=$sets[2];

        $set_1=explode('-', $set_1);
        $p1_set1 = $set_1[0];
        $p2_set1 = $set_1[1];

        $set_2=explode('-', $set_2);
        $p1_set2 = $set_2[0];
        $p2_set2 = $set_2[1];

        $set_3=explode('-', $set_3);
        $p1_set3 = $set_3[0];
        $p2_set3 = $set_3[1];

        $ganador_set_1 = $this->GANADOR_SET($p1_set1, $p2_set1);
        $ganador_set_2 = $this->GANADOR_SET($p1_set2, $p2_set2);
        $ganador_set_3 = $this->GANADOR_SET($p1_set3, $p2_set3);

        $ganador_partido = $this->GANADOR_SETS($ganador_set_1,$ganador_set_2,$ganador_set_3);
        return $ganador_partido;
    }

    //Función para seleccionar los ganadores de un grupo de la fase de grupos
    function GANADORES_GRUPO($grupo_id,$etapa){

        switch ($etapa) {
                case 'F':
                    $sql_fecha = "SELECT FECHA FROM FINALISTA_CAMPEONATO WHERE (GRUPO_ID = '$grupo_id') AND (ETAPA = 'F')";
                $result_fecha = $this->mysqli->query($sql_fecha);
                if($row_fecha = mysqli_fetch_array($result_fecha)){
                    $fecha_cierre = $row_fecha['FECHA'];
                    }
                    
                    $sql_enf = "SELECT  DISTINCT CA.NOMBRE AS CAM_NOMBRE,
                                                CT.NIVEL,
                                                CT.GENERO,
                                                G.NOMBRE AS GR_NOMBRE,
                                                E.ID AS ENFRENTAMIENTO_ID,
                                                E.PAREJA_1 AS PAREJA_1,
                                                E.PAREJA_2 AS PAREJA_2,
                                                E.RESULTADO AS RESULTADO

                                                FROM

                                                ENFRENTAMIENTO E,
                                                GRUPO G,
                                                CATEGORIA CT,
                                                CAMPEONATO CA,
                                                RESERVA R,
                                                FINALISTA_CAMPEONATO FC

                                                WHERE

                                                (
                                                    (SELECT COUNT(GRUPO_ID) FROM FINALISTA_CAMPEONATO WHERE GRUPO_ID = '$grupo_id') > 0 ) AND
                                                    (E.GRUPO_ID = G.ID) AND
                                                    (G.CAMPEONATO_ID = CA.ID) AND
                                                    (G.CATEGORIA_ID = CT.ID) AND
                                                    (G.ID = '$grupo_id') AND
                                                    ( 
                                                        (
                                                            ( E.RESERVA_ID IS NOT NULL) AND
                                                            ( E.RESERVA_ID IN (SELECT DISTINCT ID FROM RESERVA WHERE (FECHA > '$fecha_cierre') )
                                                        ) 
                                                        OR
                                                        (E.RESERVA_ID IS NULL)
                                                    )
                                                )

                                        ";    

                    $result = $this->mysqli->query($sql_enf);

                    while($row =  mysqli_fetch_array($result)){
                        $resultado_partido = $row['RESULTADO'];
                        $ganador = $this->GANADOR_PARTIDO($resultado_partido);
                        if($ganador = 1){
                            $ganador = $row['PAREJA_1'];           
                        }
                        else{
                             $ganador = $row['PAREJA_2'];
                        }
                        //Ganador del campeonato
                            $this->PROMOCIONAR_PAREJA($ganador,$grupo_id,"-");
                    }     

                    break;
                case 'S':
                
                $sql_fecha = "SELECT FECHA FROM FINALISTA_CAMPEONATO WHERE (GRUPO_ID = '$grupo_id') AND (ETAPA = 'S')";
                $result_fecha = $this->mysqli->query($sql_fecha);
                if($row_fecha = mysqli_fetch_array($result_fecha)){
                    $fecha_cierre = $row_fecha['FECHA'];
                    }
                    
                    $sql_enf = "SELECT  DISTINCT CA.NOMBRE AS CAM_NOMBRE,
                                                CT.NIVEL,
                                                CT.GENERO,
                                                G.NOMBRE AS GR_NOMBRE,
                                                E.ID AS ENFRENTAMIENTO_ID,
                                                E.PAREJA_1 AS PAREJA_1,
                                                E.PAREJA_2 AS PAREJA_2,
                                                E.RESULTADO AS RESULTADO

                                                FROM

                                                ENFRENTAMIENTO E,
                                                GRUPO G,
                                                CATEGORIA CT,
                                                CAMPEONATO CA,
                                                RESERVA R,
                                                FINALISTA_CAMPEONATO FC

                                                WHERE

                                                (
                                                    (SELECT COUNT(GRUPO_ID) FROM FINALISTA_CAMPEONATO WHERE GRUPO_ID = '$grupo_id') > 0 ) AND
                                                    (E.GRUPO_ID = G.ID) AND
                                                    (G.CAMPEONATO_ID = CA.ID) AND
                                                    (G.CATEGORIA_ID = CT.ID) AND
                                                    (G.ID = '$grupo_id') AND
                                                    ( 
                                                        (
                                                            ( E.RESERVA_ID IS NOT NULL) AND
                                                            ( E.RESERVA_ID IN (SELECT DISTINCT ID FROM RESERVA WHERE (FECHA > '$fecha_cierre') )
                                                        ) 
                                                        OR
                                                        (E.RESERVA_ID IS NULL)
                                                    )
                                                )

                                        ";    

                    $result = $this->mysqli->query($sql_enf);

                    while($row =  mysqli_fetch_array($result)){
                        $resultado_partido = $row['RESULTADO'];
                        $ganador = $this->GANADOR_PARTIDO($resultado_partido);
                        if($ganador = 1){
                            $ganador = $row['PAREJA_1'];           
                        }
                        else{
                             $ganador = $row['PAREJA_2'];
                        }
                        //Ganador del campeonato
                            $this->PROMOCIONAR_PAREJA($ganador,$grupo_id,"F");
                    }    
                    break;
                case 'C':
                $fecha_act = date("Y-m-d");

                    $sql_fecha = "SELECT FECHA FROM FINALISTA_CAMPEONATO WHERE (GRUPO_ID = '$grupo_id') AND (ETAPA = 'C')";
                $result_fecha = $this->mysqli->query($sql_fecha);
                if($row_fecha = mysqli_fetch_array($result_fecha)){
                    $fecha_cierre = $row_fecha['FECHA'];
                    }
                    
                    $sql_enf = "SELECT  DISTINCT CA.NOMBRE AS CAM_NOMBRE,
                                                CT.NIVEL,
                                                CT.GENERO,
                                                G.NOMBRE AS GR_NOMBRE,
                                                E.ID AS ENFRENTAMIENTO_ID,
                                                E.PAREJA_1 AS PAREJA_1,
                                                E.PAREJA_2 AS PAREJA_2,
                                                E.RESULTADO AS RESULTADO

                                                FROM

                                                ENFRENTAMIENTO E,
                                                GRUPO G,
                                                CATEGORIA CT,
                                                CAMPEONATO CA,
                                                RESERVA R,
                                                FINALISTA_CAMPEONATO FC

                                                WHERE

                                                (
                                                    (SELECT COUNT(GRUPO_ID) FROM FINALISTA_CAMPEONATO WHERE GRUPO_ID = '$grupo_id') > 0 ) AND
                                                    (E.GRUPO_ID = G.ID) AND
                                                    (G.CAMPEONATO_ID = CA.ID) AND
                                                    (G.CATEGORIA_ID = CT.ID) AND
                                                    (G.ID = '$grupo_id') AND
                                                    ( 
                                                        (
                                                            ( E.RESERVA_ID IS NOT NULL) AND
                                                            ( E.RESERVA_ID IN (SELECT DISTINCT ID FROM RESERVA WHERE (FECHA > '$fecha_cierre') )
                                                        ) 
                                                        OR
                                                        (E.RESERVA_ID IS NULL)
                                                    )
                                                )

                                        ";    

                    $result = $this->mysqli->query($sql_enf);
                    while($row =  mysqli_fetch_array($result)){
                        $resultado_partido = $row['RESULTADO'];
                        $ganador = $this->GANADOR_PARTIDO($resultado_partido);
                        if($ganador = 1){
                            $ganador = $row['PAREJA_1'];           
                        }
                        else{
                             $ganador = $row['PAREJA_2'];
                        }
                        //Ganador del campeonato
                            $this->PROMOCIONAR_PAREJA($ganador,$grupo_id,"S");
                    }    
                    break;
                case 'G':
                    //Buscamos todas las clasificaciones del grupo y las ordenamos por puntos
                    $sql_cmp = "SELECT * FROM CLASIFICACION WHERE (GRUPO_ID = '$grupo_id') ORDER BY PUNTOS DESC"; 
                    $result = $this->mysqli->query($sql_cmp);
                    //Seleccionamos los 8 primeros y los añadimos como finalistas
                    $num_finalistas = 0;
                    while ( $num_finalistas < 8 ) {
                        if($row_g =  mysqli_fetch_array($result)){
                            $pareja_id = $row_g['PAREJA_ID'];
                        //Creamos la instancia del jugador como finalista
                        $FINALISTA_CAMPEONATO = new FINALISTA_CAMPEONATO_Model($grupo_id,$pareja_id,"C",$num_finalistas);
                        $FINALISTA_CAMPEONATO->ADD();
                        $num_finalistas++;
                        }
                        
                    }         
                
                default:
                    # code...
                    break;    
        }

        //Por último, generamos los enfrentamientos 
        $this->GENERAR_ENFREN_ETAPA($etapa,$grupo_id);
        
    }

    //Función para generar los enfrentamientos según la etapa 
    function GENERAR_ENFREN_ETAPA($etapa, $grupo_id){
        switch ($etapa) {
            case 'S':
                $sql = "SELECT * FROM FINALISTA_CAMPEONATO WHERE (GRUPO_ID = '$grupo_id') AND (ETAPA = 'F') ORDER BY PUNTOS ASC";
                $result = $this->mysqli->query($sql);
                $participantes = [];
                $i=0;
                while($row = mysqli_fetch_array($result)){
                    $participantes[$i] = $row['PAREJA_ID'];
                    $i++;
                }
                //Generamos los enfrentamientos de la etapa de cuartos según las especificaciones
                for ($i=0; $i < 1; $i++) { 
                    $pareja_1 = $participantes[$i];
                    $pareja_2 = $participantes[$i+1];
                    $ENFRENTAMIENTO = new ENFRENTAMIENTO_Model($grupo_id,null,$pareja_1,$pareja_2,null);
                    $ENFRENTAMIENTO->ADD_FINAL();
                }
                break;
            case 'C':
                $sql = "SELECT * FROM FINALISTA_CAMPEONATO WHERE (GRUPO_ID = '$grupo_id') AND (ETAPA = 'S') ORDER BY PUNTOS ASC";
                $result = $this->mysqli->query($sql);
                $participantes = [];
                $i=0;
                while($row = mysqli_fetch_array($result)){
                    $participantes[$i] = $row['PAREJA_ID'];
                    $i++;
                }
                //Generamos los enfrentamientos de la etapa de cuartos según las especificaciones
                for ($i=0; $i < 2; $i++) { 
                    $pareja_1 = $participantes[$i];
                    $indice_2 = 3 - $i;
                    $pareja_2 = $participantes[$indice_2];
                    $ENFRENTAMIENTO = new ENFRENTAMIENTO_Model($grupo_id,null,$pareja_1,$pareja_2,null);
                    $ENFRENTAMIENTO->ADD_FINAL();
                }
                break;
            case 'G':
                $sql = "SELECT * FROM FINALISTA_CAMPEONATO WHERE (GRUPO_ID = '$grupo_id') AND (ETAPA = 'C') ORDER BY PUNTOS ASC";
                $result = $this->mysqli->query($sql);
                $participantes = [];
                $i=0;
                while($row = mysqli_fetch_array($result)){
                    $participantes[$i] = $row['PAREJA_ID'];
                    $i++;
                }
                //Generamos los enfrentamientos de la etapa de cuartos según las especificaciones
                for ($i=0; $i < 4; $i++) { 
                    $pareja_1 = $participantes[$i];
                    $indice_2 = 7 - $i;
                    $pareja_2 = $participantes[$indice_2];
                    $ENFRENTAMIENTO = new ENFRENTAMIENTO_Model($grupo_id,null,$pareja_1,$pareja_2,null);
                    $ENFRENTAMIENTO->ADD_FINAL();
                }
                break;   
            default:
                # code...
                break;
        }
    }

    //Función para promocionar de etapa a un jugador
    function PROMOCIONAR_PAREJA($pareja_id,$grupo_id,$etapa_siguiente){
        $fecha_act = date("Y-m-d");
        $sql = "UPDATE FINALISTA_CAMPEONATO 
                        SET ETAPA = '$etapa_siguiente',
                            FECHA = '$fecha_act'
                            WHERE 
                                (GRUPO_ID = '$grupo_id')
                            AND (PAREJA_ID = '$pareja_id')
                            ";
        $result = $this->mysqli->query($sql);                    
    }

    //Función que comprueba si se han jugado todos los enfrentamientos de la fase de grupos de un grupo
    function COMPROBAR_ETAPA($grupo_id,$etapa){

        switch ($etapa) {

                case 'F':
                    //Buscamos todos los enfrentamientos para ese grupo
                    $sql_cmp = "SELECT * FROM   ENFRENTAMIENTO E,
                                                FINALISTA_CAMPEONATO F
                                            WHERE 
                                                (E.GRUPO_ID = '$grupo_id')
                                            AND (E.GRUPO_ID = F.GRUPO_ID)
                                            AND (F.ETAPA = 'F')";
                    break;
                case 'S':
                    //Buscamos todos los enfrentamientos para ese grupo
                    $sql_cmp = "SELECT * FROM   ENFRENTAMIENTO E,
                                                FINALISTA_CAMPEONATO F
                                            WHERE 
                                                (E.GRUPO_ID = '$grupo_id')
                                            AND (E.GRUPO_ID = F.GRUPO_ID)
                                            AND (F.ETAPA = 'S')";
                    break;
                case 'C':
                    //Buscamos todos los enfrentamientos para ese grupo
                    $sql_cmp = "SELECT * FROM   ENFRENTAMIENTO E,
                                                FINALISTA_CAMPEONATO F
                                            WHERE 
                                                (E.GRUPO_ID = '$grupo_id')
                                            AND (E.GRUPO_ID = F.GRUPO_ID)
                                            AND (F.ETAPA = 'C')";
                    break;
                case 'G':
                    //Buscamos todos los enfrentamientos para ese grupo
                    $sql_cmp = "SELECT * FROM   ENFRENTAMIENTO E
                                            WHERE 
                                                (GRUPO_ID = '$grupo_id')";
                    break;          
                
                default:
                    $sql_cmp = null;

                    break;    
        }

        $result = $this->mysqli->query($sql_cmp);
        //Comprobamos que todos los enfrentamientos encontrados tienen un resultado asociado
        while ($row =  mysqli_fetch_array($result) ) {
            //Si algún enfrentamiento no se ha jugado paramos de buscar
            if($row['RESULTADO'] == NULL){
                return 0;
            }
        }

        return 1;
    }

    //Función añadir un campeonato a la bd
    function ADD($categorias){
 
        $sql = "INSERT INTO CAMPEONATO(ID,NOMBRE, FECHA) 
                VALUES( NULL,
                        '$this->nombre',
                        '$this->fecha')"; 

        $result = $this->mysqli->query($sql);

        if($result){
            //Cogemos el ID
            $sql = "SELECT * FROM CAMPEONATO ORDER BY ID DESC";
            $result = $this->mysqli->query($sql);
            $campeonatos = mysqli_fetch_array($result);
            $campeonato_id= $campeonatos['ID'];
            
            //Cogemos las categorias seleccionadas
            if($categorias <> NULL){
                foreach ($categorias as $key => $categoria_id) {
                    //Para cada categoría la relacionamos con el campeonato
                    $sql = "INSERT INTO CAMPEONATO_CATEGORIA(ID,CAMPEONATO_ID,CATEGORIA_ID)
                                VALUES (NULL, '$campeonato_id', '$categoria_id')";
                    $result = $this->mysqli->query($sql);            
                }
            }

            //Generar noticia
            $titulo = "Nuevo campeonato";
            $descripcion = "Nuevo campeonato ".$this->nombre.", límite de inscripcion hasta: ".$this->fecha;
            $link = "../Controllers/CAMPEONATOUSUARIO_Controller.php?action=CAMPEONATOSABIERTOS";
            $NOTICIA = new NOTICIA_Model(NULL, $titulo, $descripcion, $link);
            $NOTICIA->ADD();                

            $this->mensaje = "Campeonato registrado correctamente";
        }
        else{
           $this->mensaje = "ERROR: No se ha realizado el registro correctamente"; 
        }
        return $this->mensaje;                      
    }

    function GET($campeonato_ID){
        $sql = "SELECT * FROM CAMPEONATO WHERE (ID = '$campeonato_ID')";
            if (!($result = $this->mysqli->query($sql))){
                return  'ERROR: Fallo en la consulta sobre la base de datos'; 
            }
            else{ 
                return $result;
            }
    }
    //Mostramos todos los campeonatos
    function SHOWALL(){

        $sql = "SELECT * FROM CAMPEONATO";
        if (!($result = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
            return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            if($result <> NULL) {
                while($row = mysqli_fetch_array($result)){                                
                    $listCampeonatos[$row["ID"]] = array($row["NOMBRE"],$row["FECHA"]);
                }
                return $listCampeonatos;  
            }else{
                $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
                return $this->mensaje; 
            }
        }  
    }

    //Mostramos los campeonatos con fecha de inscripción pasada
    function SHOW_ABIERTOS(){

        $fecha_actual = date('Y-m-d');
        $sql = "SELECT * FROM CAMPEONATO WHERE (FECHA > '$fecha_actual')";

        $result = $this->mysqli->query($sql); 
        $campeonatos = null;
        while ($row = mysqli_fetch_array($result)) {
            $campeonatos[$row['ID']] = array($row['NOMBRE'],$row['FECHA']);
        }

            return $campeonatos;
    }

    function CAMP_ENFRENTAMIENTOS(){
        $fecha_actual = date('Y-m-d');
        $sql = "SELECT * FROM CAMPEONATO WHERE  (FECHA < '$fecha_actual') and 
                                                (ID IN (SELECT DISTINCT CAMPEONATO_ID FROM GRUPO))";
        return $result = $this->mysqli->query($sql);       
    }

    function CAMP_NOENFRENTAMIENTOS(){
        $fecha_actual = date('Y-m-d');
        $sql = "SELECT * FROM CAMPEONATO WHERE  (FECHA < '$fecha_actual') and 
                                                (ID NOT IN (SELECT DISTINCT CAMPEONATO_ID FROM GRUPO))";


        return $result = $this->mysqli->query($sql);       
    }

    //Mostramos los campeonatos con fecha de inscripción pasada
    function SHOW_CLOSE(){

        $fecha_actual = date('Y-m-d');
        $sql = "SELECT * FROM CAMPEONATO WHERE (FECHA < '$fecha_actual')";

        $result = $this->mysqli->query($sql); 

        if($result){
            return $result;
        }

        else{
            $this->mensaje = "ERROR: en la sentencia sql";
            return $this->mensaje;
        }
    }

    //A partir de un campeonato generamos grupos para cada categoría según el número de parejas inscritas
    function GENERAR_GRUPOS($id_campeonato){
        
        //Obtenemos las categorias del campeonato
        $sql_cat = "SELECT * FROM CAMPEONATO_CATEGORIA WHERE (CAMPEONATO_ID = '$id_campeonato')";       
        //Comprobación del las categorías de los campeonatos
        if($result_cat = $this->mysqli->query($sql_cat)){

            while($row = mysqli_fetch_array($result_cat)){
                //Para cada categoría obtenemos los inscritos
                $cat_id = $row['CATEGORIA_ID'];
                $sql_insc = "SELECT * FROM INSCRIPCION I, CAMPEONATO_CATEGORIA C 
                            WHERE   (I.CAM_CAT_ID = C.ID) and
                                    (C.CATEGORIA_ID = '$cat_id') and
                                    (C.CAMPEONATO_ID = '$id_campeonato')
                            ORDER BY I.FECHA        
                            ";           
                $result_insc = $this->mysqli->query($sql_insc);
                $num_inscritos = mysqli_num_rows($result_insc);

                //Comprobación del número de inscritos para cada categoría
                if($num_inscritos >= 8){
                        /*
                            CREACIÓN DE GRUPOS
                        */

                        //Calculamos el número de grupos a crear
                        $num_grupos = floor($num_inscritos/8);

                        //Para cada grupo nuevo
                        for ($grupo = 1; $grupo <= $num_grupos ; $grupo++) { 

                            //Creamos el grupo
                            $GRUPO = new GRUPO_Model($grupo,$id_campeonato,$cat_id);
                            $GRUPO->ADD();
                                    
                            //Asignamos grupo a 8 inscritos        
                            for ($i=0; $i < 8; $i++) { 

                                //Registramos a una pareja como miembro de un grupo
                                if($inscripcion = mysqli_fetch_array($result_insc)){
                                    $INSCRIPCION = new INSCRIPCION_Model('',$inscripcion['PAREJA_ID'],$inscripcion['CAM_CAT_ID']);

                                    //Asignamos el id del grupo correspondiente
                                    $sql_id_gru = "SELECT * FROM GRUPO WHERE (CATEGORIA_ID = '$cat_id') and (CAMPEONATO_ID = '$id_campeonato') and (NOMBRE = '$grupo')";
                                    $result_id_gru = $this->mysqli->query($sql_id_gru);
                                    $row_grupo_id = mysqli_fetch_array($result_id_gru);
                                    $id_grupo = $row_grupo_id['ID'];                               
                                    $INSCRIPCION->SET_GRUPO($id_grupo);

                                    //Para cada inscrito inicializamos su clasificación
                                    $CLASIFICACION = new CLASIFICACION_Model(0,$inscripcion['PAREJA_ID'],$id_grupo);
                                    $CLASIFICACION->ADD();

                                    $num_inscritos--; 

                                }                             
                            }                                                            
                        }

                        /*
                            FIN CREACIÓN DE GRUPOS
                        */

                        
                        //Si las parejas que quedan por asignar grupo son menos de 8, las repartimos entre los restantes grupos, cumpliendo que no haya más de 12 en cada uno
                        $grupo_actual = $num_grupos;
                        //Si se ha creado más de un grupo
                        if($grupo_actual > 1){
                            /*
                            ASIGNACIÓN DE INSCRITOS RESTANTES EN GRUPOS EXISTENTES
                            */
                            while($num_inscritos > 0 and $inscripcion = mysqli_fetch_array($result_insc)){

                                $INSCRIPCION = new INSCRIPCION_Model('',$inscripcion['PAREJA_ID'],$inscripcion['CAM_CAT_ID']);

                                //Asignamos el id del grupo correspondiente
                                $sql_id_gru = "SELECT * FROM GRUPO WHERE (CATEGORIA_ID = '$cat_id') and (CAMPEONATO_ID = '$id_campeonato') and (NOMBRE = '$grupo_actual')";
                                $result_id_gru = $this->mysqli->query($sql_id_gru);
                                $row_grupo_id = mysqli_fetch_array($result_id_gru);
                                $id_grupo = $row_grupo_id['ID'];                               
                                $INSCRIPCION->SET_GRUPO($id_grupo);

                                //Para cada inscrito inicializamos su clasificación
                                $CLASIFICACION = new CLASIFICACION_Model(0,$inscripcion['PAREJA_ID'],$id_grupo);
                                $CLASIFICACION->ADD();
                                                
                                $num_inscritos--;   
                                $grupo_actual--; 

                                if($grupo_actual == 0){
                                    $grupo_actual = $num_grupos;

                                } 
                            /*
                            FIN ASIGNACIÓN DE INSCRITOS RESTANTES EN GRUPOS EXISTENTES
                            */  
                            }
                        
                        }
                        //Si sólo hay un grupo 
                        else{
                            //Metemos parejas hasta llegar al máximo (12)
                            $i = 0;
                            //Metemos en el grupo 1 siempre, sólo a 4 más
                            for ($i=0; $i < 4; $i++) { 

                                if($inscripcion = mysqli_fetch_array($result_insc)){

                                    $INSCRIPCION = new INSCRIPCION_Model('',$inscripcion['PAREJA_ID'],$inscripcion['CAM_CAT_ID']);

                                    //Asignamos el id del grupo correspondiente
                                    $sql_id_gru = "SELECT * FROM GRUPO WHERE (CATEGORIA_ID = '$cat_id') and (CAMPEONATO_ID = '$id_campeonato') and (NOMBRE = '$grupo_actual')";
                                    $result_id_gru = $this->mysqli->query($sql_id_gru);
                                    $row_grupo_id = mysqli_fetch_array($result_id_gru);
                                    $id_grupo = $row_grupo_id['ID'];                               
                                    $INSCRIPCION->SET_GRUPO($id_grupo);

                                    //Para cada inscrito inicializamos su clasificación
                                    $CLASIFICACION = new CLASIFICACION_Model(0,$inscripcion['PAREJA_ID'],$id_grupo);
                                    $CLASIFICACION->ADD();
                                                    
                                    $num_inscritos--;   

                                }
                                
                            }

                            for ($i=$num_inscritos; $i > 0 ; $i--){ 
                                if($inscripcion = mysqli_fetch_array($result_insc)){
                                    $INSCRIPCION = new INSCRIPCION_Model('',$inscripcion['PAREJA_ID'],$inscripcion['CAM_CAT_ID']);
                                    $INSCRIPCION->DELETE(); 
                                    $num_inscritos--;    
                                }
                                
                            }
                        }
                           
                }
            }//fIN WHILE
            return $this->GENERAR_ENFRENTAMIENTOS();    
        }
        else{
            return "ERROR: Debe existir al menos un campeonato con una categoría";
        }

    }
    

    //Función para generar los enfrentamientos
    function GENERAR_ENFRENTAMIENTOS(){
        $sql_grupos = "SELECT * FROM GRUPO";
        $result_grupos = $this->mysqli->query($sql_grupos);

        while ($row_grupo = mysqli_fetch_array($result_grupos)) {
            $num_grupo = $row_grupo['ID'];

            //Buscamos todas las parejas que pertenecen a un grupo
            $sql_par = "SELECT * FROM INSCRIPCION WHERE (GRUPO_ID = '$num_grupo')";
            $result_par = $this->mysqli->query($sql_par);
            $i = 0;

            //Convertimos el recordset de parejas de un grupo en un array
            while($row_pareja = mysqli_fetch_array($result_par)){
                $parejas[$i] = $row_pareja['PAREJA_ID'];
                $i++;
            }
            $num_parejas = mysqli_num_rows($result_par);

            //Realizamos los cruces de las parejas, todos juegan contra todos
            for ($i=0; $i < $num_parejas; $i++) { 

                $pareja1_id = $parejas[$i];

                for ($j=0; $j < $num_parejas; $j++) { 

                    //Comprobamos si ya exise el enfrentamiento
                    $pareja2_id = $parejas[$j];
                    $sql_com = "SELECT * FROM ENFRENTAMIENTO WHERE (
                        (
                        ( (PAREJA_1 = '$pareja1_id') and (PAREJA_2 = '$pareja2_id') ) or
                        ( (PAREJA_2 = '$pareja1_id') and (PAREJA_1 = '$pareja2_id') ) 
                        ) and
                        (GRUPO_ID = '$num_grupo')
                    )";
                    $result_com = $this->mysqli->query($sql_com);
                    if(mysqli_num_rows($result_com) == 0 && ($pareja1_id <> $pareja2_id)){ //Si no existe
                        $ENFRENTAMIENTO = new ENFRENTAMIENTO_Model($num_grupo, null, $pareja1_id, $pareja2_id, null);
                        $ENFRENTAMIENTO->ADD();
                    }
                    
                }   
            }

        }

        return "ENFRENTAMIENTO GENERADOS CON ÉXITO";
    }

    //Funcion que devuelve las categorias correspondientes a un campeonato
    function GET_CATEGORIAS($id_campeonato, $login, $loginPareja){
        
        $sql = "SELECT CAM_CAT.ID AS CAM_CAT_ID, NIVEL, GENERO FROM CAMPEONATO_CATEGORIA CAM_CAT, CAMPEONATO CAM, CATEGORIA CAT  WHERE (CAMPEONATO_ID = '$id_campeonato') 
                                                        AND (CAM_CAT.CAMPEONATO_ID=CAM.ID)
                                                        AND (CAM_CAT.CATEGORIA_ID=CAT.ID)
                                                        AND  (CAM_CAT.ID NOT IN 
                                                            (SELECT CAM_CAT_ID FROM INSCRIPCION I, PAREJA P WHERE (I.PAREJA_ID=P.ID) AND (((P.JUGADOR_1='$login')OR(P.JUGADOR_2='$loginPareja')) OR ((P.JUGADOR_1='$loginPareja')OR(P.JUGADOR_2='$login')) ) 
                                                            )
                                                        )";

        $result = $this->mysqli->query($sql); 

        if (!($result = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
            return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            if($result <> NULL) {
                  while($row = mysqli_fetch_array($result)){                                
                    $listCategorias[$row["CAM_CAT_ID"]] = array($row["NIVEL"],$row["GENERO"]);
                    }
                }
                    

        return $listCategorias;
        }  
    }
    


    }

    

?>

