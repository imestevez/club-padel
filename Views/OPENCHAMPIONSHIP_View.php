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
        <h3>Tus Campeonatos</h3>

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
							<tr>
								<td>Torneito</td>
								<td>12/08/1997</td>
								<td><a href="#" class="button " >Inscribirse</a></td>
							</tr>
							<tr>
								<td>Torneo ocho</td>
								<td>12/13/2019</td>
								<td><a href="#" class="button " >Inscribirse</a></td>
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