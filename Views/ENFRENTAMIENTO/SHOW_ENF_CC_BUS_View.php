<?php

class SHOW_ENF_CC_BUS{
	var $campeonato;
	var $categoria_fet;
	var $grupo;
	var $fase_grupos;
	var $fase_cuartos;
	var $fase_semis;
	var $fase_final;
	var $actual;
	var $grupo_cat;
	var $campeonato_ID;

	var $grupo_id;

	


	function __construct($campeonato, $categoria_fet, $grupo, $fase_grupos,$fase_cuartos, $fase_semis, $fase_final,$actual,$grupo_cat,$campeonato_ID){	
		$this->campeonato = $campeonato;
		$this->categoria_fet = $categoria_fet;
		$this->grupo = $grupo;
		$this->fase_grupos = $fase_grupos;
		$this->fase_cuartos = $fase_cuartos;
		$this->fase_semis = $fase_semis;
		$this->fase_final = $fase_final;
		$this->actual = $actual;
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
	<?php $this->render_tablas() ?>

	</section>

    <?php
        include '../Views/FOOTER_View.php';
        } //fin metodo render
    
    //Función para mostrar las tablas segun la etapa actual
        function render_tablas(){
        	switch ($this->actual) {
        		case 'F':
        			$datos = $this->fase_final;	
        			$this->render_etapa($datos);
        			break;
        		case 'S':
        			$datos = $this->fase_semis;	
        			$this->render_etapa($datos);
        			break;
        		case 'C':
        			$datos = $this->fase_cuartos;	
        			$this->render_etapa($datos);
        			break;
        		case 'G':
        			$datos = $this->fase_grupos;	
        			$this->render_etapa($datos);
        			break;			
        		
        		default:
        			# code...
        			break;
        	}
        }
    //Función para pintar tabla fase grupos
        function tabla_etapa($datos){
        	if($datos <> NULL){
        		if(mysqli_num_rows($datos)){
    ?>
					<table>
						<thead >
							<tr>
								<th>Pareja 1</th>
								<th>Pareja 2</th>
								<th style="text-align: center;">Resultado</th>
							</tr>
						</thead>
						<tbody>
					<?php 
					
						
						
							while($row = mysqli_fetch_array($datos)){
						
					?>
							<tr>
										<td>
												<a class=" small" href="../Controllers/ENFRENTAMIENTO_Controller.php?action=SHOW_PAREJA&pareja_ID=<?=$row['PAREJA1_ID']?>&campeonato_ID=<?=$this->campeonato_ID?>"><?php echo $row['PAREJA1_ID']?></a>

											
										</td>
										<td>
												<a class=" small" href="../Controllers/ENFRENTAMIENTO_Controller.php?action=SHOW_PAREJA&pareja_ID=<?=$row['PAREJA2_ID']?>&campeonato_ID=<?=$this->campeonato_ID?>"><?php echo $row['PAREJA2_ID']?></a>
										</td>
										<?php if( $row['RESULTADO'] <> null){ ?>
											<td style="text-align: center;"><?php echo $row['RESULTADO']?></td>
										<?php }else{ ?>
											<td style="text-align: center; color: red" >No jugado</td>
										<?php } ?>
										
							</tr>
				<?php
						}//fin del while
						}
						else{
				?>
						<p style="text-align: center; color: red">Aún no se ha jugado ningún partido de esta fase en este grupo</p>
				<?php
						}
					}//fin del if
				?>
						</tbody>
					</table>


	<?php
    	}  

