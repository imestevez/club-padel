<?php

class CAMPEONATOS_ENFRENT{
	var $campeonatos;
	

	function __construct($campeonatos){	
		$this->campeonatos=$campeonatos;
		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 
?>


    <!-- Main -->
    <section id="main" class="container">
        <header>
		   <h2>Campeonatos</h2>
		   <p>Consulta los enfrenatemientos del campenoato que elijas</p>
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

					<?php 
					if( ($this->campeonatos <> NULL) &&  ( !is_string($this->campeonatos))) {
							while ($row = mysqli_fetch_array($this->campeonatos)) {
							?>
									<tr>
										<td>
											<?=$row['NOMBRE']?>
										</td>
										<td>
											<a class="button small" href="../Controllers/ENFRENTAMIENTO_Controller.php?action=SHOW&campeonato_ID=<?=$row['ID']?>">Enfrentamientos</a>
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
		</div>
	</div>	
    </section>

    <?php
        include '../Views/FOOTER_View.php';
        } //fin metodo render
    
    } //fin Login
    
    ?>