<?php

class EnfrentamientoProximos{

	var $proximos1;
	var $proximos2;
	var $showall;


	function __construct($proximos1, $proximos2,$showall){	
		$this->proximos1 = $proximos1;
		$this->proximos2 = $proximos2;
		$this->showall = $showall;


		$this->render();
	}

function render(){

    include '../Views/HEADER_View.php'; 
?>
    <!-- Main -->
    
	<section id="main" class="container">
		<header>
		   <h2>Próximos enfrentamientos</h2>
		    <p>Calendario de enfrentamientos del club</p>
		 </header>

		<div class="row">
			<div class="col-12">
			   <section class="box">
			    		<div class="table-wrapper">
							<table>
								<thead >
									<tr>

						<?php if(isset($_SESSION["rol"]) && ($_SESSION["rol"] == 'ADMIN')){ ?>
										<th>Campeonato</th>
										<th>Categoría</th>
										<th>Grupo</th>
										<th>Pareja 1</th>
										<th>Pareja 2</th>
										<th>Fecha</th>
										<th>Hora</th>
										<th>Pista</th>
									</tr>
								</thead>
								<tbody>
							<?php 
							while ($row_proximos = mysqli_fetch_array($this->showall)) {
								$hora_inicio = explode(":", $row_proximos['HORA_INICIO']);
								$hora_fin = explode(":", $row_proximos['HORA_FIN']);
							
						?>			
									<tr>	
										<td><?php echo $row_proximos['CAM_NOMBRE']?></td>
										<td><?php echo $row_proximos['NIVEL']." ".$row_proximos['GENERO'] ?></td>
										<td><?php echo $row_proximos['GR_NOMBRE']?></td>
										<td><?php echo $row_proximos['PAREJA1_ID']?></td>
										<td><?php echo $row_proximos['PAREJA2_ID']?></td>
										<td><?php echo $row_proximos['FECHA']?></td>
										<td><?php echo $hora_inicio[0].":".$hora_inicio[1]." - ".$hora_fin[0].":".$hora_fin[1] ?></td>
										<td><?php echo $row_proximos['PISTA_NOMBRE']?></td>
									</tr>
						<?php }} else{ ?>		

								<th>Campeonato</th>
										<th>Categoría</th>
										<th>Grupo</th>
										<th>Contrincante</th>
										<th>Fecha</th>
										<th>Hora</th>
										<th>Pista</th>
									</tr>
								</thead>
								<tbody>	
						<?php 

							while ($row_proximos = mysqli_fetch_array($this->proximos1)) {
								$hora_inicio = explode(":", $row_proximos['HORA_INICIO']);
								$hora_fin = explode(":", $row_proximos['HORA_FIN']);
							
						?>			
									<tr>	
										<td><?php echo $row_proximos['CAM_NOMBRE']?></td>
										<td><?php echo $row_proximos['NIVEL']." ".$row_proximos['GENERO'] ?></td>
										<td><?php echo $row_proximos['GR_NOMBRE']?></td>
										<td><?php echo $row_proximos['CAPITAN']?></td>
										<td><?php echo $row_proximos['FECHA']?></td>
										<td><?php echo $hora_inicio[0].":".$hora_inicio[1]." - ".$hora_fin[0].":".$hora_fin[1] ?></td>
										<td><?php echo $row_proximos['PISTA_NOMBRE']?></td>
									</tr>
						<?php } ?>

						<?php 
							while ($row_proximos = mysqli_fetch_array($this->proximos2)) {
								$hora_inicio = explode(":", $row_proximos['HORA_INICIO']);
								$hora_fin = explode(":", $row_proximos['HORA_FIN']);
							
						?>			
									<tr>	
										<td><?php echo $row_proximos['CAM_NOMBRE']?></td>
										<td><?php echo $row_proximos['NIVEL']." ".$row_proximos['GENERO'] ?></td>
										<td><?php echo $row_proximos['GR_NOMBRE']?></td>
										<td><?php echo $row_proximos['CAPITAN']?></td>
										<td><?php echo $row_proximos['FECHA']?></td>
										<td><?php echo $hora_inicio[0].":".$hora_inicio[1]." - ".$hora_fin[0].":".$hora_fin[1] ?></td>
										<td><?php echo $row_proximos['PISTA_NOMBRE']?></td>
									</tr>
						<?php }
							} ?>
									
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