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
										<a class="button small" href="../Controllers/RESERVAR_PISTA_Controller.php?action=DELETE&reserva_ID=<?=$row['ID']?>">Borrar</a>
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
}
?>
