<?php

class GESRESULTADOS{
	var $enfrentamientos;

	function __construct($enfrentamientos){	
		$this->enfrentamientos = $enfrentamientos;
		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 

?>

    <!-- Main -->
	<section id="main" class="container">
	<header>
	   <h2>Todos los enfrentamientos</h2>
	    <p>Introduce los resultados</p>
	 </header>
				<div class="table-wrapper">
					<table>
						<thead >
							<tr>
								<th>ID</th>
								<th>Grupo ID</th>
								<th>Resultado</th>
								<th>Pareja 1</th>
								<th>Pareja 2</th>
								<th>Reserva ID</th>
								
							</tr>
						</thead>
						<tbody>
					<?php 
						if($this->enfrentamientos <> NULL){
							while($row = mysqli_fetch_array($this->enfrentamientos)){
					?>
							<tr>
								<td>
									<?=$row['ID']?>
								</td>
								<td>
									<?=$row['GRUPO_ID']?>
								</td>
								<td>
									<?=$row['RESULTADO']?>
								</td>
								<td>
									<?=$row['PAREJA_1']?>
								</td>
								<td>
									<?=$row['PAREJA_2']?>
								</td>
								<td>
									<?=$row['RESERVA_ID']?>
								</td>
								<td>
									<a class="button small" href="../Controllers/ENFRENTAMIENTO_Controller.php?action=INTRODUCIRRESULTADO&enfrentamiento_ID=<?=$row['ID']?>">Resultado</a>
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
        } //fin metodo render
    
    } //fin class
    
    ?>