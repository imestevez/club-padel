<?php

class ESCUELA_SHOWALL{
	var $escuelas;

	function __construct($escuelas){	
		$this->escuelas = $escuelas;
		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 

?>

    <!-- Main -->
	<section id="main" class="container">
	<header>
	   <h2>Escuelas Deportivas</h2>
	    <p>Consulta las escuelas deportivas ofrecidas por el club</p>
	 </header>
				<div class="table-wrapper">
					<table>
						<thead >
							<tr>
								<th>Nombre</th>
								<th>Hora Inicio</th>
								<th>Hora Fin</th>
								<th>Pista</th>
								<th>Numero Inscritos</th>
								<th><a class="button small" href="../Controllers/ESCUELA_Controller.php?action=ADD">Añadir</a></th>
							</tr>
						</thead>
						<tbody>
					<?php 
						if($this->escuelas <> NULL){
							while($row = mysqli_fetch_array($this->escuelas)){
								$hora_inicio = explode(":", $row["HORA_INICIO"]);
								$hora_fin = explode(":", $row["HORA_FIN"]);
					?>
							<tr>
								<td>
									<?=$row['NOMBRE']?>
								</td>
								<td>
									<?=$hora_inicio[0].":".$hora_inicio[1]?>
								</td>
								<td>
									<?=$hora_fin[0].":".$hora_fin[1]?>
								</td>
								<td>
									<?=$row['NOMBRE_PISTA']?>
								</td>
								<td>
									<?=$row['INSCRIPCIONES']?>
								</td>
								<td>
									<a class="button small" href="../Controllers/ESCUELA_Controller.php?action=DELETE&escuela_ID=<?=$row['ID']?>">Borrar</a>
							<?php 
								if($row['INSCRIPCIONES'] == 0){
							?>
									<a class="button alt small">Ver Inscritos</a>
							<?php
								} //fin del if
								else{
							?>
									<a class="button alt small" href="../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php?action=SHOW_INSCRITOS&escuela_ID=<?=$row['ID']?>">Ver Inscritos</a>
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
    
    ?>