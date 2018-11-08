<?php

class PROMOCIONAR_PARTIDOS{
	var $tuplas;

	function __construct($tuplas){	
		$this->tuplas = $tuplas;
		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 

?>


    <!-- Main -->
	<section id="main" class="container">
	<header>
	   <h2>Partidos Promocionados</h2>
	    <p>Consulta los partidos ofrecidos por el club</p>
	 </header>
				<div class="table-wrapper">
					<table>
						<thead >
							<tr>
								<th>Fecha</th>
								<th>Hora</th>
								<th>Pista</th>
								<th>Numero Inscritos</th>
								<th><a class="button small" href="../Controllers/PROMOCIONAR_PARTIDOS_Controller.php?action=ADD">Promocionar</a></th>
							</tr>
						</thead>
						<tbody>
					<?php 
								while($row = mysqli_fetch_array($this->tuplas)){
					?>
							<tr>
								<td>
									<?=$row['FECHA']?>
								</td>
								<td>
									<?=$row['HORA_INICIO']?>
								</td>
								<td>
									<?=$row['PISTA_ID']?>
								</td>
								<td>
									<?=$row[0]?>
								</td>
								<td>
									<a class="button small" href="../Controllers/PROMOCIONAR_PARTIDOS_Controller.php?action=DELETE&id=$row['ID']">Borrar</a></th>
							</tr>
								</td>
							</tr>
					<?php
						}
					?>
									
						</tbody>
					</table>
				</div>
   		</section>
    <?php
        include '../Views/FOOTER_View.php';
        } //fin metodo render
    
    } //fin Login
    
    ?>