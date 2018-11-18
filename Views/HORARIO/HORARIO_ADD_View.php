<?php

class HORARIO_ADD{
	var $horarios;
	function __construct($horarios){	
		$this->horarios = $horarios;

		$this->render();
	}

function render(){

    include '../Views/HEADER_View.php'; 

?>

    <!-- Main -->
	<section id="main" class="container medium">
	<header>
	   <h2>Añadir Horarios</h2>
	    <p>Elige uno de los horarios disponibles</p>
	 </header>
				<div class="table-wrapper">
					<table>
						<thead >
							<tr>
								<th>Hora Inicio</th>
								<th>Hora Fin</th>
							</tr>
						</thead>
						<tbody>
					<?php 
					if ( ($this->horarios <> NULL) ){
						foreach ($this->horarios as $key => $value) {
						?>
							<form method="post" action="../Controllers/HORARIO_Controller.php?action=ADD">
				<?php
								$hora_inicio = explode(":", $key);
								$hora_fin = explode(":", $value);
				?>
								<tr>
									<td>
										<?=$hora_inicio[0].":".$hora_inicio[1]?>
									</td>
									<td>
										<?=$hora_fin[0].":".$hora_fin[1]?>
									</td>
									<td>
										<input class="oculto" name="hora_inicio" readonly value="<?=$key?>">
										<input class="oculto" name="hora_fin" readonly value="<?=$value?>">
										<input type="submit" class="small" value="Añadir">
									</td>
								</tr>
							</form>	
						<?php
						}	// fin foreach
					} //fin if
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