    	function render_etapa($datos){
    ?>
    	<div class="row">
			<div class="col-12">
			    	<section class="box">
			    		<?php if (mysqli_num_rows($this->categoria_fet) == 0) {
			    			}
			    		if($row_cat = mysqli_fetch_array($this->categoria_fet) ){
			    			$genero = $row_cat['GENERO'];
			    			$nivel = $row_cat['NIVEL'];
			    			if($row_gru = mysqli_fetch_array($this->grupo)){
			    				$this->grupo_id = $row_gru['ID'];
			    		?>
			    		<h2><?php echo $this->campeonato." : ".$nivel." ".$genero." - Grupo ".$row_gru['NOMBRE'] ?></h2>
			    		<?php
			    		switch ($this->actual) {
			    			case 'F':
			    		?>	
			        			<p>Etapa actual: <b><u>FINAL</b></u></p>
		        		<?php		break;
			        		case 'S': ?>
			        			<p>Etapa actual: <b><u>SEMIFINAL</b></u></p>
			        	<?php		break;
			        		case 'C': ?>
			        			<p>Etapa actual: <b><u>CUARTOS de final</b></u></p>
			        	<?php		break;
			        		case 'G': ?>
			        			<p>Etapa actual: <b><u>Fase de GRUPOS</b></u></p>
			        	<?php		break;
			    			}
			    		?>
			    		
			    		<?php }} ?>
    				<div class="table-wrapper">
    					<?php $this->tabla_etapa($datos) ?>
    				</div>
    			</section>
    		</div>
    	</div>
    <?php	
    	}
    //Función para pintar tabla fase cuartos
    function tabla_cuartos(){
        	if($this->fase_cuartos <> NULL){
        		if(mysqli_num_rows($this->fase_cuartos)){
    ?>
					<table>
						<thead >
							<tr>
								<th>Pareja 1</th>
								<th>Pareja 2</th>
								<th style="text-align: center;">Resultado</th>
							</tr>
						</thead>
						<tbody>
					<?php 
					
						
							while($row = mysqli_fetch_array($this->fase_cuartos)){
					?>
							<tr>
										<td>
												<a class=" small" href="../Controllers/ENFRENTAMIENTO_Controller.php?action=SHOW_PAREJA&pareja_ID=<?=$row['PAREJA1_ID']?>&campeonato_ID=<?=$this->campeonato_ID?>"><?php echo $row['PAREJA1_ID']?></a>

											
										</td>
										<td>
												<a class=" small" href="../Controllers/ENFRENTAMIENTO_Controller.php?action=SHOW_PAREJA&pareja_ID=<?=$row['PAREJA2_ID']?>&campeonato_ID=<?=$this->campeonato_ID?>"><?php echo $row['PAREJA2_ID']?></a>
										</td>
										<?php if( $row['RESULTADO'] <> null){ ?>
											<td style="text-align: center;"><?php echo $row['RESULTADO']?></td>
										<?php }else{ ?>
											<td style="text-align: center; color: red" >No jugado</td>
										<?php } ?>
										
							</tr>
				<?php
						}//fin del while
						}
						else{
				?>
						<p style="text-align: center; color: red">Aún no se ha jugado ningún partido de esta fase en este grupo</p>
				<?php
						}
					}//fin del if
				?>
						</tbody>
					</table>


	<?php
    	}  

    	function render_cuartos(){
    ?>
    	<div class="row">
			<div class="col-12">
			    	<section class="box">
			    		<?php if (mysqli_num_rows($this->categoria_fet) == 0) {
			    			}
			    		if($row_cat = mysqli_fetch_array($this->categoria_fet) ){
			    			$genero = $row_cat['GENERO'];
			    			$nivel = $row_cat['NIVEL'];
			    			if($row_gru = mysqli_fetch_array($this->grupo)){
			    				$this->grupo_id = $row_gru['ID'];
			    		?>
			    		<h2><?php echo $this->campeonato." : ".$nivel." ".$genero." - Grupo ".$row_gru['NOMBRE'] ?></h2>
			    		<p>Etapa actual: <b><u>CUARTOS DE FINAL</b></u></p>
			    		<?php }} ?>
    				<div class="table-wrapper">
    					<?php $this->tabla_cuartos() ?>
    				</div>
    			</section>
    		</div>
    	</div>
    <?php	
    	}	
    //Función para pintar tabla fase semis	
    	function render_Ssemis(){
    ?>
    	<div class="row">
			<div class="col-12">
			    	<section class="box">
			    		<?php if (mysqli_num_rows($this->categoria_fet) == 0) {
			    			}
			    		if($row_cat = mysqli_fetch_array($this->categoria_fet) ){
			    			$genero = $row_cat['GENERO'];
			    			$nivel = $row_cat['NIVEL'];
			    			if($row_gru = mysqli_fetch_array($this->grupo)){
			    				$this->grupo_id = $row_gru['ID'];
			    		?>
			    		<h2><?php echo $this->campeonato." : ".$nivel." ".$genero." - Grupo ".$row_gru['NOMBRE'] ?></h2>
			    		<p>Etapa actual: <b><u>SEMIFINAL</b></u></p>
			    		<?php }} ?>
    				<div class="table-wrapper">
    					<?php $this->tabla_semis() ?>
    				</div>
    			</section>
    		</div>
    	</div>
    <?php	
    	}
    //Función para pintar tabla fase final	
    	function render_final(){
    ?>
    	<div class="row">
			<div class="col-12">
			    	<section class="box">
			    		<?php if (mysqli_num_rows($this->categoria_fet) == 0) {
			    			}
			    		if($row_cat = mysqli_fetch_array($this->categoria_fet) ){
			    			$genero = $row_cat['GENERO'];
			    			$nivel = $row_cat['NIVEL'];
			    			if($row_gru = mysqli_fetch_array($this->grupo)){
			    				$this->grupo_id = $row_gru['ID'];
			    		?>
			    		<h2><?php echo $this->campeonato." : ".$nivel." ".$genero." - Grupo ".$row_gru['NOMBRE'] ?></h2>
			    		<p>Etapa actual: <b><u>FINAL</b></u></p>
			    		<?php }} ?>
    				<div class="table-wrapper">
    					<?php $this->tabla_final() ?>
    				</div>
    			</section>
    		</div>
    	</div>
    <?php	
    	}

    } //fin class
    
    ?>