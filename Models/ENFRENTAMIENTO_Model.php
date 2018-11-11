<?php

class ENFRENTAMIENTO_Model{

	var $grupo_id;
    var $resultado;
    var $pareja_1;
    var $pareja_2;
    var $reserva_id;

    var $mensaje;

	var $mysql;

	function __construct($grupo_id,$resultado,$pareja_1,$pareja_1,$reserva_id){

    	$this->grupo_id = $grupo_id;
    	$this->resultado = $resultado;
    	$this->pareja_1 = $pareja_1;
    	$this->pareja_2 = $pareja_2;
        $this->reserva_id = $reserva_id;

        include_once '../Functions/Access_DB.php';

        $this->mysqli = ConnectDB();
    }

    //Función para crar enfrentamientos, automatizada y con reserva y resultado a null, posteriormente se actualizarán sus valores
    function ADD(){
    	
        //Comprobamos que no se ha creado el enfrentamiento previamente
        $sql_cmp = "SELECT * FROM ENFRENTAMIENTO WHERE(
            (PAREJA_1 = '$this->pareja_1' ) and (PAREJA_2 = '$this->pareja_2')
        )";

        $result_cmp = $this->mysqli->query($sql_cmp);
        if($result_cmp){
            if(mysqli_num_rows($result_cmp) > 0){
                $this->mensaje = "ERROR: Este enfrentamiento ya ha sido registrado";
            }
            else{
                //Insertamos el enfrentamiento de la BD
                $sql_ins = "INSERT INTO ENFRENTAMIENTO(ID,GRUPO_ID,RESULTADO,PAREJA_1,PAREJA_2,RESERVA_ID) VALUES(null,$this->grupo_id,null,$this->pareja_1,$this->pareja_2,null)";

                $result_ins = $this->mysqli->query($sql_ins);
                if($result_ins){
                    $this->mensaje = "Enfrentamiento registrado correctamente";
                }
                else{
                    $this->mensaje = "ERROR: En la inserción en la bd";
                }
            }
        }else{
            $this->mensaje = "ERROR: En la sentencia sql"
        }
    }

    
        
    }
}

?>