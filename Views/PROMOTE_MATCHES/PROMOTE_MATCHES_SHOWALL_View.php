<?php

class PROMOTE_MATCHES{
	var $semana;

	function __construct(){	
	
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
								<th>Numero Inscritos</th>
								<th>Pista</th>
								<th><a class="button small" href="../Controllers/PROMOTE_MATCHES_Controller.php?action=ADD">Promocionar</a></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[0][1]?>&hora=9" class="button alt small">9:00</a></td>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[1][1]?>&hora=9"class="button small">9:00</a></td>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[2][1]?>&hora=9"class="button small">9:00</a></td>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[3][1]?>&hora=9"class="button small">9:00</a></td>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[4][1]?>&hora=9"class="button small">9:00</a></td>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[5][1]?>&hora=9"class="button small">9:00</a></td>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[6][1]?>&hora=9"class="button small">9:00</a></td>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[7][1]?>&hora=9"class="button small">9:00</a></td>
							</tr>
							<tr>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[0][1]?>&hora=11"class="button small">11:00</a></td>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[1][1]?>&hora=11"class="button small">11:00</a></td>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[2][1]?>&hora=11"class="button small">11:00</a></td>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[3][1]?>&hora=11"class="button small">11:00</a></td>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[4][1]?>&hora=11"class="button small">11:00</a></td>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[5][1]?>&hora=11"class="button small">11:00</a></td>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[6][1]?>&hora=11"class="button small">11:00</a></td>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[7][1]?>&hora=11"class="button small">11:00</a></td>
							</tr>	
							<tr>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[0][1]?>&hora=13"class="button small">13:00</a></td>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[1][1]?>&hora=13"class="button small">13:00</a></td>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[2][1]?>&hora=13"class="button small">13:00</a></td>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[3][1]?>&hora=13"class="button small">13:00</a></td>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[4][1]?>&hora=13"class="button small">13:00</a></td>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[5][1]?>&hora=13"class="button small">13:00</a></td>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[6][1]?>&hora=13"class="button small">13:00</a></td>
								<td><a href="../Controllers/PROMOTE_MATCHES_Controller.php?dia=<?=$this->semana[7][1]?>&hora=13"class="button small">13:00</a></td>
							</tr>				
						</tbody>
					</table>
				</div>
   		</section>
    <?php
        include '../Views/FOOTER_View.php';
        } //fin metodo render
    
    } //fin Login
    
    ?>