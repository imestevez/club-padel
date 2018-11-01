<?php

class UserChampionship{
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
								<th>Pareja</th>
								<th>Categoría</th>
								<th>Grupo</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Torneito</td>
								<td>Peter Hill</td>
								<td>Masculino 1º</td>
								<td>3</td>
							</tr>
							<tr>
								<td>Torneo ocho</td>
								<td>Tuco</td>
								<td>Mixto 2º</td>
								<td>2</td>
							</tr>					
						</tbody>
					</table>

					<div id="bt_campeonatos">
						<p>Si quieres apuntarte a otro campeonato, hazlo aquí</p>
						<a href="../Controllers/USERCHAMPIONSHIP_Controller.php?action=OPENCHAMPIONSHIPS" class="button " >Campeonatos abiertos</a>
					</div>

				</div>
    </section>

    <?php
        include '../Views/FOOTER_View.php';
        } //fin metodo render
    
    } //fin Login
    
    ?>