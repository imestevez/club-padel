<?php
class GESTIONAR_NOTICIAS{
	var $noticias;

	function __construct($noticias,$origen){
		$this->noticias = $noticias;
		$this->render();
	}

function render(){
    include '../Views/HEADER_View.php';
?>
	<section id="main" class="container">
	<header>
	   <h2>Noticias</h2>
	    <p>Mantente informado sobre las novedades del club!</p>
	 </header>
				<div class="table-wrapper">
					<table>
						<thead >
							<tr>
								<th>Titulo</th>
								<th>Descripción</th>
								<th>Enlace</th>
								<?php if($_SESSION["rol"] == 'ADMIN'){ ?>
								<td>
									<th><a class="button small" href="../Controllers/NOTICIAS_Controller.php?action=ADD">Nueva Noticia</a></th>
								</td>
							<?php } ?>
							</tr>
						</thead>
						<tbody>
					<?php
						if($this->noticias <> NULL){
							while($row = mysqli_fetch_array($this->noticias)){
					?>
							<tr>
								<td>
									<?=$row['TITULO']?>
								</td>
								<td>
									<?=$row['DESCRIPCION']?>
								</td>

								<?php if($row['LINK'] <> ''){ ?>
									<td>
										<a class="button small" href="<?=$row['LINK']?>">Visitar</a>
									</td>
								<?php } else{ ?>
									<td>
										-
									</td>
								<?php } ?>


								<?php if($_SESSION["rol"] == 'ADMIN'){ ?>
								<td>
									<a class="button small" href="../Controllers/NOTICIAS_Controller.php?action=DELETE&noticia_ID=<?=$row['ID']?>">Borrar</a>
								</td>
							<?php } ?>
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
