<?php

class CampeonatosAbiertos{
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
		   <h2>Campeonatos abiertos</h2>
		   <p>Consulta los campeonatos abiertos</p>
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
								<th>Fecha límite inscripciones</th>
								<th></th>
							</tr>
						</thead>
						<tbody>

					<?php 
					if( ($this->campeonatos <> NULL) &&  ( !is_string($this->campeonatos))) {
							foreach ($this->campeonatos as $key => $value) {
							?>
						<form method="post" action="../Controllers/CAMPEONATOUSUARIO_Controller.php?action=INSCRIBIRCAMPEONATO">
							
									<tr>
										<td>
											<?=$value[0]?>
										</td>
										<td>
											<?=$value[1]?>
										</td>
										
										<td>
											<input class="oculto" name="campeonato_ID" readonly value="<?=$key?>">
											<input class="oculto" name="nombre" readonly value="<?=$value[0]?>">
											<input type="submit" class="small" value="Inscribir">
										</td>
									</tr>
						
						</form>			

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