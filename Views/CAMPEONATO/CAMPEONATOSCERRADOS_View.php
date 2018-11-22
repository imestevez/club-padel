<?php

	class CampeonatosCerrados{

		var $conenf;
		var $sinenf;


		function __construct($conenf, $sinenf){
			$this->conenf = $conenf;
			$this->sinenf = $sinenf;

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
										<th>Nombre</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
			<?php  while( $row = mysqli_fetch_array($this->sinenf)){ ?>	
									<tr>
										<td><?php echo $row['NOMBRE']?></td>
										<td><a href="../Controllers/CAMPEONATO_Controller.php?action=GENERAR&id=<?php echo $row['ID']?>" class="button small" >Generar Enfrentamientos</a></td>
									</tr>
			<?php } ?>	
			<?php  while( $row = mysqli_fetch_array($this->conenf)){ ?>	
									<tr>
										<td><?php echo $row['NOMBRE']?></td>
										<td><a href="../Controllers/CAMPEONATO_Controller.php?action=SHOWALLENF&id=<?php echo $row['ID']?>&nombre=<?php echo $row['NOMBRE']?>" class="button small" >Ver enfrentamientos</a></td>
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