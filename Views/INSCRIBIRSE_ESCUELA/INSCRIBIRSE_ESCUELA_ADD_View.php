<?php

class INSCRIBIRSE_ESCUELA_ADD{
	var $usuarios;
	var $escuela_ID;


	function __construct($usuarios,$escuela_ID){	
		$this->usuarios = $usuarios;
		$this->escuela_ID = $escuela_ID;
		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 

?>

    <!-- Main -->
	<section id="main" class="container">
	<header>
	   <h2>Inscribir en Clases</h2>
	    <p>Inscribe a deportistas en las clases de las escuelas deportivas del club</p>
	 </header>
		<div class="table-wrapper">
					<table>
						<thead >
							<tr>
								<th>Login</th>
								<th>Nombre</th>
								<th>Apellidos</th>
							</tr>
						</thead>
						<tbody>

					<?php 
						if($this->usuarios <> NULL){
							foreach ($this->usuarios as $key => $value) {
					?>
							<form method="post" action="../Controllers/INSCRIBIRSE_ESCUELA_Controller.php?action=ADD">
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
									<td><input class="oculto" name="login" readonly value="<?=$key?>">
										<input type="submit" class="small" value="Inscribir">
									</td>
							</tr>
								<input class="oculto" name="escuela_ID" readonly value="<?=$this->escuela_ID?>">
							</form>	
				<?php
						}//fin del foreach
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