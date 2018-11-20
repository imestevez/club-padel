<?php

class CLASIFICACION_Model{
	var $puntos;
	var $pareja_ID;
    var $grupo_id;


	var $mysqli;

	function __construct($puntos,$pareja_ID,$grupo_id){
		$this->puntos=$puntos;
		$this->pareja_ID=$pareja_ID;
        $this->grupo_id=$grupo_id;


		include_once '../Functions/Access_DB.php';
        $this->mysqli = ConnectDB();
	}



	//Función para obtener los campeonatos en los que participa un usuario
	function SHOWALL(){

		$sql = "SELECT CAT.NIVEL, CAT.GENERO, G.NOMBRE,  P.JUGADOR_1, P.JUGADOR_2, CL.PUNTOS
                FROM CATEGORIA CAT, CAMPEONATO CAM, CAMPEONATO_CATEGORIA CAM_CAT, GRUPO G, CLASIFICACION CL, PAREJA P, CATEGORIA_CLASIFICACION CAT_CL, GRUPO_CLASIFICACION G_CL
                WHERE   ( (CAM.ID = CAM_CAT.CAMPEONATO_ID)
                		AND (CAT.ID = CAM_CAT.CATEGORIA_ID)
                		AND (CAT.ID = G.CATEGORIA_ID)
                		AND (CAM.ID = G.CAMPEONATO_ID)
                		AND (CL.ID = CAT_CL.CLASIFICACION_ID)
                		AND (CAT.ID = CAT_CL.CATEGORIA_ID)
                		AND (CL.ID = G_CL.CLASIFICACION_ID)
                		AND (G.ID = G_CL.GRUPO_ID)
                		AND (CL.PAREJA_ID = P.ID) )     
                ORDER BY 1, 2, 4";
            // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
            return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            if($resultado <> NULL) {
            	$i =0;
                while($row = mysqli_fetch_array($resultado)){                                
                    $listClasificacion[$row[$i]] = array($row["NIVEL"],$row["GENERO"],$row["NOMBRE"],$row["JUGADOR_1"],$row["JUGADOR_2"],$row["PUNTOS"]);
                    $i++;
                }   
            }
        }  
		return $listClasificacion;
	}

    function ADD(){
        $sql = "INSERT INTO CLASIFICACION(ID, PAREJA_ID,GRUPO_ID,PUNTOS) VALUES(null,$this->pareja_ID,$this->grupo_id,0)";
        $res = $this->mysqli->query($sql);
    }

}

?>