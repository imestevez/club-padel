<?php

class INSCRIBIRSE_ESCUELA{
	var $escuelas;

	function __construct($escuelas){	
		$this->escuelas = $escuelas;
		//$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 

?>

    <!-- Main -->
	<section id="main" class="container">
	<header>
	   <h2>Inscripción en escuelas</h2>
	    <p>Inscribete en una escuela deportiva del club</p>
	    
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
							</tr>
						</thead>
						<tbody>
					<?php 
						if($this->escuelas <> NULL){
							while($row = mysqli_fetch_array($this->escuelas)){
								$hora_inicio = explode(":", $row["HORA_INICIO"]);
								$hora_fin = explode(":", $row["HORA_FIN"]);

					?>
					<form method="post" action="../Controllers/INSCRIBIRSE_ESCUELA_Controller.php?action=ADD">
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
										<input class="oculto" name="escuela_ID" readonly value="<?=$row['ID']?>">
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
	   <h2>Inscripción en escuelas</h2>
	    <p>Elige una escuela deportiva para inscribir a un deportista</p>
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
									<a class="button small" href="../Controllers/INSCRIBIRSE_ESCUELA_Controller.php?action=ADD&escuela_ID=<?=$row['ID']?>">Inscribir</a>
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