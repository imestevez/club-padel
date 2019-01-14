<?php
class NOTICIA_ADD{
	var $id;
	var $titulo;
	var $descripcion;
	var $link;

	function __construct(){
		$this->render();
	}

	function render(){
		include '../Views/HEADER_View.php';
		?>
		<section id="main" class="container medium">
			<header>
				<h2>Nueva Noticia</h2>
				<p>Introduce la información de la nueva noticia</p>
			</header>
			<div class="table-wrapper">
				<table>
					<tbody>
								<form method="post" action="../Controllers/NOTICIAS_Controller.php?action=ADD">
									<tr>
										<td>
											<input type="text" value="" placeholder="Titulo" id="titulo" name="titulo" />
										</td>
										<td>
											<input type="text" value="" placeholder="Descripcion" id="descripcion" name="descripcion" />
										</td>
										<td>
											<input type="text" value="" placeholder="Enlace" id="link" name="link" />
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
