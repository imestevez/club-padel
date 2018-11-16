<?php

class CampeonatoUsuario{
	var $inscripciones;
	function __construct($inscripciones){
		$this->inscripciones=$inscripciones;
		$this->render();
	}

function render(){

    include '../Views/HEADER_View.php'; 
?>
    <!-- Main -->
     <section id="main" class="container">
        <header>
		   <h2>Tus campeonatos</h2>
		   <p>Consulta los campeonatos en los que te has inscrito</p>
		</header>

				<div class="table-wrapper">
					<table>
						<thead >
							<tr>
								<th>ID campeonato</th>
								<th>ID Pareja</th>
							</tr>
						</thead>
						<tbody>
							<?php 
					if( ($this->inscripciones <> NULL) &&  ( !is_string($this->inscripciones))) {
							foreach ($this->inscripciones as $key => $value) {
							?>
									<tr>
										<td>
											<?=$value[0]?>
										</td>
										<td>
											<?=$value[1]?>
										</td>
									</tr>
					<?php
							}//fin del while
						}//fin del if
					?>				
						</tbody>
					</table>

					<div id="bt_campeonatos">
						<p>Si quieres apuntarte a otro campeonato, hazlo aquí</p>
						<a href="../Controllers/CAMPEONATOUSUARIO_Controller.php?action=CAMPEONATOSABIERTOS" class="button " >Campeonatos abiertos</a>
					</div>

				</div>
    </section>

    <?php
        include '../Views/FOOTER_View.php';
        } //fin metodo render
    
    } //fin Login
    
    ?>