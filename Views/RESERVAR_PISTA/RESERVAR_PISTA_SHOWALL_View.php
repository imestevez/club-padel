<?php

class SHOW_RESERVAS{
	var $tuplas;

	function __construct($tuplas){
		$this->tuplas = $tuplas;
		$this->render(); // ---- CONTINUAR -----
	}

	function render(){
		include '../Views/HEADER_View.php';
		?>
		<section id="main" class="container">
			<header>
				<?php
				if($_SESSION["rol"] == 'ADMIN'){
					?>
					<h2>Todas las Reservas</h2>
					<?php
				}
				else {
					?>
					<h2>Tus Reservas</h2>
					<?php
				}
				?>

				<p>Consulta las reservas realizadas</p>
			</header>
			<div class="table-wrapper">
				<table>
					<thead >
						<tr>
							<th>Pista</th>
							<th>Tipo</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if($this->tuplas <> NULL){
							while($row = mysqli_fetch_array($this->tuplas)){
								?>
								<tr>
									<td>
										<?=$row['NOMBRE']?>
									</td>
									<td>
										<?=$row['TIPO']?>
									</td>
									<td>
										<a class="button small" href="../Controllers/RESERVAR_PISTA_Controller.php?action=SHOW_RESERVAS_PISTA&pista_ID=<?=$row['ID']?>">Ver reservas</a>

									</td>

								</tr>
								<?php
							}
						}
						?>
					</tbody>
				</table>
			</div>
		</section>
		<?php
		include '../Views/FOOTER_View.php';
	}

	function checkFecha($fecha, $hora_inicio){

		$fecha_split = explode('-', $fecha);
		$ano = $fecha_split[0];
		$mes = $fecha_split[1];
		$dia = $fecha_split[2];

		$hora_split = explode(':', $hora_inicio);
		$hora = $hora_split[0];
		$min = $hora_split[1];
		
		$fecha_obj = new DateTime(date('Y-m-d H:i:s', mktime($hora,$min, 0, $mes, $dia,$ano))); //fecha del recordset
		$fecha_hoy = new DateTime(date('Y-m-d H:i:s'));
		/*$result_obj = $fecha_obj->format('Y-m-d H:i:s');
		$result_hoy = $fecha_hoy->format('Y-m-d H:i:s');*/

		$diff_horas = $fecha_hoy->diff($fecha_obj); //diferencia entre fechas
		$out = $diff_horas->format("%d,%H,%i");//dias-horas-minutos
		
		$split_dias = explode(',', $out);
		$dias = $split_dias[0];
		$horas = $split_dias[1];
		$minutos = $split_dias[2];


		if($dias > 0){
			return true;
		}else{
			if($horas >= 12){
				return true;
			}
	 		return false;
		}
	 return false;
	}
}
?>
