<?php

class SHOW_PAREJA{
	var $campeonato;
	var $pareja;

	function __construct($campeonato,$pareja){	
		$this->campeonato = $campeonato;
		$this->pareja = mysqli_fetch_array($pareja);
		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 

?>

    <!-- Main -->
	<section id="main" class="container">
	<header>
	   <h2>Pareja</h2>
	    <p>Consulta los logins de la pareja</p>
	 </header>
				<div class="table-wrapper">
					<table>
						<thead >
							<tr>
								<th>Jugador 1</th>
								<th>Jugador 2</th>
								<th>Capitán</th>

							</tr>
						</thead>
						<tbody>
					<?php 
						if($this->pareja <> NULL){
						?>
							<tr>
								<td>
									<?=$this->pareja['JUGADOR_1']?>
								</td>
								<td>
									<?=$this->pareja['JUGADOR_2']?>
								</td>
								<td>
									<?=$this->pareja['CAPITAN']?>
								</td>
							</tr>
					<?php
						}//fin del if
					?>
						</tbody>
					</table>
          				<div class="col-12">
                        <ul class="actions special">
                            <li><a class="button small" href="../Controllers/ENFRENTAMIENTO_Controller.php?action=SHOW&campeonato_ID=<?=$this->campeonato?>">Volver</a>
                            </li>
                        </ul>
                    </div>
				</div>
   		</section>
    <?php
        include '../Views/FOOTER_View.php';
        } //fin metodo render
      
 }
    ?>