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

    function ACTUALIZAR_CLASIFICACION($resultado){
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

        $ganador_partido = $this->GANADOR_PARTIDO($ganador_set_1,$ganador_set_2,$ganador_set_3);
        //0 - empate
        //1 - pareja 1
        //2 - pareja 2

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

    function GANADOR_PARTIDO($set1,$set2,$set3){
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
            return 1;
        }

        return 0;
    }


    function ADD(){
        $sql = "INSERT INTO CLASIFICACION(ID, PAREJA_ID,GRUPO_ID,PUNTOS) VALUES(null,$this->pareja_ID,$this->grupo_id,0)";
        $res = $this->mysqli->query($sql);
    }

}

?>