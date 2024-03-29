<?php

class OfertaHuecos{

	var $huecos1;
	var $id_contrincante;
	var $enfrentamiento_id;
	var $pareja_id;

	function __construct($huecos1, $pareja_id, $enfrentamiento_id){

		$this->huecos1 =  $huecos1;
		$this->pareja_id =  $pareja_id;
		$this->enfrentamiento_id =  $enfrentamiento_id;



		$this->render();
	}

function render(){

    include '../Views/HEADER_View.php'; 
?>
    <!-- Main -->
    
	<section id="main" class="container">
		<header>
		   <h2>Huecos propuestos</h2>
		    <p>Disponibilidad de tu contrincante para jugar el enfrentamiento</u></p>
		 </header>

		<div class="row">
			<div class="col-12">
			    	<section class="box">
			    		<h3>Tus ofertas</h3>
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
							while ($row_tusOfertas1 = mysqli_fetch_array($this->huecos1)) {
							
						?>			
									<tr>	
										<td><?php echo $row_tusOfertas1['FECHA']?></td>
										<td><?php echo $row_tusOfertas1['HORA_INICIO'] ?></td>
										<td><?php echo $row_tusOfertas1['HORA_FIN'] ?></td>
										<td><a href="../Controllers/HUECO_Controller.php?action=ACEPTAR&fecha=<?php echo $row_tusOfertas1['FECHA']?>&horario_id=<?php echo $row_tusOfertas1['HORARIO_ID']?>&pareja_id=<?php echo $row_tusOfertas1['PAREJA_ID']?>&enfrentamiento_id=<?php echo $row_tusOfertas1['ENFRENTAMIENTO_ID']?>" class="button small" >Aceptar</a></td>
									</tr>
						<?php } ?>
									
								</tbody>
							</table>
							<div id="bt_campeonatos">
								<p>Si ninguna propuesta del contrincante te parece válida, haz una nueva propuesta</p>
								<a href="../Controllers/ENFRENTAMIENTO_Controller.php?action=RECHAZAR&enfrentamiento_id=<?php echo $this->enfrentamiento_id?>&pareja_id=<?php echo $this->pareja_id?>" class="button " >Rechazar y proponer</a>
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