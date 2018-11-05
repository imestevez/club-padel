<?php

class PROMOTE_MATCHES{
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
								<th><a class="button small" href="../Controllers/PROMOTE_MATCHES_Controller.php?action=ADD">Promocionar</a></th>
							</tr>
						</thead>
						<tbody>
					<?php 
								while($row = mysqli_fetch_array($this->tuplas)){
					?>
							<tr>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[0][1]?>&hora=9" class="button alt small">
									<?=$row['FECHA']?>
									</a>
								</td>
									<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[0][1]?>&hora=9" class="button alt small">
									<?=$row['FECHA']?>
									</a>
								</td>
									<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[0][1]?>&hora=9" class="button alt small">
									<?=$row['PISTA_ID']?>
									</a>
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