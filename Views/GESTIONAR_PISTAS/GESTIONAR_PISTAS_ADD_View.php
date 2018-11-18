<?php
class GESTIONAR_PISTAS_ADD{
	var $id;
	var $nombre;
	var $tipo;

	function __construct(){
		$this->render();
	}

	function render(){
		include '../Views/HEADER_View.php';
		?>
		<section id="main" class="container medium">
			<header>
				<h2>Nueva Pista</h2>
				<p>Introduce la información de la nueva pista</p>
			</header>
			<div class="table-wrapper">
				<table>
					<tbody>
								<form method="post" action="../Controllers/GESTIONAR_PISTAS_Controller.php?action=ADD">
									<tr>
										<td>
											<input type="text" value="" placeholder="Nombre" id="nombre" name="nombre" />
										</td>
										<td>
											<input type="text" value="" placeholder="Tipo" id="tipo" name="tipo" />
										</td>
										<td>
											<input type="submit" class="small" value="Finalizar">
										</td>
									</tr>
								</form>
					</tbody>
				</table>
			</div>
		</section>
		<?php
		include '../Views/FOOTER_View.php';
	}
}
?>
