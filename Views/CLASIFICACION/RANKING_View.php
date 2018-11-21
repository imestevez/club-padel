<?php
class RANKING{
	var $campeonato;
	var $clasificaciones;

	function __construct($campeonato,$clasificaciones){
		$this->campeonato = $campeonato;
		$this->clasificaciones = $clasificaciones;
		$this->render();
	}

function render(){
    include '../Views/HEADER_View.php';
?>
	<section id="main" class="container">
		<header>
		   <h2><?php  $_REQUEST['nombre']?></h2>
		    <p>Consulta las clasificaciones de los distintos campeonatos</p>
		 </header>
		 	<?php foreach ($this->clasificaciones as $key => $grupos) { ?>
		 		<section class="box">
		 			<h3><?php echo $key ?></h3>
			    		<div class="table-wrapper">
							<table>
								<thead >
									<tr>
										<th>Posición</th>
										<th>Jugador 1</th>
										<th>Jugador 2</th>
										<th>Puntos</th>
									</tr>
								</thead>
								<tbody>
		 						<?php if($grupos <> NULL){
		 						foreach ($grupos as $clasificacion => $value) { ?>

		 						<?php foreach ($grupos as $clasificacion => $value) { ?>
		 						

									<tr>
										<td><?php echo $value[0][1] ?></td>
										<td><?php echo $value[0][2] ?></td>
										<td><?php echo $value[0][3] ?></td>								
									</tr>	
								<?php }}} ?>							
		 						</tbody>
						</table>
						</div>
					</section>	

		 		<?php }?>
   		</section>
    <?php
        include '../Views/FOOTER_View.php';
        }
    }
    ?>
