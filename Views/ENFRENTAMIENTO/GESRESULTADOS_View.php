<?php

class GESRESULTADOS{
	var $campeonato;
	var $enfrentamientos;

	function __construct($campeonato, $enfrentamientos){	
		$this->campeonato = mysqli_fetch_array($campeonato);
		$this->enfrentamientos = $enfrentamientos;
		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 

?>

    <!-- Main -->
	<section id="main" class="container">
	<header>
	   <h2>Todos los enfrentamientos</h2>
	    <p>Introduce los resultados</p>
	 </header>
				<div class="table-wrapper">
	    			<p><?=$this->campeonato['NOMBRE']?></p>
					<table>
						<thead >
							<tr>
								<th>Categoría</th>
								<th>Grupo</th>
								<th>Pareja 1</th>
								<th>Pareja 2</th>
								<th>Fecha</th>
								<th>Hora</th>
								<th>Pista</th>
								<th>Resultado</th>
								<th></th>
								
							</tr>
						</thead>
						<tbody>
					<?php 
						if($this->enfrentamientos <> NULL){
							while($row = mysqli_fetch_array($this->enfrentamientos)){
								$hora_inicio = explode(":", $row['HORA_INICIO']);
								$hora_fin = explode(":", $row['HORA_FIN']);
					?>
							<tr>
										<td><?php echo $row['NIVEL']." ".$row['GENERO'] ?></td>
										<td><?php echo $row['GR_NOMBRE']?></td>
										<td>
												<!--a class="button small" href="../Controllers/ENFRENTAMIENTO_Controller.php?action=SHOW_PAREJA&pareja_ID=<?=$row['PAREJA1_ID']?>&campeonato_ID=<?=$this->campeonato['ID']?>"><?php echo $row['PAREJA1_ID']?></a-->
												<a class=" small" href="../Controllers/ENFRENTAMIENTO_Controller.php?action=SHOW_PAREJA&pareja_ID=<?=$row['PAREJA1_ID']?>&campeonato_ID=<?=$this->campeonato['ID']?>"><?php echo $row['PAREJA1_ID']?></a>

											
										</td>
										<td>
												<!--a class="button small" href="../Controllers/ENFRENTAMIENTO_Controller.php?action=SHOW_PAREJA&pareja_ID=<?=$row['PAREJA2_ID']?>&campeonato_ID=<?=$this->campeonato['ID']?>"><?php echo $row['PAREJA2_ID']?></a-->

												<a class=" small" href="../Controllers/ENFRENTAMIENTO_Controller.php?action=SHOW_PAREJA&pareja_ID=<?=$row['PAREJA2_ID']?>&campeonato_ID=<?=$this->campeonato['ID']?>"><?php echo $row['PAREJA2_ID']?></a>
										</td>
										<td><?php echo $row['FECHA']?></td>
										<td><?php echo $hora_inicio[0].":".$hora_inicio[1]." - ".$hora_fin[0].":".$hora_fin[1] ?></td>
										<td><?php echo $row['PISTA_NOMBRE']?></td>
										<?php if( $row['RESULTADO'] <> null){ ?>
											<td><?php echo $row['RESULTADO']?></td>
										<?php }else{ ?>
											<td><?php echo "-"?></td>
										<?php } ?>
										<td>
											<a class="button small" href="../Controllers/ENFRENTAMIENTO_Controller.php?action=INTRODUCIRRESULTADO&enfrentamiento_ID=<?=$row['ENFRENTAMIENTO_ID']?>">Resultado</a>
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
    <?php
        include '../Views/FOOTER_View.php';
        } //fin metodo render
    
    } //fin class
    
    ?>