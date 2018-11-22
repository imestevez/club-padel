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
							<?php
							if($_SESSION["rol"] == 'ADMIN'){
								?>
								<th>Usuario</th>
								<?php
							}
							?>
							<th>Pista</th>
							<th>Fecha</th>
							<th>Hora Inicio</th>
							<th>Hora Fin</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if($this->tuplas <> NULL){
							while($row = mysqli_fetch_array($this->tuplas)){
								$fecha = explode("-", $row['FECHA']);
								$hora_inicio = explode(":", $row["HORA_INICIO"]);
								$hora_fin = explode(":", $row["HORA_FIN"]);
								$eliminar_reserva = false;
								$eliminar_reserva = $this->checkFecha($row['FECHA'], $row["HORA_INICIO"]);
								?>
								<tr>
									<?php
									if($_SESSION["rol"] == 'ADMIN'){
										?>
										<td>
											<?=$row['USUARIO_LOGIN']?>
										</td>
										<?php
									}
									?>
									<td>
										<?=$row['NOMBRE']?>
									</td>
									<td>
										<?=$fecha[2]."/".$fecha[1]."/".$fecha[0]?>
									</td>
									<td>
										<?=$hora_inicio[0].":".$hora_inicio[1]?>
									</td>
									<td>
										<?=$hora_fin[0].":".$hora_fin[1]?>
									</td>
									<td>

								<?php
										if($eliminar_reserva == true){
								?>
										<a class="button small" href="../Controllers/RESERVAR_PISTA_Controller.php?action=DELETE&reserva_ID=<?=$row['ID']?>">Borrar</a>
								<?php
									}
								?>
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
