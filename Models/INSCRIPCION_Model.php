<?php

class INSCRIPCION_Model{

	var $pareja_id;
	var $categoria_id;

	var $mysqli;

	function __construct($pareja_id,$categoria_id){
		$this->pareja_id = $pareja_id;
		$this->categoria_id = $categoria_id;

		include_once '../Functions/Access_DB.php';
        $this->mysqli = ConnectDB();
	}

	function ADD()
    {
        if (!$result = $this->mysqli->query($sql)){ //si da error la ejecución de la query
            return 'ERROR: No se ha podido conectar con la base de datos'; //error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
        }else { //si la ejecución de la query no da error
            $num_rows = mysqli_num_rows($result);

                $sql = "INSERT INTO INSCRIPCION(
                PAREJA_ID,
                CATEGORIA_ID) VALUES(
                                    '$this->pareja_id',
                                    '$this->categoria_id'
                                    )";
                
                if (!($result = $this->mysqli->query($sql))){ //ERROR en la consulta ADD
                    //Si no hay atributos Clave y unique duplicados es que hay campos sin completar
                    $this->mensaje['mensaje'] = 'ERROR: Introduzca todos los valores de todos los campos';
                    return $this->mensaje; // introduzca un valor para el usuario
                }else{
                    $this->mensaje['mensaje'] = 'Registrado correctamente';
                    return $this->mensaje; // introduzca un valor para el usuario
                }
        }
                    
    } // fin del metodo ADD

    //Función para asignar grupo a las parejas en una categoría de un campeonato
    function SET_GRUPO($grupo_id){
        $sql_up = "UPDATE INSCRIPCION SET GRUPO_ID = '$grupo_id'
                                 WHERE ((PAREJA_ID = '$this->pareja_id') and (CAM_CAT_ID = '$this->categoria_id'))";

        $res = $this->mysqli->query($sql_up);
    }

   } 

?>