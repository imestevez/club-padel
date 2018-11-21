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
		   <h2><?= $_REQUEST['nombre']?></h2>
		    <p>Consulta las clasificaciones de los distintos campeonatos</p>
		 </header>
		 	<?php foreach ($this->clasificaciones as $key1 => $categorias) { ?>
		 		
		 		<?php foreach ($categorias as $key2 => $grupos) { ?>
		 			<section class="box">
		 			<h3><?php echo $key1 ?></h3>
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
		 			<?php 	$i = 1;
		 					foreach ($grupos as $key3 => $value2) { ?>
		 			
		 						<tr>	
										<td><?php echo $i ?></td>
										<td><?php echo $value2[1] ?></td>
										<td><?php echo $value2[2]?></td>
										<td><?php echo $value2[3]?></td>
								</tr>
								
		 			<?php $i++;
		 					} ?>
		 					
		 				</tbody>
						</table>
						</div>
					</section>	
		 		<?php } ?>		 					
		 	<?php } ?>
   		</section>
    <?php
        include '../Views/FOOTER_View.php';
        }
    }
    ?>
