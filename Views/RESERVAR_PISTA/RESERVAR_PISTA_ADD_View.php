<?php

class RESERVAR_PISTA_ADD{
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
	   <h2>Reservar Pista</h2>
	    <p>Elige la pista que quieres reservar</p>
	 </header>
				<div class="table-wrapper">
	    			<p>Reserva para el día <?=$this->fecha?> de <?=$this->hora_inicio[0].":".$this->hora_inicio[1]?> a <?=$this->hora_fin[0].":".$this->hora_fin[1]?></p>

					<table>
						<thead >
							<tr>
								<th>Nombre</th>
								<th>Tipo</th>
							</tr>
						</thead>
						<tbody>
					<?php
					if ( ($this->pistas <> NULL) ){
						foreach ($this->pistas as $key => $value) {
						?>
							<form method="post" action="../Controllers/RESERVAR_PISTA_Controller.php?action=ADD">
								<tr>
									<td>
										<?=$value[0]?>
									</td>
									<td>
										<?=$value[1]?>
									</td>
									<td><input class="oculto" name="pista_ID" readonly value="<?=$key?>">
										<input type="submit" class="small" value="Seleccionar">
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
