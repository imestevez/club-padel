<?php

class RESERVA_Model{
	var $id;
    var $fecha;
    var $user_login;
    var $pista_ID;
    var $horario_ID;
    var $hoy;
    var $hoy_mas6;
    var $mensaje;
    var $mysqli;

    function __construct($id,$fecha,$user_login,$pista_ID,$horario_ID){
    	$this->id = $id;
    	if($fecha <> ''){
    		$fecha_aux = explode("/", $fecha);
            if(is_array($fecha_aux) && sizeof($fecha_aux) > 1){ //si viene con formato d/m/y
            var_dump("\n\n\n".$fecha);
            var_dump("\n\n\n".$fecha_aux);

        		$this->fecha = date_format(new DateTime(date('Y-m-d', mktime(0,0,0,$fecha_aux[1],$fecha_aux[0],$fecha_aux[2]))),'Y-m-d');
            }else{
                 $this->fecha = $fecha; //si viene con formato y-m-d
            }
    	}
    	$this->user_login = $user_login;
    	$this->pista_ID = $pista_ID;
    	$this->horario_ID = $horario_ID;

		$this->hoy = date_format(date_create(date('Y-m-d')), 'Y-m-d');
		$this->hoy_mas6 = date_format(date_create(date('Y-m-d',strtotime("+6 day"))), 'Y-m-d');

        include_once '../Functions/Access_DB.php';
        $this->mysqli = ConnectDB();
    }



    function ADD()
    {
	 if (  ($this->user_login <> '') || ($this->pista_ID <> '') 
        || ($this->horario_ID <> '') || ($this->fecha <> '')){ // si los atributos vienen vacios
	            // construimos el sql para buscar esa clave en la tabla
	            $sql = "SELECT * FROM RESERVA";
	            if (!$result = $this->mysqli->query($sql)){ //si da error la ejecución de la query
	                return 'ERROR: No se ha podido conectar con la base de datos'; //error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
	            }else { //si la ejecución de la query no da error
	                   
                        $sql = "INSERT INTO RESERVA(
	                    ID,
	                    USUARIO_LOGIN,
	                    PISTA_ID,
	                    FECHA,
                        HORARIO_ID) VALUES(
	                    					NULL,
	                                        '$this->user_login',
	                                        '$this->pista_ID',
	                                        '$this->fecha',
                                            '$this->horario_ID'
	                                    )";
	                    
	                    if (!($result = $this->mysqli->query($sql))){ //ERROR en la consulta ADD
		                    $this->mensaje['mensaje'] = 'ERROR: Introduzca todos los valores de todos los campos';
	                        return $this->mensaje; // introduzca un valor para el usuario
	                    }
	                    else{
                            $result = $this->mysqli->query("SELECT @@identity AS ID"); //recoge el id de la ultima inserccion
                            if ($row = mysqli_fetch_array($result)) {
                                $this->mensaje['reserva_ID'] = $row[0];
                            }   
                    	    $this->mensaje['mensaje'] = 'Registrado correctamente';
                            return $this->mensaje; // introduzca un valor para el usuario
	                    }
	            }
        }else{ //Si no se introduce un login
                $this->mensaje['mensaje'] = 'ERROR: Introduzca todos los valores de todos los campos'; // Itroduzca un valor para el usuario
                return $this->mensaje;
        }
	                    
    } // fin del metodo ADD

    function SEARCH(){
		$sql = "SELECT * FROM RESERVA 
				WHERE  FECHA BETWEEN '$this->hoy' AND  '$this->hoy_mas6'
				ORDER BY FECHA";

        if (!($resultado = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
            return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        } 
    }
     function SHOWALL(){
		$sql = "SELECT * FROM RESERVA ORDER BY FECHA";

        if (!($resultado = $this->mysqli->query($sql))){
            $this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos'; 
            return $this->mensaje; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            return $resultado;
        } 
    }

	function SEARCH_PISTAS_LIBRES(){
        //comprobamos si hay partidos o reservas
		$sql1 = "SELECT *
				FROM  PARTIDO PA
				WHERE  ( ( PA.FECHA = '$this->fecha') AND ( PA.HORARIO_ID = '$this->horario_ID'))";
        $sql2 = "SELECT *
                FROM  RESERVA R
                WHERE  ( ( R.FECHA = '$this->fecha') AND ( R.HORARIO_ID = '$this->horario_ID'))";
           
        if ( !($resultado1 = $this->mysqli->query($sql1)) || !($resultado2 = $this->mysqli->query($sql2))){
          return 'ERROR: Fallo en la consulta sobre la base de datos'; 
        }
        else{ // si la busqueda es correcta devolvemos el recordset resultado
            $pistasLibres = NULL;
        	$num_rows1 = mysqli_num_rows($resultado1);
            $num_rows2 = mysqli_num_rows($resultado2);

        	if(($num_rows1 == 0) && (($num_rows2 == 0) )){ //Si no hay reservas ni partidos ese dia a esa hora
				$sql = "SELECT * FROM PISTA ORDER BY ID";
		        if (!($resultado = $this->mysqli->query($sql)) ){
		          return 'ERROR: Fallo en la consulta sobre la base de datos'; 
		        }else{
                    while($row = mysqli_fetch_array($resultado)){                                
                        $pistasLibres[$row["ID"]] = array($row["NOMBRE"],$row["TIPO"]);
                    }
		        	return $pistasLibres;
		        }
        	}else{
        
                    $sql1 = "SELECT PA.PISTA_ID
                                FROM PARTIDO PA
                                WHERE  PA.FECHA = '$this->fecha' AND PA.HORARIO_ID = '$this->horario_ID'
                                ORDER BY PA.ID";
                    $sql2 = "SELECT R.PISTA_ID
                                FROM RESERVA R
                                WHERE  R.FECHA = '$this->fecha' AND R.HORARIO_ID = '$this->horario_ID'
                                ORDER BY R.ID";
                    $sql3   = "SELECT * FROM PISTA ORDER BY ID";

                    if (    !($resultado1 = $this->mysqli->query($sql1)) 
                        || !($resultado2 = $this->mysqli->query($sql2))
                        || !($resultado3 = $this->mysqli->query($sql3))  ){
                        return 'ERROR: Fallo en la consulta sobre la base de datos'; 
                    }else{

                        if($resultado1 <> NULL){
                            while($row = mysqli_fetch_array($resultado1)){
                                $list[$row["PISTA_ID"]] = "Ocupada";
                            }
                        }
                        if($resultado2 <> NULL){
                             while($row = mysqli_fetch_array($resultado2)){
                                $list[$row["PISTA_ID"]] = "Ocupada";
                            }
                        }
                        if($resultado3 <> NULL){
                            while($row = mysqli_fetch_array($resultado3)){                                
                                if(!array_key_exists($row["ID"], $list)){
                                    $pistasLibres[$row["ID"]] = array($row["NOMBRE"],$row["TIPO"]);
                                }
                            }
                        }
                        return $pistasLibres;
                    }//fin del else
                return NULL;
            }//fin else
        } //fin else
    }// fin del metodo SEARCH_PISTAS_LIBRES
} //fin clase

?>