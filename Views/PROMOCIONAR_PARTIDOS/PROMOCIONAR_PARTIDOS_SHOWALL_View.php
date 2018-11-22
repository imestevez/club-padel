<?php

class PROMOCIONAR_PARTIDOS{
	var $horarios;

	function __construct($horarios,$origen){	
		$this->horarios = $horarios;
		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 

?>

    <!-- Main -->
	<section id="main" class="container">
	<header>
	   <h2>Partidos Promocionados</h2>
	    <p>Consulta los partidos ofrecidos por el club</p>
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
								<th><a class="button small" href="../Controllers/PROMOCIONAR_PARTIDOS_Controller.php?action=ADD">Promocionar</a></th>
							</tr>
						</thead>
						<tbody>
					<?php 
						if($this->horarios <> NULL){
							while($row = mysqli_fetch_array($this->horarios)){
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
									<a class="button small" href="../Controllers/PROMOCIONAR_PARTIDOS_Controller.php?action=DELETE&partido_ID=<?=$row['ID']?>">Borrar</a>
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
    
    ?>