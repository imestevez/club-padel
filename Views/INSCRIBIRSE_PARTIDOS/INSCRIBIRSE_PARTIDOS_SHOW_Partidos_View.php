<?php

class INSCRIBIRSE_PARTIDOS{
	var $partidos;

	function __construct($partidos){	
		$this->partidos = $partidos;
		//$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 

?>

    <!-- Main -->
	<section id="main" class="container">
	<header>
	   <h2>Partidos Promocionados</h2>
	    <p>Inscribete en los partidos promocionados por el club</p>
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
								<th></th>

							</tr>
						</thead>
						<tbody>

					<?php 
						if( ($this->partidos <> NULL) &&  ( !is_string($this->partidos))) {
							foreach ($this->partidos as $key => $value) {
									$fecha = explode("-", $value[0]);
									$hora_inicio = explode(":", $value[1]);
									$hora_fin = explode(":", $value[2]);
							?>
			<form method="post" action="../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php?action=ADD">
							
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
											<?=$value[3]?>
										</td>
										<td>
											<?=$value[4]?>
										</td>
										<td>
											<input class="oculto" name="partido_ID" readonly value="<?=$key?>">
											<input type="submit" class="small" value="Inscribir">
										</td>
									</tr>
							</form>	

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
	   <h2>Partidos Promocionados</h2>
	    <p>Inscribete en los partidos promocionados por el club</p>
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
								<th></th>

							</tr>
						</thead>
						<tbody>
					<?php 
						if( ($this->partidos <> NULL) &&  ( !is_string($this->partidos))) {
							foreach ($this->partidos as $key => $value) {
									$fecha = explode("-", $value[0]);
									$hora_inicio = explode(":", $value[1]);
									$hora_fin = explode(":", $value[2]);
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
											<?=$value[3]?>
										</td>
										<td>
											<?=$value[4]?>
										</td>
										<td>
											<a class="button small" href="../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php?action=ADD&partido_ID=<?=$key?>">Inscribir</a>
										</td>
									</tr>
							</form>	

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