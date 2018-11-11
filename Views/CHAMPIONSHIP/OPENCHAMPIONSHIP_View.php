<?php

class OpenChampionship{

	

	function __construct(){	
		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 
?>


    <!-- Main -->
    <section class="box">
        <h3>Campeonatos Abiertos</h3>

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
							<?php foreach ($campeonatos as &$campeonato) {?>
							<tr>
								<td><?php $campeonato ?></td>
								<td><a href="../Controllers/USERCHAMPIONSHIP_Controller.php?action=INSCRIBIRCAMPEONATO?id=" class="button small" >Inscribirse</a></td>
							</tr>
							<?php }?>				
						</tbody>
					</table>

				</div>
    </section>

    <?php
        include '../Views/FOOTER_View.php';
        } //fin metodo render
    
    } //fin Login
    
    ?>