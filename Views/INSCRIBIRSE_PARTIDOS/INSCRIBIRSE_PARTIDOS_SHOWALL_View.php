<?php

class SHOW_INSCRIPCIONES{
	var $tuplas;

	function __construct($tuplas,$origen){	
		$this->tuplas = $tuplas;
		$this->render();
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
								<th><a class="button small" href="../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php?action=SHOW_PARTIDOS">INSCRIBIRSE</a></th>
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
									<?=$row['PISTA_ID']?>
								</td>
								<td>
									<?=$row['INSCRIPCIONES']?>
								</td>
								<td>
						<?php
							if($baja == true){
						?>
									<a class="button small" href="../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php?action=DELETE&id=<?=$row['ID']?>">DAR DE BAJA</a>
						<?php
							}
						?>
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
    
    } //fin class
    
    ?>s