<?php

class INSCRITOS_ESCUELA{
	var $escuelas;

	function __construct($escuelas){	
		$this->escuelas = $escuelas;
		//$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 

?>

    <!-- Main -->
	<section id="main" class="container">
	<header>
	   <h2>Inscritos</h2>
	    <p>Consulta los deportistas inscritos en la clase</p>
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
						if($this->escuelas <> NULL){
							while($row = mysqli_fetch_array($this->escuelas)){
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
								
							</tr>
					<?php
							}//fin del while
						}//fin del if
					?>
						</tbody>
					</table>
          				<div class="col-12">
                        <ul class="actions special">
                            <li><a class="button small" href="../Controllers/INSCRIBIRSE_ESCUELA_Controller.php">Volver</a>
                            </li>
                        </ul>
                    </div>
				</div>
   		</section>
    <?php
        include '../Views/FOOTER_View.php';
        } //fin metodo render
      
   function renderAdmin(){

    include '../Views/HEADER_View.php'; 

?>

    <!-- Main -->
	<section id="main" class="container">
	<header>
	   <h2>Tus Inscripciones</h2>
	    <p>Consulta los partidos en los que estas inscrito</p>
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
						if($this->escuelas <> NULL){
							while($row = mysqli_fetch_array($this->escuelas)){
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
														<?php
							if(($row['INSCRIPCIONES'] < 4) ){
						?>
									<td> <a class="button small" href="../Controllers/INSCRIBIRSE_ESCUELA_Controller.php?action=DELETE&escuela_ID=<?=$row['ESCUELA_ID']?>&usuario_login=<?=$row['LOGIN']?>">Dar de baja</a>
									</td>
					<?php
						}
						?>
							</tr>
					<?php
							}//fin del while
						}//fin del if
					?>
						</tbody>
					</table>
          				<div class="col-12">
                        <ul class="actions special">
                            <li><a class="button small" href="../Controllers/INSCRIBIRSE_ESCUELA_Controller.php">Volver</a>
                            </li>
                        </ul>
                    </div>
				</div>
   		</section>
    <?php
        include '../Views/FOOTER_View.php';
        } //fin metodo render
      
    } //fin class
    
    ?>
