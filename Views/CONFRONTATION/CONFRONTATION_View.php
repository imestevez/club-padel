<?php

class Confrontation{
	function __construct(){	
		$this->render();
	}

function render(){

    include '../Views/HEADER_View.php'; 
?>
    <!-- Main -->
    
	<section id="main" class="container">
		<header>
		   <h2>Enfrentamientos</h2>
		    <p>Gestiona tus enfrentamientos con otras parejas en los campeonatos en los que estás inscrito del club</p>
		 </header>

		<div class="row">
			<div class="col-12">
			    <section class="box">	
				    <h3>Enfrentamientos pendientes</h3>

				    	<div class="table-wrapper">
							<table>
								<thead >
									<tr>
										<th>Campeonato</th>
										<th>Adversario</th>
										<th>Categoría</th>
										<th>Grupo</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Torneito</td>
										<td>Peter Hill</td>
										<td>Masculino 1º</td>
										<td>3</td>
										<td><a href="../Controllers/USERCHAMPIONSHIP_Controller.php?action=OPENCHAMPIONSHIPS" class="button small" >Proponer horario</a></td>
									</tr>
									<tr>
										<td>Torneo ocho</td>
										<td>Tuco</td>
										<td>Mixto 2º</td>
										<td>2</td>
										<td><a href="../Controllers/USERCHAMPIONSHIP_Controller.php?action=OPENCHAMPIONSHIPS" class="button small" >Proponer horario</a></td>
									</tr>					
								</tbody>
							</table>
						</div>

				    <hr />
				    <h3>Consultar propuestas</h3>
				    <h1>Tus propuestas</h1>
				    <h1>Propuestas de otros jugadores</h1>
				    <hr />
				    <h3>Enfrentamientos establecidos</h3>
				    	<div class="table-wrapper">
							<table>
								<thead >
									<tr>
										<th>Campeonato</th>
										<th>Adversario</th>
										<th>Categoría</th>
										<th>Grupo</th>
										<th>Fecha</th>
										<th>Hora</th>
										<th>Pista</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Torneito</td>
										<td>Peter Hill</td>
										<td>Masculino 1º</td>
										<td>3</td>
										<td>19/23/1997</td>
										<td>17:00</td>
										<td>3</td>
									</tr>
									<tr>
										<td>Torneo ocho</td>
										<td>Tuco</td>
										<td>Mixto 2º</td>
										<td>2</td>
										<td>22/02/2007</td>
										<td>20:00</td>
										<td>1</td>
									</tr>					
								</tbody>
							</table>
						</div>
				</section>    
<!--
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
-->			</div>
		</div>			
    </section>

    <?php
        include '../Views/FOOTER_View.php';
        } //fin metodo render
    
    } //fin Login
    
    ?>