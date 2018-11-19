<?php

class HUECO_Model{


	var $mysqli;

    var $fecha;
    var $enfrentamiento_id;
    var $pareja_id;
    var $horario_id;

	function __construct($fecha,$enfrentamiento_id,$pareja_id,$horario_id){
        $this->fecha = $fecha;
        $this->enfrentamiento_id = $enfrentamiento_id;
        $this->pareja_id = $pareja_id;
        $this->horario_id = $horario_id;

        include_once '../Models/RESERVA_Model.php';
        include_once '../Models/ENFRENTAMIENTO_Model.php';


		include_once '../Functions/Access_DB.php';
        $this->mysqli = ConnectDB();
	}



	function ADD()
    {
        if($this->fecha <> NULL){   //si viene la fecha entera le cambiamos el formato para que se adecue al de la bd
            $aux = explode("/", $this->fecha);
            $this->fecha = date('Y-m-d',mktime(0,0,0,$aux[1],$aux[0],$aux[2]));
        }

        //Comprobamos que el registro no existe ya en la base de datos
        $sql_cmp = "SELECT * FROM HUECO WHERE 
                        (FECHA = '$this->fecha') and
                        (ENFRENTAMIENTO_ID = '$this->enfrentamiento_id') and
                        (PAREJA_ID = '$this->pareja_id') and
                        (HORARIO_ID = '$this->horario_id')";

        $res_cmp = $this->mysqli->query($sql_cmp);
        if(mysqli_num_rows($res_cmp) > 0){
            return "ERROR: El hueco ya existe para ese enfrentamiento";
        }
        else{
            //Insertamos el nuevo hueco
            $sql_ins = "INSERT INTO HUECO(ID,FECHA, ENFRENTAMIENTO_ID, PAREJA_ID, HORARIO_ID) 
                        VALUES(null,'$this->fecha','$this->enfrentamiento_id','$this->pareja_id','$this->horario_id')";
            if($res_ins = $this->mysqli->query($sql_ins)){
                return "Hueco insertado correctamente";  
            }
            else{
                return "ERROR: Al insertar el hueco en la bd";
            }          
        }                


    }

    function DELETE($id){
        $sql_del = "DELETE FROM HUECO WHERE (ID = '$id')";
        $res_del = $this->mysqli->query($sql_del);
    }

    function DELETE_HUECO(){
        $sql_del = "DELETE FROM HUECO WHERE 
                        (FECHA = '$this->fecha') and
                        (ENFRENTAMIENTO_ID = '$this->enfrentamiento_id') and
                        (PAREJA_ID = '$this->pareja_id') and
                        (HORARIO_ID = '$this->horario_id')";
                        var_dump($sql_del);
        if( $res_del = $this->mysqli->query($sql_del)){
            return "Hueco borrado correctamente";
        }
        else{
            return "ERROR: Al insertar un hueco";
        }
    }

    function GETOFERTA(){
        $sql_cnt = "SELECT  H.FECHA,
                            O.HORA_INICIO,
                            O.HORA_FIN,
                            O.ID AS HORARIO_ID,
                            H.PAREJA_ID,
                            H.ENFRENTAMIENTO_ID

                            FROM HUECO H, HORARIO O WHERE 
                            (H.HORARIO_ID = O.ID) and
                            (H.ENFRENTAMIENTO_ID = '$this->enfrentamiento_id') and 
                            (H.PAREJA_ID <> '$this->pareja_id')";
 
                        
        $result_cnt = $this->mysqli->query($sql_cnt);
        return $result_cnt;
    }

    function GETOFERTA1($id_enfrentamiento){

        //Contamos el número de pistas que hay
        $sql_cnt = "SELECT * FROM PISTA";
        $result_cnt = $this->mysqli->query($sql_cnt);
        $num_pistas = mysqli_num_rows($result_cnt);

    	//Buscamos todos los huecos propuestos a esa pareja para ese enfrentamiento, de los cuales exista una reserva para su horario pero no en la misma fecha
    	$sql_hue = "SELECT * FROM 
    						HUECO U,
    						HORARIO O,
    						WHERE
                            (U.ENFRENTAMIENTO_ID = '$id_enfrentamiento') and 
    						(U.HORARIO_ID = O.ID) and
                            ('$num_pistas' > (SELECT * FROM RESERVA WHERE (FECHA = '$this->fecha') and (HORARIO_ID = '$this->horario_id')))
    						";
    	if($result = $this->mysqli->query($sql_hue)){
    		return $result;
    	}


    }

