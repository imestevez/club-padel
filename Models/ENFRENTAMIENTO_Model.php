<?php

class ENFRENTAMIENTO_Model{

	var $grupo_id;
    var $resultado;
    var $pareja_1;
    var $pareja_2;
    var $reserva_id;

    var $mensaje;

	var $mysql;

	function __construct($grupo_id,$resultado,$pareja_1,$pareja_2,$reserva_id){

    	$this->grupo_id = $grupo_id;
    	$this->resultado = $resultado;
    	$this->pareja_1 = $pareja_1;
    	$this->pareja_2 = $pareja_2;
        $this->reserva_id = $reserva_id;

        include_once '../Models/HUECO_Model.php';


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
        }
        else{
            $this->mensaje = "ERROR: En la sentencia sql";
        }
    } 

    //Función para asociar una reserva a un enfrentamiento
    function SET_RESULTADO($enfrentamiento_id){
        $sql_up = "UPDATE ENFRENTAMIENTO SET RESULTADO = '$this->resultado'
                                 WHERE (ID = '$enfrentamiento_id')";

        $res = $this->mysqli->query($sql_up);
    }

    //Función para asociar una reserva a un enfrentamiento
    function SET_RESERVA($enfrentamiento_id){
        $sql_up = "UPDATE ENFRENTAMIENTO SET RESERVA_ID = '$this->reserva_id'
                                 WHERE (ID = '$enfrentamiento_id')";

        $res = $this->mysqli->query($sql_up);
    }

    function SHOW(){
         $sql = "SELECT * FROM ENFRENTAMIENTO ORDER BY ID";
            // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
        if (!($resultado = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
            return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        }  
    }

    //Función para mostrar a un usuario las propuestas de horarios que tiene para los enfrentamientos en los que está involucrado como pareja 1
    function SHOW_TUSOFERTAS1($login_us){

        //Para ese login buscamos todas las pareajas de las que es capitán
        $sql_par = "SELECT * FROM PAREJA WHERE (CAPITAN = '$login_us')";
        if($result_par = $this->mysqli->query($sql_par)){
           //Para cada pareja buscamos sus enfrentamientos
            while($row_pareja = mysqli_fetch_array($result_par)){
                $id_pareja = $row_pareja['ID'];
                //Buscamos todos los enfrentamientos de una pareja como pareja1
                $sql_enf = "SELECT  CA.NOMBRE AS CAM_NOMBRE,
                                    CT.NIVEL,
                                    CT.GENERO,
                                    G.NOMBRE AS GR_NOMBRE,
                                    P.ID AS PAREJA_ID,
                                    P.CAPITAN,
                                    E.ID AS ID_ENFRENTAMIENTO,
                                    E.PAREJA_1 AS PAREJA_ID

                                    FROM 
                                    ENFRENTAMIENTO E,
                                    HUECO H,
                                    PAREJA P,
                                    GRUPO G,
                                    CATEGORIA CT,
                                    CAMPEONATO CA
                                    WHERE 

                                    (E.ID = H.ENFRENTAMIENTO_ID) and
                                    (E.GRUPO_ID = G.ID) and
                                    (G.CAMPEONATO_ID = CA.ID) and
                                    (G.CATEGORIA_ID = CT.ID) and
                                    (E.PAREJA_2 = P.ID) and
                                    (E.PAREJA_1 = '$id_pareja') and 
                                    (H.PAREJA_ID = E.PAREJA_2)
                            ";          

                $result_enf = $this->mysqli->query($sql_enf);
                return $result_enf;   
            }
            
        }

    }   

    //Función para mostrar a un usuario las propuestas de horarios que tiene para los enfrentamientos en los que está involucrado como pareja 2
    function SHOW_TUSOFERTAS2($login_us){

        //Para ese login buscamos todas las pareajas de las que es capitán
        $sql_par = "SELECT * FROM PAREJA WHERE (CAPITAN = '$login_us')";
        if($result_par = $this->mysqli->query($sql_par)){
           //Para cada pareja buscamos sus enfrentamientos
            while($row_pareja = mysqli_fetch_array($result_par)){
                $id_pareja = $row_pareja['ID'];
                //Buscamos todos los enfrentamientos de una pareja como pareja1
                $sql_enf = "SELECT  CA.NOMBRE AS CAM_NOMBRE,
                                    CT.NIVEL,
                                    CT.GENERO,
                                    G.NOMBRE AS GR_NOMBRE,
                                    P.CAPITAN,
                                    E.ID AS ID_ENFRENTAMIENTO,
                                    E.PAREJA_2 AS PAREJA_ID

                                    FROM 
                                    ENFRENTAMIENTO E,
                                    HUECO H,
                                    PAREJA P,
                                    GRUPO G,
                                    CATEGORIA CT,
                                    CAMPEONATO CA
                                    WHERE

                                    (E.ID = H.ENFRENTAMIENTO_ID) and
                                    (E.GRUPO_ID = G.ID) and
                                    (G.CAMPEONATO_ID = CA.ID) and
                                    (G.CATEGORIA_ID = CT.ID) and
                                    (E.PAREJA_1 = P.ID) and
                                    (E.PAREJA_2 = '$id_pareja') and 
                                    (H.PAREJA_ID = E.PAREJA_1)
                            ";

                $result_enf = $this->mysqli->query($sql_enf);
                return $result_enf;   
            }
            
        }

    }   

    //Enfrentamientos que no han sido propuesto horario por ningun jugador
    function SHOW_ENFRENTAMIENTOS1($login_us){
         //Para ese login buscamos todas las pareajas de las que es capitán
        $sql_par = "SELECT * FROM PAREJA WHERE (CAPITAN = '$login_us')";
        if($result_par = $this->mysqli->query($sql_par)){
           //Para cada pareja buscamos sus enfrentamientos
            while($row_pareja = mysqli_fetch_array($result_par)){
                $id_pareja = $row_pareja['ID'];
                $sql_enf = "SELECT  CA.NOMBRE AS CAM_NOMBRE,
                                    CT.NIVEL,
                                    CT.GENERO,
                                    G.NOMBRE AS GR_NOMBRE,
                                    P.CAPITAN,
                                    E.ID AS ID_ENFRENTAMIENTO,
                                    E.PAREJA_1 AS ID_PAREJA

                                    FROM

                                    ENFRENTAMIENTO E,
                                    PAREJA P,
                                    GRUPO G,
                                    CATEGORIA CT,
                                    CAMPEONATO CA


                                    WHERE

                                    (E.GRUPO_ID = G.ID) and
                                    (G.CAMPEONATO_ID = CA.ID) and
                                    (G.CATEGORIA_ID = CT.ID) and
                                    (E.PAREJA_2 = P.ID) and
                                    (E.PAREJA_1 = '$id_pareja') and
                                    (E.ID NOT IN (SELECT ENFRENTAMIENTO_ID FROM HUECO)) 
                            ";
                $result_enf = $this->mysqli->query($sql_enf);
                return $result_enf;   
            }
            
        }
    }

    //Enfrentamientos que no han sido propuesto horario por ningun jugador
    function SHOW_ENFRENTAMIENTOS2($login_us){
         //Para ese login buscamos todas las pareajas de las que es capitán
        $sql_par = "SELECT * FROM PAREJA WHERE (CAPITAN = '$login_us')";
        if($result_par = $this->mysqli->query($sql_par)){
           //Para cada pareja buscamos sus enfrentamientos
            while($row_pareja = mysqli_fetch_array($result_par)){
                $id_pareja = $row_pareja['ID'];
                $sql_enf = "SELECT  CA.NOMBRE AS CAM_NOMBRE,
                                    CT.NIVEL,
                                    CT.GENERO,
                                    G.NOMBRE AS GR_NOMBRE,
                                    P.CAPITAN,
                                    E.ID AS ID_ENFRENTAMIENTO,
                                    E.PAREJA_2 AS ID_PAREJA

                                    FROM

                                    ENFRENTAMIENTO E,
                                    PAREJA P,
                                    GRUPO G,
                                    CATEGORIA CT,
                                    CAMPEONATO CA

                                    WHERE

                                    (E.GRUPO_ID = G.ID) and
                                    (G.CAMPEONATO_ID = CA.ID) and
                                    (G.CATEGORIA_ID = CT.ID) and
                                    (E.PAREJA_1 = P.ID) and
                                    (E.PAREJA_2 = '$id_pareja')  
                            ";
                $result_enf = $this->mysqli->query($sql_enf);
                return $result_enf;   
            }
            
        }
    }

    //Función para mostrar todas las propuestas de un usuario como capitan
    function SHOW_PROPUESTAS1($login_us){
        //Para ese login buscamos todas las pareajas de las que es capitán
        $sql_par = "SELECT * FROM PAREJA WHERE (CAPITAN = '$login_us')";
        if($result_par = $this->mysqli->query($sql_par)){
           //Para cada pareja buscamos sus enfrentamientos
            while($row_pareja = mysqli_fetch_array($result_par)){
                $id_pareja = $row_pareja['ID'];
                $sql_enf = "SELECT  CA.NOMBRE AS CAM_NOMBRE,
                                    CT.NIVEL,
                                    CT.GENERO,
                                    G.NOMBRE AS GR_NOMBRE,
                                    P.CAPITAN,
                                    E.ID AS ID_ENFRENTAMIENTO,
                                    E.PAREJA_1 AS ID_PAREJA

                                    FROM

                                    ENFRENTAMIENTO E,
                                    PAREJA P,
                                    GRUPO G,
                                    CATEGORIA CT,
                                    CAMPEONATO CA

                                    WHERE

                                    (E.GRUPO_ID = G.ID) and
                                    (G.CAMPEONATO_ID = CA.ID) and
                                    (G.CATEGORIA_ID = CT.ID) and
                                    (E.PAREJA_2 = P.ID) and
                                    (E.PAREJA_1 = '$id_pareja') and
                                    (E.ID IN (SELECT ENFRENTAMIENTO_ID FROM HUECO WHERE (PAREJA_ID = '$id_pareja'))) 
                            ";


                $result_enf = $this->mysqli->query($sql_enf);
                return $result_enf;   
            }
            
        }
    }

    //Función para mostrar todas las propuestas de un usuario como capitan
    function SHOW_PROPUESTAS2($login_us){
        //Para ese login buscamos todas las pareajas de las que es capitán
        $sql_par = "SELECT * FROM PAREJA WHERE (CAPITAN = '$login_us')";
        if($result_par = $this->mysqli->query($sql_par)){
           //Para cada pareja buscamos sus enfrentamientos
            while($row_pareja = mysqli_fetch_array($result_par)){
                $id_pareja = $row_pareja['ID'];
                $sql_enf = "SELECT  CA.NOMBRE AS CAM_NOMBRE,
                                    CT.NIVEL,
                                    CT.GENERO,
                                    G.NOMBRE AS GR_NOMBRE,
                                    P.CAPITAN,
                                    E.ID AS ID_ENFRENTAMIENTO,
                                    E.PAREJA_2 AS ID_PAREJA

                                    FROM

                                    ENFRENTAMIENTO E,
                                    PAREJA P,
                                    GRUPO G,
                                    CATEGORIA CT,
                                    CAMPEONATO CA

                                    WHERE

                                    (E.GRUPO_ID = G.ID) and
                                    (G.CAMPEONATO_ID = CA.ID) and
                                    (G.CATEGORIA_ID = CT.ID) and
                                    (E.PAREJA_1 = P.ID) and
                                    (E.PAREJA_2 = '$id_pareja') and
                                    (E.ID IN (SELECT ENFRENTAMIENTO_ID FROM HUECO WHERE (PAREJA_ID = '$id_pareja')))  
                            ";
                $result_enf = $this->mysqli->query($sql_enf);
                return $result_enf;   
            }
            
        }
    }

    //Funcion para eliminar los huecos cuando se llega a un acuerdo
    function DELETE_HUECOS($enfrentamiento_id){

            $sql_del = "SELECT * FROM HUECO WHERE (ENFRENTAMIENTO_ID = '$enfrentamiento_id')";
            $res_del = $this->mysqli->query($sql_del);
            while ($row_del = mysqli_fetch_array($res_del)) {
                $HUECO = new HUECO_Model('',$enfrentamiento_id,'','');
                $HUECO->DELETE($row_del['ID']);
            }
    }
    
}


?>