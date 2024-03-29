<?php

class INSCRIPCION_Model{

    var $fecha;
	var $pareja_id;
	var $cam_cat_id;

    var $mensaje;
	var $mysqli;

	function __construct($fecha,$pareja_id,$cam_cat_id){
        if($fecha <> NULL){   //si viene la fecha entera le cambiamos el formato para que se adecue al de la bd
            $aux = explode("/", $fecha);
            $this->fecha = date('Y-m-d',mktime(0,0,0,$aux[1],$aux[0],$aux[2]));
        }
		$this->pareja_id = $pareja_id;
		$this->cam_cat_id = $cam_cat_id;

		include_once '../Functions/Access_DB.php';
        $this->mysqli = ConnectDB();
	}

	function ADD()
    {

        $sql = "INSERT INTO INSCRIPCION(
                FECHA,
                PAREJA_ID,
                CAM_CAT_ID,
                GRUPO_ID) VALUES(
                                    '$this->fecha',
                                    '$this->pareja_id',
                                    '$this->cam_cat_id',
                                    null
                                    )";
        if ($result = $this->mysqli->query($sql)){ //si la ejecución de la query no da error
                    $this->mensaje = 'Registrado correctamente';
                    return $this->mensaje; // introduzca un valor para el usuario  
        }else { //si da error la ejecución de la query
            $this->mensaje='ERROR: No se ha podido conectar con la base de datos';
           return $this->mensaje; //error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
        }
                    
    } // fin del metodo ADD

    //Función para asignar grupo a las parejas en una categoría de un campeonato
    function SET_GRUPO($grupo_id){
        $sql_up = "UPDATE INSCRIPCION SET GRUPO_ID = '$grupo_id'
                                 WHERE ((PAREJA_ID = '$this->pareja_id') and (CAM_CAT_ID = '$this->cam_cat_id'))";

        $res = $this->mysqli->query($sql_up);
    }

    //Función para eliminar inscripciones de la bd
    function DELETE(){
        $sql_del = "DELETE FROM INSCRIPCION WHERE (PAREJA_ID = '$this->pareja_id') and (CAM_CAT_ID = '$this->cam_cat_id')";
        $res = $this->mysqli->query($sql_del);

    }

   } 

?>

