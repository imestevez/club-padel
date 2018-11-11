<?php

class CAMPEONATO_Model{

    var $id;
    var $nombre;
	var $fecha;
    var $mensaje;

    var $lista;

	var $mysql;

	function __construct($id,$nombre,$fecha){
        $this->id = $id;
        $this->nombre = $nombre;
    	$this->fecha = $fecha;

        include_once '../Functions/Access_DB.php';

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
        $result = $this->mysqli->query($sql);
        if($result){
            //Devolvemos recordset de campeonatos
            return $result;
        }
        else{
            $this->mensaje = "ERROR: En la consulta de la base de datos.";
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
    function GENERAR_GRUPOS(){
        //Obtenemos las categorias del campeonato
        $sql_cat = "SELECT * FROM CAMPEONATO_CATEGORIA WHERE (CAMPEONATO_ID = '$this->id')";
        $result_cat = $this->mysqli->query($sql_cat);

        while($row = mysqli_fetch_array($result_cat)){
            //Para cada categoría obtenemos los inscritos
            $sql_insc = "SELECT * FROM INSCRIPCION WHERE (CATEGORIA_ID = '$row['CATEGORIA_ID']')";
            $result_insc = $this->mysqli->query($sql_insc);
            $num_inscritos = mysqli_num_rows($result_insc);
            
            //Creamos los grupos 
            $num_grupos = $num_inscritos/8;
            for ($grupo=$num_grupos; $grupo > 0 ; $grupo--) {

                if($inscripcion = mysqli_fetch_array($result_insc)){
                    if($num_inscritos/8 > 0){
                    //Si quedan más de 8 parejas por asignar grupo, creamos nuevo grupo
                        $GRUPO = new Grupo_Model($grupo, $this->id, $inscripcion['CATEGORIA_ID']);
                        $GRUPO->ADD();
                        for ($i=0; $i < 8; $i++) { 
                            //Registramos a un usuario como miembro de un grupo

                            $num_inscritos--;
                        }
                    }                   
                }                
            }

            //Si las parejas que quedan por asignar grupo son menos de 8, las repartimos entre los restantes grupos, cumpliendo que no haya más de 12
            $grupo_actual = $num_grupos;
            while($num_inscritos > 0 and $inscripcion = mysqli_fetch_array($result_insc)){

                $INSC_GRUPO = new INSCRIPCION_Model($inscripcion['PAREJA_ID'],$inscripcion['CATEGORIA_ID']);
                $INSC_GRUPO->SET_GRUPO($idGrupo);
                $grupo_actual--; 
                if($grupo_actual == 0){
                    $grupo_actual = $num_grupos;

                }   
            }
        }
        //Generamos los enfrentamientos para la primera fase
        $this->GENERAR_ENFRENTAMIENTOS();
    }

    //Función para generar los enfrentamientos
    function GENERAR_ENFRENTAMIENTOS(){

    }
}

?>