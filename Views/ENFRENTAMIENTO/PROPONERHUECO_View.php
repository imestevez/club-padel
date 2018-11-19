<?php

class ProponerHueco{

	var $huecosActuales;

	var $enfrentamiento_id;
	var $pareja_id;

	function __construct($huecosActuales,$enfrentamiento_id,$pareja_id){

		$this->huecosActuales = $huecosActuales;
		$this->enfrentamiento_id = $enfrentamiento_id;	
		$this->pareja_id = $pareja_id;	


		$this->render();
	}

function render(){

    include '../Views/HEADER_View.php'; 
?>
    <!-- Main -->
    
	<section id="main" class="container">
		<header>
		   <h2>Propuestas actuales</h2>
		    <p>Completa tu propuesta de disponibilidad</u></p>
		 </header>

		<div class="row">
			<div class="col-12">
			    	<section class="box">
									
						<?php 
							if($this->huecosActuales <> null && mysqli_num_rows($this->huecosActuales) > 0){

						?>
								<div class="table-wrapper">
							<table>
								<thead >
									<tr>
										<th>Fecha</th>
										<th>Hora inicio</th>
										<th>Hora fin</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
						<?php		

									while ($row_huecosActuales = mysqli_fetch_array($this->huecosActuales)) {
							
						?>			
									<tr>	
										<td><?php echo $row_huecosActuales['FECHA']?></td>
										<td><?php echo $row_huecosActuales['HORA_INICIO'] ?></td>
										<td><?php echo $row_huecosActuales['HORA_FIN'] ?></td>
										<td><a href="../Controllers/HUECO_Controller.php?action=DELETE&fecha=<?php echo $row_huecosActuales['FECHA'] ?>&enfrentamiento_id=<?php echo $this->enfrentamiento_id ?>&pareja_id=<?php echo $this->pareja_id ?>&horario_id=<?php echo $row_huecosActuales['HORARIO_ID'] ?>" class="button small" >Eliminar</a></td>
									</tr>
						<?php 		} 
								}?>
									
								</tbody>
							</table>
							<div id="bt_campeonatos">
								<p>Puedes añadir más franjas de disponibilidad o terminar tu propuesta</p>
								<a href="../Controllers/HUECO_Controller.php?action=NUEVO&enfrentamiento_id=<?php echo  $this->enfrentamiento_id ?>&pareja_id=<?php echo $this->pareja_id ?>" class="button small" >Proponer nuevo</a>
								<a href="../Controllers/ENFRENTAMIENTO_Controller.php?action=GESHORARIOS" class="button small" >Terminar propuesta</a>
							</div>
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