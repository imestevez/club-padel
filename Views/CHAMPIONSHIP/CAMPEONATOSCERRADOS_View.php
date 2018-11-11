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
	<section id="main" class="container">
		<header>
		   <h2>Campeonatos Cerrados</h2>
		    <p>Crea grupos y enfrentamientos sobre cada campeonato cerrado</p>
		 </header>
		 <div class="row">
		<div class="col-12">
		    <!-- Main -->
		    <section class="box">
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
		    </div>
		</div>			
    </section>
		    <?php
		        include '../Views/FOOTER_View.php';
		        } //fin metodo render
		    
		    } //fin Login
		    
		    ?>