<?php

	class CampeonatosCerrados{

		var $datos;

		function __construct($datos){
			$this->datos = $datos;
			$this->render();
		}

		function render(){

		    include '../Views/HEADER_View.php'; 
?>


		    <!-- Main -->
		    <section class="box">
		        <h3>Campeonatos cerrados</h3>
						<div class="table-wrapper">
							<table>
								<thead >
									<tr>
										<th>Código</th>
										<th>Nombre</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
			<?php  while( $row = mysqli_fetch_array($this->datos)){ ?>	
									<tr>
										<td><?php echo $row['ID']?></td>
										<td><?php echo $row['NOMBRE']?></td>
										<td><a href="../Controllers/CAMPEONATO_Controller.php?action=GENERAR" class="button small" >Generar Enfrentamientos</a></td>
									</tr>
			<?php } ?>										
								</tbody>
							</table>

						</div>
		    </section>

		    <?php
		        include '../Views/FOOTER_View.php';
		        } //fin metodo render
		    
		    } //fin Login
		    
		    ?>