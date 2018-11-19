<?php

class RESERVAR_PISTA_Horario{
	var $horariosList;
	var $reservasList;
	var $partidosList;
	var $pistasList;
	var $reservasPistaList;
	var $partidosPistaList;
	var $horarios;
	var $reservas;
	var $pistas;
	var $dias;
	var $semana;

	function __construct($horarios, $reservas,$partidos,$pistas){
		$this->horarios = $horarios;
		$this->reservas = $reservas;
		$this->pistas = $pistas;
		$this->partidos = $partidos;
		$this->dias = 7; //dias a mostrar
		$this->semana = array (
			array (
					date("l"),
					date("d/m/Y")
				),
			array (
					date("l",strtotime("+1 day")),
					date("d/m/Y",strtotime("+1 day"))
				),
			array (
					date("l",strtotime("+2 day")),
					date("d/m/Y",strtotime("+2 day"))
				),
			array (
					date("l",strtotime("+3 day")),
					date("d/m/Y",strtotime("+3 day"))
				),
			array (
					date("l",strtotime("+4 day")),
					date("d/m/Y",strtotime("+4 day"))
				),
			array (
					date("l",strtotime("+5 day")),
					date("d/m/Y",strtotime("+5 day"))
				),
			array (
					date("l",strtotime("+6 day")),
					date("d/m/Y",strtotime("+6 day"))
				)
		);
		$this->reservasPistaList;
		$this->partidosPistaList;
		$this->horariosList;
		$this->reservasList;
		$this->partidosList;
		$this->pistasList;
		$this->rellenarListas();
		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php';

?>

    <!-- Main -->
	<section id="main" class="container">
	<header>
	   <h2>Reservar Pista</h2>
	    <p>Selecciona el horario de tu reserva</p>
	 </header>
        <h3></h3>
				<div class="table-wrapper">
					<table>
						<thead >
							<tr>
							<?php
							if($this->horariosList <> NULL && $this->pistasList <> NULL){
								$i = 0;
								for($i = 0; $i < $this->dias; $i++){
							?>
									<th><?=$strings[$this->semana[$i][0]]." ".$this->semana[$i][1]?></th>
							<?php
								}//fin for
							?>
							</tr>
						</thead>
						<tbody>
					<?php
							foreach ($this->horariosList as $key => $value) { //se colocan todos los horarios
						?>
								<tr>
							<?php
								$i = 0;
								for($i = 0; $i < $this->dias; $i++){
									if($this->hay_Reserva($key, $i) == true){ //si esta reservadoe
								?>
										<td><a class="button alt small"><?=$value?></a></td>
									<?php
										}
										elseif($this->hay_Partido($key, $i) == true){ //si hay partido
									?>
										<td><a class="button alt small"><?=$value?></a></td>
									<?php
										}//fin elseif
										else { //si esta disponible
									?>
										<td><a href="../Controllers/RESERVAR_PISTA_Controller.php?action=SHOW_PISTAS&fecha=<?=$this->semana[$i][1]?>&horario_ID=<?=$key?>" class="button small"><?=$value?></a></td>
								<?php
										} //fin else
									}//fin for
							?>
								</tr>
						<?php
							}//fin foreach
						}//fin del if
						else{
							if($this->horariosList == NULL){
						?>
	    					<p>No hay horarios disponibles</p>
						<?php
							}else{
						?>
	    					<p>No hay pistas disponibles</p>
						<?php
							}
						}//fin del else
					?>
						</tbody>
					</table>
				</div>
   		</section>
    <?php
        include '../Views/FOOTER_View.php';
        } //fin metodo render

