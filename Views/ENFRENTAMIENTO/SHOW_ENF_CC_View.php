<?php

class SHOW_ENF_CC{
	var $campeonato;
	var $enfrentamientos;
	var $grupo_cat;
	var $grupos;
	var $campeonato_ID;

	function __construct($campeonato, $enfrentamientos, $grupo_cat,$campeonato_ID){	
		$this->campeonato = $campeonato;
		$this->enfrentamientos = $enfrentamientos;
		$this->grupo_cat = $grupo_cat;
		$this->campeonato_ID = $campeonato_ID;
		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 

?>

	<section id="main" class="container">
	<header>
	   <h2>Todos los enfrentamientos</h2>
	    <p>Ver enfrentamientos según categoría y grupo de campeonato</p>
	 </header>

	 <div class="row">
			<div class="col-12">
			    	<section class="box">
			    		<h1>Selecciona categoría y grupo del campeonato:</h1>
			    		<form id="form1" name="form1" method="post" action="../Controllers/ENFRENTAMIENTO_Controller.php?action=SHOW_ENF_ETAPAS&campeonato_ID=<?php echo $this->campeonato_ID?>">
      <table width="300" border="1">
        <tr>
          <td><p><?php echo $this->campeonato?> </p></td>
          <td><select name="grupo_cat" size="1"  tabindex="1">
          	<?php 
          		while ($row = mysqli_fetch_array($this->grupo_cat)) {
          	?>
            	<option value=<?php echo $row['GRUPO_ID'].",".$row['CATEGORIA_ID']?> ><?php echo $row['NIVEL']." ".$row['GENERO']." - Grupo ".$row['GRUPO_NOMBRE']?></option>	
          	<?php
          		}
          	?>
          </select>
          </td>
          
          <td><input type="submit" value="Mostrar" /></td>
        </tr>
      </table>
			    	</section>
			</div>
	</div>


	</section>

    <?php
        include '../Views/FOOTER_View.php';
        } //fin metodo render
    
    function faseAct(){
    ?>
    <div class="row">
			<div class="col-12">
			    	<section class="box">
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
		</div>
	</div>


	<?php
    	}    


    } //fin class
    
    ?>