    function GETOFERTA2($id_enfrentamiento){
    	//Buscamos todos los huecos propuestos a esa pareja para ese enfrentamiento, de los cuales no exista una reserva para su horario 
    	$sql_hue = "SELECT * FROM 
    						HUECO U,
    						HORARIO O
    						WHERE
                            (U.ENFRENTAMIENTO_ID = '$id_enfrentamiento') and 
    						(U.HORARIO_ID = O.ID) and
    						(
    							O.ID NOT IN (SELECT HORARIO_ID FROM RESERVA )
    						)
    						";
    	if($result = $this->mysqli->query($sql_hue)){
    		return $result;
    	}					
    }

    //Función para comprobar la dispinibilidad y realizar la reserva de un hueco 
    function ACEPTAR(){
        //New
        $reservas = null;
        $pistas_disponibles;

        //Hacemos un array con las reservas para ese horario
        $sql_res = "SELECT * FROM RESERVA 
                        WHERE (HORARIO_ID = '$this->horario_id') and (FECHA = '$this->fecha')";

        $res_res = $this->mysqli->query($sql_res);
        if(mysqli_num_rows($res_res) > 0){
              while($row_res = mysqli_fetch_array($res_res)){
                $reservas[$row_res['PISTA_ID']] = array($row_res['ID']);
              }    
        }
        else{
            $reservas['LIBRE'] = null;
        }
         

        //Recorremos todas las pistas del club
        $sql_pts = "SELECT * FROM PISTA";
        $res_pts = $this->mysqli->query($sql_pts);
        $cont = 0;
        $pistas_disponibles = null;
        //Si la pista no está reservada la guardamos como disponible
        while($row_res = mysqli_fetch_array($res_pts)){
            if(!array_key_exists($row_res['ID'], $reservas)){
                $pistas_disponibles[$cont] = $row_res['ID'];
                $cont++;
            }
        }

        //Si hay pistas disponibles en ese horario realizamos la reserva, si no mandamos un mensaje de error
        if($pistas_disponibles[0] <> null){
            $id_pista = $pistas_disponibles[0];
            //Reservamos a nombre del capitan
            $sql_cap = "SELECT * FROM PAREJA WHERE (ID = '$this->pareja_id')";
            $res_cap = $this->mysqli->query($sql_cap);
            $row_cap = mysqli_fetch_array($res_cap);
            $log_capitan = $row_cap['CAPITAN'];
            $RESERVA = new RESERVA_Model(null, $this->fecha, $log_capitan, $id_pista, $this->horario_id);
            $RESERVA->ADD();

            //Buscamos el id de la reserva que acabamos de crear
            $sql_idres = "SELECT * FROM RESERVA WHERE 
                            (HORARIO_ID = '$this->horario_id') and
                            (PISTA_ID = '$id_pista') and
                            (FECHA = '$this->fecha') ";            

            $res_idres = $this->mysqli->query($sql_idres);
            $row_idres = mysqli_fetch_array($res_idres);
            $reserva_id = $row_idres['ID'];

            //Añadimos el id al enfrentamiento
            $ENFRENTAMIENTO = new ENFRENTAMIENTO_Model('','','','',$reserva_id);
            $ENFRENTAMIENTO->SET_RESERVA($this->enfrentamiento_id);

            //Eliminamos los huecos relacionados con el enfrentamiento
            $ENFRENTAMIENTO->DELETE_HUECOS($this->enfrentamiento_id);

            return "Reserva realizada con éxito";
        }
        else{
            return "No hay pistas disponibles para ese horario";
        }               
    }

    function SHOW_HUECOSACT(){

        $sql = "SELECT  *
                        FROM HUECO U, HORARIO O WHERE 
                        (U.ENFRENTAMIENTO_ID = '$this->enfrentamiento_id') and 
                        (U.PAREJA_ID = '$this->pareja_id') and 
                        (U.HORARIO_ID = O.ID)";

        $result = $this->mysqli->query($sql);
        return $result;
    }



}

?>