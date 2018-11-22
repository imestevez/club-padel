<?php

class INSCRITOS_PARTIDO{
	var $inscritos;

	function __construct($inscritos){	
		$this->inscritos = $inscritos;
		//$this->render();
	}


function render(){

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
						if($this->inscritos <> NULL){
							while($row = mysqli_fetch_array($this->inscritos)){
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
                            <li><a class="button small" href="../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php">Volver</a>
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
						if($this->inscritos <> NULL){
							while($row = mysqli_fetch_array($this->inscritos)){
								$hoy = date('Y-m-d');
								$baja = true;
								if($hoy > $row['FECHA']){
									$baja = false;
								}
								$fecha = explode("-", $row['FECHA']);
								$hora_inicio = explode(":", $row["HORA_INICIO"]);
								$hora_fin = explode(":", $row["HORA_FIN"]);
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
							if( ($baja == true) && ($row['INSCRIPCIONES'] < 4) ){
						?>
									<td> <a class="button small" href="../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php?action=DELETE&partido_ID=<?=$row['PARTIDO_ID']?>&usuario_login=<?=$row['LOGIN']?>">Dar de baja</a>
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
                            <li><a class="button small" href="../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php">Volver</a>
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