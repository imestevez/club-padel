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
                    $listPartidos[$row["ID"]] = array($row["NOMBRE"],$row["FECHA"]);
                    }   
                }
                return $listPartidos;
        }  
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
        
        echo "VOY A GENERAR GRUPOS";
        //Obtenemos las categorias del campeonato
        $sql_cat = "SELECT * FROM CAMPEONATO_CATEGORIA WHERE (CAMPEONATO_ID = '$id_campeonato')";
        $result_cat = $this->mysqli->query($sql_cat);
        echo "VOY A EMPEZAR";
        while($row = mysqli_fetch_array($result_cat)){
            //Para cada categoría obtenemos los inscritos
            $cat_id = $row['CATEGORIA_ID'];
            $sql_insc = "SELECT * FROM INSCRIPCION I, CAMPEONATO_CATEGORIA C 
                WHERE   (I.CAM_CAT_ID = C.ID) and
                        (C.CATEGORIA_ID = '$cat_id') and
                        (C.CAMPEONATO_ID = '$id_campeonato')
                        ";           
            $result_insc = $this->mysqli->query($sql_insc);
            $num_inscritos = mysqli_num_rows($result_insc);
            
            //Creamos los grupos 
            $num_grupos = floor($num_inscritos/8);

            
            for ($grupo = 1; $grupo <= $num_grupos ; $grupo++) { 
                    
                    if($num_inscritos/8 > 0){
                    //Si quedan más de 8 parejas por asignar grupo, creamos nuevo grupo
                        $GRUPO = new GRUPO_Model($grupo,$id_campeonato,$cat_id);
                        $GRUPO->ADD();
                        
                        for ($i=0; $i < 8; $i++) { 
                            //Registramos a un usuario como miembro de un grupo
                            if($inscripcion = mysqli_fetch_array($result_insc)){
                                $INSCRIPCION = new INSCRIPCION_Model($inscripcion['PAREJA_ID'],$inscripcion['CAM_CAT_ID']);

                                //Asignamos el id del grupo correspondiente
                                $sql_id_gru = "SELECT * FROM GRUPO WHERE (CATEGORIA_ID = '$cat_id') and (CAMPEONATO_ID = '$id_campeonato') and (NOMBRE = '$grupo')";
                                $result_id_gru = $this->mysqli->query($sql_id_gru);
                                $row_grupo_id = mysqli_fetch_array($result_id_gru);
                                $id_grupo = $row_grupo_id['ID'];                               
                                $INSCRIPCION->SET_GRUPO($id_grupo);

                                $num_inscritos--;    
                            }                             
                        }
                        
                    } 
                                                                     
            }
            
            //Si las parejas que quedan por asignar grupo son menos de 8, las repartimos entre los restantes grupos, cumpliendo que no haya más de 12
            $grupo_actual = $num_grupos;
            while($num_inscritos > 0 and $inscripcion = mysqli_fetch_array($result_insc)){

                $INSCRIPCION = new INSCRIPCION_Model($inscripcion['PAREJA_ID'],$inscripcion['CAM_CAT_ID']);

                //Asignamos el id del grupo correspondiente
                $sql_id_gru = "SELECT * FROM GRUPO WHERE (CATEGORIA_ID = '$cat_id') and (CAMPEONATO_ID = '$id_campeonato') and (NOMBRE = '$grupo_actual')";
                echo "VOY A CAMBIAR: ".$sql_id_gru;
                $result_id_gru = $this->mysqli->query($sql_id_gru);
                $row_grupo_id = mysqli_fetch_array($result_id_gru);
                $id_grupo = $row_grupo_id['ID'];                               
                $INSCRIPCION->SET_GRUPO($id_grupo);
                                
                $num_inscritos--;   
                $grupo_actual--; 

                if($grupo_actual == 0){
                    $grupo_actual = $num_grupos;

                }   
            }
            
        }
        
        //Generamos los enfrentamientos para la primera fase
        return $this->GENERAR_ENFRENTAMIENTOS();

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
                        ( (PAREJA_1 = '$pareja1_id') and (PAREJA_2 = '$pareja2_id') ) or
                        ( (PAREJA_2 = '$pareja1_id') and (PAREJA_1 = '$pareja2_id') ) 
                    )";
                    $result_com = $this->mysqli->query($sql_com);
                    if(mysqli_num_rows($result_com) == 0 and ($pareja1_id <> $pareja2_id)){ //Si no existe
                        $ENFRENTAMIENTO = new ENFRENTAMIENTO_Model($num_grupo, null, $pareja1_id, $pareja2_id, null);
                        $ENFRENTAMIENTO->ADD();
                    }
                    
                }   
            }

        }

        return "ENFRENTAMIENTO GENERADOS CON ÉXITO";
    }

    //Funcion que devuelve las categorias correspondientes a un campeonato
    function GET_CATEGORIAS($id_campeonato){
        echo "GET DE CATEGORIAS";
        $sql = "SELECT * FROM CAMPEONATO_CATEGORIA WHERE (CAMPEONATO_ID = '$id_campeonato')";

        $result = $this->mysqli->query($sql); 

        if (!($result = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
            return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            if($result <> NULL) {
                  while($row = mysqli_fetch_array($result)){                                
                    $listCategorias[$row["CAMPEONATO_ID"]] = array($row["CAMPEONATO_ID"],$row["CATEGORIA_ID"]);
                    }   
                }
        return $listCategorias;
        }  
    }
    


    }

    
    


?>