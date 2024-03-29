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
       $clasificaciones = $this->mysqli->query($sql_reset);
       $sql_enfr = "SELECT * FROM ENFRENTAMIENTO ORDER BY ID";
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
    
    function NUM_GRUPOS($campeonato_id){
        $sql_cam = "SELECT * FROM GRUPO WHERE (CAMPEONATO_ID = '$campeonato_id')";
        $res_cam = $this->mysqli->query($sql_cam);
        return mysqli_num_rows($res_cam);
    }

    function GET_GRUPOS($campeonato_id){
        $sql_cam = "SELECT * FROM GRUPO WHERE (CAMPEONATO_ID = '$campeonato_id')";
        return $res_cam = $this->mysqli->query($sql_cam);

    }

    function SHOWALL($campeonato_id){
        $grupos = $this->GET_GRUPOS($campeonato_id);
        $i = 0;
        $list_grupo =  NULL;

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
                        (C.GRUPO_ID = '$id_grupo')
                    GROUP BY P.ID
                    ORDER BY C.PUNTOS DESC";

            if($clasificacion_grupo = $this->mysqli->query($sql)){  
                $list_grupo[$id_grupo] = $clasificacion_grupo;
                $i++;       
            }  

        }
        return $list_grupo;

    }

    function getArray(){

    }

    function CAM_CAT_GRU($campeonato_id){

        $sql_cam = "SELECT  G.NOMBRE AS GRUPO_NOMBRE,
                            CM.NOMBRE AS CAMPEONATO_NOMBRE,
                            CT.NIVEL AS NIVEL, 
                            CT.GENERO AS GENERO,
                            G.ID AS GRUPO_ID

                        FROM    GRUPO G,
                                CAMPEONATO_CATEGORIA CC,
                                CAMPEONATO CM,
                                CATEGORIA CT

                        WHERE   (G.CAMPEONATO_ID = CC.CAMPEONATO_ID) AND
                                (G.CATEGORIA_ID = CC.CATEGORIA_ID) AND
                                (CM.ID = CC.CAMPEONATO_ID) AND
                                (CT.ID = CC.CATEGORIA_ID) AND
                                (G.CAMPEONATO_ID = CM.ID) AND
                                (G.CATEGORIA_ID = CT.ID) AND 
                                (CM.ID = '$campeonato_id')";
        return $res_cam = $this->mysqli->query($sql_cam);
    }


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

        $p1_pt = 0;
        $p2_pt = 0;

        $ganador_partido = $this->GANADOR_PARTIDO($ganador_set_1,$ganador_set_2,$ganador_set_3);
        $sql_enf = "SELECT * FROM ENFRENTAMIENTO WHERE (ID = '$enfrentamiento')";

        $res_enf = $this->mysqli->query($sql_enf);

        if ($row_enf = mysqli_fetch_array($res_enf) ){
            $pareja_1 = $row_enf['PAREJA_1'];
            $pareja_2 = $row_enf['PAREJA_2'];
            $grupo_id = $row_enf['GRUPO_ID'];
        }

        //Cogemos la puntucacion actual del las parejas
        $sql_pt1 = "SELECT * FROM CLASIFICACION WHERE (PAREJA_ID = '$pareja_1') AND (GRUPO_ID = '$grupo_id')";
        $res_enf1 = $this->mysqli->query($sql_pt1);
        $sql_pt2 = "SELECT * FROM CLASIFICACION WHERE (PAREJA_ID = '$pareja_2') AND (GRUPO_ID = '$grupo_id') ";

        $res_enf2 = $this->mysqli->query($sql_pt2);
        $row_enf1 = mysqli_fetch_array($res_enf1);
        $row_enf2 = mysqli_fetch_array($res_enf2);
        
            $p1_pt = $row_enf1['PUNTOS'];
            $p2_pt = $row_enf2['PUNTOS'];

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
        $sql_UP1 = "UPDATE CLASIFICACION SET PUNTOS = '$p1_pt' WHERE (PAREJA_ID = '$pareja_1') AND (GRUPO_ID = '$grupo_id') ";
        $sql_UP2 = "UPDATE CLASIFICACION SET PUNTOS = '$p2_pt' WHERE (PAREJA_ID = '$pareja_2') AND (GRUPO_ID = '$grupo_id') ";
        $this->mysqli->query($sql_UP1);
        $this->mysqli->query($sql_UP2);    
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