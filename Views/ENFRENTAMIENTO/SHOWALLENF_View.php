<?php

class EnfrentamientosCampeonato{

	var $showall;
	var $nombre;



	function __construct($nombre,$showall){			
		$this->showall = $showall;
		$this->nombre = $nombre;

		$this->render();
	}

function render(){

    include '../Views/HEADER_View.php'; 
?>
    <!-- Main -->
    
	<section id="main" class="container">
		<header>
		   <h2>Enfrentamientos</h2>
		    <p><?php echo $this->nombre ?></p>
		 </header>

		<div class="row">
			<div class="col-12">
			   <section class="box">
			    		<div class="table-wrapper">
							<table>
								<thead >
									<tr>
										<th>Categoría</th>
										<th>Grupo</th>
										<th>Pareja 1</th>
										<th>Pareja 2</th>
										<th>Resultado</th>

									</tr>
								</thead>
								<tbody>
							<?php 
							while ($row_proximos = mysqli_fetch_array($this->showall)) {
							
						?>			
									<tr>	
										<td><?php echo $row_proximos['NIVEL']." ".$row_proximos['GENERO'] ?></td>
										<td><?php echo $row_proximos['GR_NOMBRE']?></td>
										<td><?php echo $row_proximos['PAREJA1_ID']?></td>
										<td><?php echo $row_proximos['PAREJA2_ID']?></td>
										<?php if($row_proximos['RESULTADO'] <> NULL){ ?>
											<td><?php echo $row_proximos['RESULTADO']?></td>
										<?php }else{ ?>
											<td><?php echo "Sin resultado"?></td>
										<?php } ?>

									</tr>
						<?php }?>	

						
									
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