 /*
	Funcion que alacena en listas las tuplas resultantes del modelo de datos
 */
    function rellenarListas(){
		if($this->horarios <> NULL){ //si existen horarios
			while($row = mysqli_fetch_array($this->horarios)){
				$hora = explode(':', $row["HORA_INICIO"]); //se divide la hora para coher solo hh:mm
				$this->horariosList[$row["ID"]] = $hora[0].":".$hora[1];
			}
		}
		if($this->reservas <> NULL){//si existen reservas
			$i = 0;
			while($row = mysqli_fetch_array($this->reservas)){
				$this->reservasList[$row["ID"]] = array( $row["FECHA"],$row["HORARIO_ID"], $row["PISTA_ID"]);
				$this->reservasPistaList[$row["FECHA"]][$row["HORARIO_ID"]][$i] = $row["PISTA_ID"];//lista para contar el numero de pistas usadas en funcion de la fecha y horario
				$i++;
			}
		}
		if($this->partidos <> NULL){//si existen partidos
			$i = 0;
			while($row = mysqli_fetch_array($this->partidos)){//se recorren los partidos
				$this->partidosList[$row["ID"]] = array( $row["FECHA"],$row["HORARIO_ID"], $row["PISTA_ID"]);
				$this->partidosPistaList[$row["FECHA"]][$row["HORARIO_ID"]][$i] = $row["PISTA_ID"]; //lista para contar el numero de pistas usadas en funcion de la fecha y horario
				$i++;
			}
		}
		if($this->pistas <> NULL){//si existen pistas
			while($row = mysqli_fetch_array($this->pistas)){ //se recorren las pistas y almacenan en un array
				$this->pistasList[$row["ID"]] = $row["TIPO"];
			}
		}

    } // fin del metodo rellenarListas

/*
Comprueba si una franja horaria si ya existe una reserva
Retorna true si esta disponible y false si no lo esta
*/
    function hay_Reserva($horario_ID, $day){
    	$fecha = new DateTime(date('Y-m-d' , strtotime("+".$day." day"))); //Se crea un objeto DateTime con la fecha que se pase como parametro
    	if($this->reservasList <> NULL){
			foreach ($this->reservasList as $key => $reserva) { //se recorren las reservas
		    	$fecha_aux = new DateTime( $reserva[0] ); //se coge la fecha de cada reserva
		    	$diff = date_diff($fecha,$fecha_aux); //se compara la fech introducida como parametro y la recuperada de la lista

				if (($horario_ID == $reserva[1]) && ( $diff->format("%d") == 0) ) { //si coincide el horario y la diferencia entre fechas es 0
					if(count($this->reservasPistaList[$reserva[0]][$reserva[1]])
						== count($this->pistasList) ){ //si el numero de reservas de una fecha y un horario es igual al numero de pistas del club
						return true;
					}
				}
		    }//fin del foreach
	  	  return false;
	    }else{
	    	return false;
	    }
	}//fin del metodo hayReservas
/*
Comprueba si una franja horaria si ya existe un partido
Retorna true si esta disponible y false si no lo esta
*/
	function hay_Partido($horario_ID, $day){
    	$fecha = new DateTime(date('Y-m-d' , strtotime("+".$day." day"))); //Se crea un objeto DateTime con la fecha que se pase como parametro
    	if($this->partidosList <> NULL){
			foreach ($this->partidosList as $key => $partido) { //se recorren las partidos
		    	$fecha_aux = new DateTime( $partido[0] ); //se coge la fecha de cada partido
		    	$diff = date_diff($fecha,$fecha_aux); //se compara la fech introducida como parametro y la recuperada de la lista
				if (($horario_ID == $partido[1]) && ( $diff->format("%d") == 0) ) { //si coincide el horario y la diferencia entre fechas es 0
					if(count($this->partidosPistaList[$partido[0]][$partido[1]])
						== count($this->pistasList) ){ //si el numero de partidos de una fecha y un horario es igual al numero de pistas del club
						return true;
					}
				}
		    }//fin del foreach
	  	  return false;
	    }else{
	    	return false;
	    }
	}//fin del metodo hay_Partido


} //fin class

?>
