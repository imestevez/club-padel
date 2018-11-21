<?php

class SHOW_INSCRIPCIONES{
	var $tuplas;

	function __construct($tuplas){	
		$this->tuplas = $tuplas;
		//$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 

?>

    <!-- Main -->
	<section id="main" class="container">
	<header>
	   <h2>Tus Inscripciones</h2>
	    <p>Consulta los partidos en los que estas inscrito</p>
	 </header>
				<div class="table-wrapper">
					<table>
						<thead >
							<tr>
								<th>Fecha</th>
								<th>Hora Inicio</th>
								<th>Hora Fin</th>
								<th>Pista</th>
								<th>Numero Inscritos</th>
								<th><a class="button small" href="../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php?action=SHOW_PARTIDOS">Inscribirse</a></th>
							</tr>
						</thead>
						<tbody>
					<?php 
						if($this->tuplas <> NULL){
							while($row = mysqli_fetch_array($this->tuplas)){
								$hoy = date('Y-m-d');
								$baja = true;
								if($hoy > $row['FECHA']){
									$baja = false;
								}
								$fecha = explode("-", $row['FECHA']);
								$hora_inicio = explode(":", $row["HORA_INICIO"]);
								$hora_fin = explode(":", $row["HORA_FIN"]);
						?>
							<tr>
								<td>
									<?=$fecha[2]."/".$fecha[1]."/".$fecha[0]?>
								</td>
								<td>
									<?=$hora_inicio[0].":".$hora_inicio[1]?>
								</td>
								<td>
									<?=$hora_fin[0].":".$hora_fin[1]?>
								</td>
								<td>
									<?=$row['NOMBRE']?>
								</td>
								<td>
									<?=$row['INSCRIPCIONES']?>
								</td>
								<td>
						<?php
							if( ($baja == true) && ($row['INSCRIPCIONES'] < 4) ){
						?>
									<a class="button small" href="../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php?action=DELETE&partido_ID=<?=$row['ID']?>">Dar de baja</a>
						<?php
							}
							if($row['INSCRIPCIONES'] >= 4){
						?>
									<a class="button alt small">Reserva</a>

						<?php
							
							}
						?>
									<a class="button small" href="../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php?action=SHOW_INSCRITOS&partido_ID=<?=$row['ID']?>">Ver Inscritos</a>

								</td>

							</tr>
					<?php
							}//fin del while
						}//fin del if
					?>
						</tbody>
					</table>
				</div>
   		</section>
    <?php
        include '../Views/FOOTER_View.php';
        } //fin metodo render
   

   function renderAdmin(){

    include '../Views/HEADER_View.php'; 

?>

    <!-- Main -->
	<section id="main" class="container">
	<header>
	   <h2>Inscripciones</h2>
	    <p>Consulta las inscripciones de los deportistas</p>
	 </header>
				<div class="table-wrapper">
					<table>
						<thead >
							<tr>
								<th>Login</th>
								<th>Fecha</th>
								<th>Hora Inicio</th>
								<th>Hora Fin</th>
								<th>Pista</th>
								<th>Numero Inscritos</th>
								<th><a class="button small" href="../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php?action=SHOW_PARTIDOS">INSCRIBIR</a></th>
							</tr>
						</thead>
						<tbody>
					<?php 
						if($this->tuplas <> NULL){
							while($row = mysqli_fetch_array($this->tuplas)){
								$hoy = date('Y-m-d');
								$baja = true;
								if($hoy > $row['FECHA']){
									$baja = false;
								}
								$fecha = explode("-", $row['FECHA']);
								$hora_inicio = explode(":", $row["HORA_INICIO"]);
								$hora_fin = explode(":", $row["HORA_FIN"]);
						?>
							<tr>
								<td>
									<?=$row["USUARIO_LOGIN"]?>
								</td>
								<td>
									<?=$fecha[2]."/".$fecha[1]."/".$fecha[0]?>
								</td>
								<td>
									<?=$hora_inicio[0].":".$hora_inicio[1]?>
								</td>
								<td>
									<?=$hora_fin[0].":".$hora_fin[1]?>
								</td>
								<td>
									<?=$row['NOMBRE']?>
								</td>
								<td>
									<?=$row['INSCRIPCIONES']?>
								</td>
								<td>
						<?php
							if($baja == true){
						?>
									<a class="button small" href="../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php?action=DELETE&partido_ID=<?=$row['ID']?>&usuario_login=<?=$row['USUARIO_LOGIN']?>">DAR DE BAJA</a>
						<?php
							}
						?>
									<a class="button small" href="../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php?action=SHOW_INSCRITOS&partido_ID=<?=$row['ID']?>">VER INSCRITOS</a>
						
								</td>

							</tr>
					<?php
							}//fin del while
						}//fin del if
					?>
						</tbody>
					</table>
				</div>
   		</section>
    <?php
        include '../Views/FOOTER_View.php';
        } //fin metodo renderAdmin
     
    } //fin class
    
    ?>