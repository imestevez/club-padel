<?php
class RANKING{
	var $campeonato;
	var $nombre_tablas;
	var $num_grupos;
	var $clasificaciones;

	function __construct($campeonato,$nombre_tablas,$clasificaciones,$num_grupos){
		$this->campeonato = $campeonato;
		$this->nombre_tablas = $nombre_tablas;
		$this->num_grupos = $num_grupos;

		$this->clasificaciones = $clasificaciones;
		$this->render();
	}

function render(){
    include '../Views/HEADER_View.php';
?>
	<section id="main" class="container">
		
		<header>
		   <h2><?php  echo $this->campeonato?></h2>
		    <p>Consulta las clasificaciones de los distintos campeonatos</p>
		 </header>
		 <div class="row">
			<div class="col-12">

		 	

									<?php $j = 0; for ($gru=0; $gru < $this->num_grupos; $gru++) { 
											
									 if($cam_cat_gru = mysqli_fetch_array($this->nombre_tablas)){ 
									 	if(array_key_exists($cam_cat_gru['GRUPO_ID'], $this->clasificaciones))	{								 	
									 		$tupla = $this->clasificaciones[$cam_cat_gru['GRUPO_ID']]; ?>
					 		<section class="box">
					 			<h3><?php echo $cam_cat_gru['NIVEL']." ".$cam_cat_gru['GENERO']." - Grupo: ".$cam_cat_gru['GRUPO_NOMBRE'] ?></h3>
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
											<?php $i=1; 
											//$res_grupo = array_slice($this->clasificaciones, $gru, $gru-1);
											//echo "RECORSET; ".$res_grupo;
											while ($clas = mysqli_fetch_array($tupla)) {	
											?>			
												<tr>	
													<td><?php echo $i?></td>
													<td><?php echo $clas['JUGADOR_1']?></td>
													<td><?php echo $clas['JUGADOR_2']?></td>
													<td><?php echo $clas['PUNTOS']?></td>
												</tr>
											<?php $i++; } ?>
									<?php
											$j++;?>
											</tbody>
							</table>
						</div>
					</section>
										 <?php
										  } 
									}
								 }
						 ?>
        </div>
			</div>
   		</section>

   	<?php
		        include '../Views/FOOTER_View.php';
		    }
		}
    ?>
