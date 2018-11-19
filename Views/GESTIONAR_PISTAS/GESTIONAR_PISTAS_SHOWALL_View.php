<?php
class GESTIONAR_PISTAS{
	var $pistas;

	function __construct($pistas,$origen){
		$this->pistas = $pistas;
		$this->render();
	}

function render(){
    include '../Views/HEADER_View.php';
?>
	<section id="main" class="container">
	<header>
	   <h2>Gestión de Pistas</h2>
	    <p>Gestiona las pistas disponibles en el club</p>
	 </header>
				<div class="table-wrapper">
					<table>
						<thead >
							<tr>
								<th>Nombre</th>
								<th>Tipo</th>
								<th><a class="button small" href="../Controllers/GESTIONAR_PISTAS_Controller.php?action=ADD">Nueva Pista</a></th>
							</tr>
						</thead>
						<tbody>
					<?php
						if($this->pistas <> NULL){
							while($row = mysqli_fetch_array($this->pistas)){
					?>
							<tr>
								<td>
									<?=$row['NOMBRE']?>
								</td>
								<td>
									<?=$row['TIPO']?>
								</td>
								<td>
									<a class="button small" href="../Controllers/GESTIONAR_PISTAS_Controller.php?action=DELETE&pista_ID=<?=$row['ID']?>">Borrar</a>
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
