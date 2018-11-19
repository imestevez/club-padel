<?php

class HORARIO{
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
	   <h2>Horarios Disponibles</h2>
	    <p>Consulta los horarios disponibles de uso de las instalaciones</p>
	 </header>
				<div class="table-wrapper">
					<table>
						<thead >
							<tr>
								<th>Hora Inicio</th>
								<th>Hora Fin</th>
								<th><a class="button small" href="../Controllers/HORARIO_Controller.php?action=ADD">Añadir</a></th>
							</tr>
						</thead>
						<tbody>
					<?php
						if($this->horarios <> NULL){
							while($row = mysqli_fetch_array($this->horarios)){
								$hora_inicio = explode(":", $row["HORA_INICIO"]);
								$hora_fin = explode(":", $row["HORA_FIN"]);
					?>
							<tr>
								<td>
									<?=$hora_inicio[0].":".$hora_inicio[1]?>
								</td>
								<td>
									<?=$hora_fin[0].":".$hora_fin[1]?>
								</td>
								<td>
									<a class="button small" href="../Controllers/HORARIO_Controller.php?action=DELETE&horario_ID=<?=$row['ID']?>">Borrar</a></th>
							</tr>
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
