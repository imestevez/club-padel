<?php

class GestionHorarios{

	var $tusOfertas1;
	var $tusOfertas2;
	var $sinHorarios1;
	var $sinHorarios2;
	var $tusPropuestas1;
	var $tusPropuestas2;


	function __construct($tusOfertas1, $tusOfertas2, $sinHorarios1, $sinHorarios2, $tusPropuestas1, $tusPropuestas2){

		$this->tusOfertas1 =  $tusOfertas1;
		$this->tusOfertas2 =  $tusOfertas2;
		$this->sinHorarios1 =  $sinHorarios1;
		$this->sinHorarios2 =  $sinHorarios2;

		$this->tusPropuestas1 =  $tusPropuestas1;
		$this->tusPropuestas2 =  $tusPropuestas2;



		$this->render();
	}

function render(){

    include '../Views/HEADER_View.php'; 
?>
    <!-- Main -->
    
	<section id="main" class="container">
		<header>
		   <h2>Horarios de enfrentamientos</h2>
		    <p>Gestiona los horarios de tus próximos enfrentamientos como <u><b>capitán</b></u></p>
		 </header>

		<div class="row">
			<div class="col-12">
			    	<section class="box">
			    		<h3>Tus ofertas</h3>
			    		<div class="table-wrapper">
							<table>
								<thead >
									<tr>
										<th>Campeonato</th>
										<th>Categoría</th>
										<th>Grupo</th>
										<th>Contrincante</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									
						<?php 
							while ($row_tusOfertas1 = mysqli_fetch_array($this->tusOfertas1)) {
							
						?>			
									<tr>	
										<td><?php echo $row_tusOfertas1['CAM_NOMBRE']?></td>
										<td><?php echo $row_tusOfertas1['NIVEL']." ".$row_tusOfertas1['GENERO'] ?></td>
										<td><?php echo $row_tusOfertas1['GR_NOMBRE']?></td>
										<td><?php echo $row_tusOfertas1['CAPITAN']?></td>
										<td><a href="../Controllers/HUECO_Controller.php?action=GETOFERTAS&enfrentamiento_id=<?php echo $row_tusOfertas1['ID_ENFRENTAMIENTO']?>&pareja_id=<?php echo $row_tusOfertas1['PAREJA_ID'] ?>" class="button small" >Mostrar huecos</a></td>
									</tr>
						<?php } ?>

						<?php 
							while ($row_tusOfertas2 = mysqli_fetch_array($this->tusOfertas2)) {
							
						?>			
									<tr>	
										<td><?php echo $row_tusOfertas2['CAM_NOMBRE']?></td>
										<td><?php echo $row_tusOfertas2['NIVEL']." ".$row_tusOfertas2['GENERO'] ?></td>
										<td><?php echo $row_tusOfertas2['GR_NOMBRE']?></td>
										<td><?php echo $row_tusOfertas2['CAPITAN']?></td>
										<td><a href="../Controllers/HUECO_Controller.php?action=GETOFERTAS&enfrentamiento_id=<?php echo $row_tusOfertas2['ID_ENFRENTAMIENTO']?>&pareja_id=<?php echo $row_tusOfertas2['PAREJA_ID'] ?>" class="button small" >Mostrar huecos</a></td>
									</tr>
						<?php } ?>
									
								</tbody>
							</table>
						</div>
			    	</section>	

			    	<section class="box">
			    		<h3>Enfrentamientos sin propuestas</h3>
			    		<div class="table-wrapper">
				    		<table>
									<thead >
										<tr>
											<th>Campeonato</th>
											<th>Categoría</th>
											<th>Grupo</th>
											<th>Contrincante</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
									
						<?php 
							while ($row_sinHorarios = mysqli_fetch_array($this->sinHorarios1)) {
							
						?>			
									<tr>	
										<td><?php echo $row_sinHorarios['CAM_NOMBRE']?></td>
										<td><?php echo $row_sinHorarios['NIVEL']." ".$row_sinHorarios['GENERO'] ?></td>
										<td><?php echo $row_sinHorarios['GR_NOMBRE']?></td>
										<td><?php echo $row_sinHorarios['CAPITAN']?></td>
										<td><a href="../Controllers/HUECO_Controller.php?action=PROPUESTA&enfrentamiento_id=<?php echo $row_sinHorarios['ID_ENFRENTAMIENTO']?>&pareja_id=<?php echo $row_sinHorarios['ID_PAREJA']?>" class="button small" >Proponer horario</a></td>
									</tr>
						<?php } ?>

						<?php 
							while ($row_sinHorarios = mysqli_fetch_array($this->sinHorarios2)) {
							
						?>			
									<tr>	
										<td><?php echo $row_sinHorarios['CAM_NOMBRE']?></td>
										<td><?php echo $row_sinHorarios['NIVEL']." ".$row_sinHorarios['GENERO'] ?></td>
										<td><?php echo $row_sinHorarios['GR_NOMBRE']?></td>
										<td><?php echo $row_sinHorarios['CAPITAN']?></td>
										<td><a href="../Controllers/HUECO_Controller.php?action=PROPUESTA&enfrentamiento_id=<?php echo $row_sinHorarios['ID_ENFRENTAMIENTO']?>&pareja_id=<?php echo $row_sinHorarios['ID_PAREJA']?>" class="button small" >Proponer horario</a></td>
									</tr>
						<?php } ?>

						</tbody>
							</table>
						</div>
			    	</section>

			    	<section class="box">
			    		<h3>Tus propuestas</h3>
			    		<div class="table-wrapper">
				    		<table>
									<thead >
										<tr>
											<th>Campeonato</th>
											<th>Categoría</th>
											<th>Grupo</th>
											<th>Contrincante</th>
										</tr>
									</thead>
									<tbody>
									
						<?php 
							while ($row_propuestas = mysqli_fetch_array($this->tusPropuestas1)) {
							
						?>			
									<tr>	
										<td><?php echo $row_propuestas['CAM_NOMBRE']?></td>
										<td><?php echo $row_propuestas['NIVEL']." ".$row_propuestas['GENERO'] ?></td>
										<td><?php echo $row_propuestas['GR_NOMBRE']?></td>
										<td><?php echo $row_propuestas['CAPITAN']?></td>
									</tr>
						<?php } ?>

						<?php 
							while ($row_propuestas = mysqli_fetch_array($this->tusPropuestas2)) {
							
						?>			
									<tr>	
										<td><?php echo $row_propuestas['CAM_NOMBRE']?></td>
										<td><?php echo $row_propuestas['NIVEL']." ".$row_propuestas['GENERO'] ?></td>
										<td><?php echo $row_propuestas['GR_NOMBRE']?></td>
										<td><?php echo $row_propuestas['CAPITAN']?></td>
									</tr>
						<?php } ?>

						</tbody>
							</table>
						</div>

			    	</section>
    
			</div>
		</div>			
    </section>

    <?php
        include '../Views/FOOTER_View.php';
        } //fin metodo render
    
    } //fin Login
    
    ?>