<?php

class USER_SHOWALL{
	var $usuarios;

	function __construct($usuarios){
		$this->usuarios = $usuarios;
		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php';

?>

    <!-- Main -->
	<section id="main" class="container">
	<header>
	   <h2>Usuarios Registrados</h2>
	    <p>Consulta los usuarios registrados en el club</p>
	 </header>
				<div class="table-wrapper">
					<table>
						<thead >
							<tr>
								<th>Login</th>
								<th>Nombre</th>
								<th>Apellidos</th>
								<th>Género</th>
								<th>Rol</th>
								<th><a class="button small" href="../Controllers/USER_Controller.php?action=ADD">Registrar</a></th>
							</tr>
						</thead>
						<tbody>
					<?php
						if($this->usuarios <> NULL){
							while($row = mysqli_fetch_array($this->usuarios)){
					?>
							<tr>
								<td>
									<?=$row['LOGIN']?>
								</td>
								<td>
									<?=$row['NOMBRE']?>
								</td>
								<td>
									<?=$row['APELLIDOS']?>
								</td>
								<td>
									<?=$row['GENERO']?>
								</td>
								<td>
									<?=$row['ROL']?>
								</td>
								<td>
									<a class="button small" href="../Controllers/USER_Controller.php?action=EDIT&login=<?=$row['LOGIN']?>">Editar</a>

									<a class="button small" href="../Controllers/USER_Controller.php?action=DELETE&login=<?=$row['LOGIN']?>">Borrar</a>
								</td>
							</tr>
				<?php
						}//fin del while
					}//fin del if
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
