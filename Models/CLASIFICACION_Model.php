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

               include_once '../Models/ENFRENTAMIENTO_Model.php';
        include_once '../Functions/Access_DB.php';
               $this->mysqli = ConnectDB();

               $this->UPDATE_PUNTOS();
    }

    function UPDATE_PUNTOS(){
       $sql_reset = "UPDATE CLASIFICACION SET PUNTOS = 0";
       //echo $sql_reset;

       $clasificaciones = $this->mysqli->query($sql_reset);
       $sql_enfr = "SELECT * FROM ENFRENTAMIENTO";
       //echo $sql_enfr;
       $enfrentamientos = $this->mysqli->query($sql_enfr);
       while ($row = mysqli_fetch_array($enfrentamientos)) {
           $enfrentamiento_id = $row['ID'];
           $grupo_id = $row['GRUPO_ID'];
           $pareja_1 = $row['PAREJA_1'];
           $pareja_2 = $row['PAREJA_2'];
           $resultado = $row['RESULTADO'];
           if($resultado <> NULL){
               $sql_clasif = "SELECT * FROM CLASIFICACION 
                               WHERE (GRUPO_ID = '$grupo_id') AND
                               (  PAREJA_ID = '$pareja_1'
                               ||  PAREJA_ID = '$pareja_2')";

              if($recordset = $this->mysqli->query($sql_clasif)){
                   $num_rows = mysqli_num_rows($recordset);
                   if ($num_rows > 0){
                       $this->ACTUALIZAR_CLASIFICACION($resultado, $enfrentamiento_id);
                   }
               }
           }
       }
   }
    
    /*
    function SHOWALL($campeonato_id){

        $sql_cam = "SELECT * 
                            FROM CAMPEONATO_CATEGORIA CC,
                                 CATEGORIA C
                                 WHERE  (CC.CAMPEONATO_ID = '$campeonato_id') AND
                                        (C.ID = CC.CATEGORIA_ID)";

        $res_cam = $this->mysqli->query($sql_cam);
        $g = 0;
        $clasificaciones = NULL;
        while($row_cam = mysqli_fetch_array($res_cam)){
            $campeonato_id = $row_cam['CAMPEONATO_ID'];
            $categoria_id = $row_cam['CATEGORIA_ID'];
            $sql_gru = "SELECT * FROM GRUPO WHERE (CAMPEONATO_ID = '$campeonato_id') AND (CATEGORIA_ID = '$categoria_id')";
            $res_gru = $this->mysqli->query($sql_gru);
            $grupo = NULL;
            while($row_gru = mysqli_fetch_array($res_gru)){
                $grupo_id = $row_gru['ID'];
                $nombre_id = $row_gru['NOMBRE'];
                var_dump($grupo_id."Y".$nombre_id);

                $sql_cla = "SELECT  CL.PUNTOS,
                                    P.JUGADOR_1,
                                    P.JUGADOR_2,
                                    G.NOMBRE AS GRUPO_NOMBRE,
                                    CT.NIVEL,
                                    CT.GENERO,
                                    CM.NOMBRE AS CAMPEONATO_NOMBRE,
                                    CL.ID AS CLASIFICACION_ID,
                                    CL.GRUPO_ID

                                    FROM
                                    CLASIFICACION CL,
                                    GRUPO G,
                                    CATEGORIA CT,
                                    CAMPEONATO CM,
                                    PAREJA P

                                    WHERE
                                    (CL.GRUPO_ID = '$grupo_id') AND
                                    (CL.GRUPO_ID = G.ID) AND
                                    (CT.ID = G.CATEGORIA_ID) AND
                                    (CM.ID = G.CAMPEONATO_ID) AND
                                    (CL.PAREJA_ID = P.ID)

                                    ORDER BY CL.PUNTOS DESC";


                $re_cla = $this->mysqli->query($sql_cla); 
                $clas_grupo = NULL;
                $i = 0;
                while($row_cla = mysqli_fetch_array($re_cla)){    
                    $clasificacion_id = $row_cla['CLASIFICACION_ID'];    

                    $clas_grupo[$row_cla['CLASIFICACION_ID']] = array(
                                                                 $row_cla['CAMPEONATO_NOMBRE'],  
                                                                 $row_cla['JUGADOR_1'],    
                                                                 $row_cla['JUGADOR_2'],    
                                                                 $row_cla['PUNTOS']     
                                                                );

                    $grupo[$clasificacion_id] = $clas_grupo;
                }

                
            }
            $cat_gru = $row_cam['NIVEL']." ".$row_cam['GENERO']." Grupo - ".$grupo_id;
            $cat_grupos[$cat_gru] = $grupo;   
        }
        return $cat_grupos;
    }
    */
    function NUM_GRUPOS($campeonato_id){
        $sql_cam = "SELECT * FROM GRUPO WHERE (CAMPEONATO_ID = '$campeonato_id')";
        $res_cam = $this->mysqli->query($sql_cam);
        return mysqli_num_rows($res_cam);
    }

    function GET_GRUPOS($campeonato_id){
        echo "VOY A ENTRAR AQUI";
        $sql_cam = "SELECT * FROM GRUPO WHERE (CAMPEONATO_ID = '$campeonato_id')";
        return $res_cam = $this->mysqli->query($sql_cam);

    }

    function SHOWALL($campeonato_id){
        $grupos = $this->GET_GRUPOS($campeonato_id);
        $i = 0;
        $grupo =  array();
        while ( $grupo = mysqli_fetch_array($grupos) ) {
            $id_grupo = $grupo['ID'];

            $sql = "SELECT 
                        C.PUNTOS,
                        P.JUGADOR_1,
                        P.JUGADOR_2
                    FROM
                        CLASIFICACION C,
                        PAREJA P
                    WHERE
                        (C.PAREJA_ID = P.ID) AND
                        (C.GRUPO_ID = '$id_grupo')";

                        echo "SQL: ".$sql;

            $clasificacion_grupo = $this->mysqli->query($sql);  
            $grupo[$i] = $clasificacion_grupo;

            $i++;          
        }
        echo "GRUPO: ".$grupo[0];
        return $grupo;

    }

    function getArray(){

    }

    function CAM_CAT_GRU($campeonato_id){
        $sql_cam = "SELECT  G.NOMBRE AS GRUPO_NOMBRE,
                            CM.NOMBRE AS CAMPEONATO_NOMBRE,
                            CT.NIVEL AS NIVEL, 
                            CT.GENERO AS GENERO

                        FROM    GRUPO G,
                                CAMPEONATO_CATEGORIA CC,
                                CAMPEONATO CM,
                                CATEGORIA CT

                        WHERE   (G.CAMPEONATO_ID = CC.CAMPEONATO_ID) AND
                                (G.CATEGORIA_ID = CC.CATEGORIA_ID) AND
                                (CM.ID = CC.CAMPEONATO_ID) AND
                                (CT.ID = CC.CATEGORIA_ID) AND
                                (G.CAMPEONATO_ID = CM.ID) AND
                                (G.CATEGORIA_ID = CT.ID)";
        return $res_cam = $this->mysqli->query($sql_cam);
    }

    /*
	//Función para obtener los campeonatos en los que participa un usuario
	function SHOWALL(){

		$sql = "SELECT CAT.NIVEL, CAT.GENERO, G.NOMBRE,  P.JUGADOR_1, P.JUGADOR_2, CL.PUNTOS
                FROM CATEGORIA CAT, CAMPEONATO CAM, CAMPEONATO_CATEGORIA CAM_CAT, GRUPO G, CLASIFICACION CL, PAREJA P
                WHERE   ( (CAM.ID = CAM_CAT.CAMPEONATO_ID)
                		AND (CAT.ID = CAM_CAT.CATEGORIA_ID)
                		AND (CAT.ID = G.CATEGORIA_ID)
                		AND (CAM.ID = G.CAMPEONATO_ID)
                		AND (G.ID = CL.GRUPO_ID)
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
                    $listClasificacion[$i] = array($row["NIVEL"],$row["GENERO"],$row["NOMBRE"],$row["JUGADOR_1"],$row["JUGADOR_2"],$row["PUNTOS"]);
                    $i++;
                }   
            }
        }  
		return $listClasificacion;
	}
    */

    function ACTUALIZAR_CLASIFICACION($resultado, $enfrentamiento){
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

        $sql_enf = "SELECT * FROM ENFRENTAMIENTO WHERE (ID = '$enfrentamiento')";

        $res_enf = $this->mysqli->query($sql_enf);

        if ($row_enf = mysqli_fetch_array($res_enf) ){
            $pareja_1 = $row_enf['PAREJA_1'];
            $pareja_2 = $row_enf['PAREJA_2'];
            $grupo_id = $row_enf['GRUPO_ID'];
        }

        //Cogemos la puntucacion actual del las parejas
        $sql_pt1 = "SELECT * FROM CLASIFICACION WHERE (PAREJA_ID = '$pareja_1')";
        $res_enf1 = $this->mysqli->query($sql_pt1);
        $sql_pt2 = "SELECT * FROM CLASIFICACION WHERE (PAREJA_ID = '$pareja_2')";
        $res_enf2 = $this->mysqli->query($sql_pt2);

        $p1_pt = 0;
        $p2_pt = 0;
        if($row_enf1 = mysqli_fetch_array($res_enf1) && $row_enf2 = mysqli_fetch_array($res_enf2)){
            $p1_pt = $row_enf1['PUNTOS'];
            $p2_pt = $row_enf2['PUNTOS'];
        } 

        if($ganador_partido == 1){
            $p1_pt = $p1_pt + 3;
            $p2_pt = $p2_pt + 1;   
        }

        if($ganador_partido == 2){         
            $p1_pt = $p1_pt + 1;
            $p2_pt = $p2_pt + 3;   
        }

        if($ganador_partido == 0){
        }

        //Actualizamos las clasificaciones
        $sql_UP1 = "UPDATE CLASIFICACION SET PUNTOS = '$p1_pt' WHERE (PAREJA_ID = '$pareja_1')";
        $sql_UP2 = "UPDATE CLASIFICACION SET PUNTOS = '$p2_pt' WHERE (PAREJA_ID = '$pareja_2')";
        $this->mysqli->query($sql_UP1);
        $this->mysqli->query($sql_UP2);    
    }
    /*
    function ACTUALIZAR_CLASIFICACION($resultado, $enfrentamiento){
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

        if($ganador_partido==1){
            $sql_par1="SELECT PAREJA_1 FROM ENFRENTAMIENTO WHERE(ID=$enfrentamiento)";
            $id_par1=$this->mysqli->query($sql_par1);

            $sql_par2="SELECT PAREJA_2 FROM ENFRENTAMIENTO WHERE(ID=$enfrentamiento)";
            $id_par2=$this->mysqli->query($sql_par2);

            $sql1 = "UPDATE CLASIFICACION SET (PUNTOS = 3+(SELECT PUNTOS FROM CLASIFICACION WHERE '(PAREJA_ID=$id_par1)')) WHERE '(PAREJA_ID=$id_par1)'";
            $sql2 = "UPDATE CLASIFICACION SET (PUNTOS = (PUNTOS+1)) WHERE '(PAREJA_ID=$id_par2)'";
            $this->mysqli->query($sql1);
            $this->mysqli->query($sql2);

        }else if ($ganador_partido==2){
            $sql_par1="SELECT PAREJA_1 FROM ENFRENTAMIENTO WHERE(ID=$enfrentamiento)";
            $id_par1=$this->mysqli->query($sql_par1);

            $sql_par2="SELECT PAREJA_2 FROM ENFRENTAMIENTO WHERE(ID=$enfrentamiento)";
            $id_par2=$this->mysqli->query($sql_par2);

            $sql1 = "UPDATE CLASIFICACION SET (PUNTOS = (PUNTOS+1)) WHERE '(PAREJA_ID=$id_par1)'";
            $sql2 = "UPDATE CLASIFICACION SET (PUNTOS = (PUNTOS+3)) WHERE '(PAREJA_ID=$id_par2)'";
            $this->mysqli->query($sql1);
            $this->mysqli->query($sql2);
        }

    }
    */

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
            return 2;
        }

        return 0;
    }


    function ADD(){
        $sql = "INSERT INTO CLASIFICACION(ID, PAREJA_ID,GRUPO_ID,PUNTOS) VALUES(null,$this->pareja_ID,$this->grupo_id,0)";
        $res = $this->mysqli->query($sql);
    }

}

?>