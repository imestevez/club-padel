<?php

class PROMOCIONAR_PARTIDOS_ADD{
	var $pistas;
	var $fecha;
	var $horario;

	function __construct($pistas,$fecha,$horario){	
		$this->pistas = $pistas;
		$this->fecha = $fecha;
		$this->horario = mysqli_fetch_array($horario);
		$this->hora_inicio = explode(":", $this->horario["HORA_INICIO"]);
		$this->hora_fin = explode(":", $this->horario["HORA_FIN"]);

		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 

?>

    <!-- Main -->
	<section id="main" class="container medium">
	<header>
	   <h2>Promocionar Partido</h2>
	    <p>Elige la pista en la que quieres promocionar el partido</p>
	 </header>
				<div class="table-wrapper">
	    			<p>Partido para el día <?=$this->fecha?> de <?=$this->hora_inicio[0].":".$this->hora_inicio[1]?> a <?=$this->hora_fin[0].":".$this->hora_fin[1]?></p>

					<table>
						<thead >
							<tr>
								<th>Pista</th>
								<th>Nombre</th>
								<th>Tipo</th>					
							</tr>
						</thead>
						<tbody>
					<?php 
					if ( ($this->pistas <> NULL) ){
						foreach ($this->pistas as $key => $value) {
						?>
							<form method="post" action="../Controllers/PROMOCIONAR_PARTIDOS_Controller.php?action=ADD">
								<tr>
									<td>
										<?=$key?>
									</td>
									<td>
										<?=$value[0]?>
									</td>
									<td>
										<?=$value[1]?>
									</td>
									<td><input class="oculto" name="pista_ID" readonly value="<?=$key?>">
										<input type="submit" class="small" value="Promocionar"></th>
								</tr>
									</td>
								</tr>
								<input class="oculto" name="horario_ID" readonly value="<?=$this->horario['ID']?>">
								<input class="oculto" name="fecha" readonly value="<?=$this->fecha?>">
							</form>	
						<?php
						}	// fin foreach
					} //fin if
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