<?php

class INSCRIBIRSE_PARTIDOS_ADD{
	var $usuarios;
	var $partido_ID;


	function __construct($usuarios,$partido_ID){	
		$this->usuarios = $usuarios;
		$this->partido_ID = $partido_ID;
		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 

?>

    <!-- Main -->
	<section id="main" class="container">
	<header>
	   <h2>Inscribirse Partidos</h2>
	    <p>Inscribete en los partidos promocionados por el club</p>
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
							<form method="post" action="../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php?action=ADD">
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
								<input class="oculto" name="partido_ID" readonly value="<?=$this->partido_ID?>">
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