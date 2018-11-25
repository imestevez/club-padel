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
        include_once '../Models/ENFRENTAMIENTO_Model.php';

        $this->mysqli = ConnectDB();

        
    }

    //Función añadir un campeonato a la bd
    function ADD(){
 
        $sql = "INSERT INTO CAMPEONATO(ID,NOMBRE, FECHA) 
                VALUES( 0,
                        '$this->nombre',
                        '$this->fecha')"; 

        $result = $this->mysqli->query($sql);

        if($result){
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

