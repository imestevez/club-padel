<?php
class RANKING{
	var $campeonato;
	var $clasificaciones;

	function __construct($campeonato,$clasificaciones){
		$this->campeonato = $campeonato;
		$this->clasificaciones = $clasificaciones;
		$this->render();
	}

function render(){
    include '../Views/HEADER_View.php';
?>
	<section id="main" class="container">
	<header>
	   <h2><?= $_REQUEST['nombre']?></h2>
	    <p>Consulta las clasificaciones de los distintos campeonatos</p>
	 </header>
				<div class="table-wrapper">
					<?php
					if($this->clasificaciones <> NULL){
						foreach ($this->clasificaciones as $key => $value) {
					?>
					<p><?=$value[0]?><?=$value[1]?></p>

						<?php
						if($this->clasificaciones <> NULL){
							foreach ($this->clasificaciones as $key => $value) {
						?>
						<p>GRUPO<?=$value[2]?></p>
					<table>
						<thead >
							<tr>
								<th>Puesto</th>
								<th>Pareja</th>
								<th>Puntos</th>
							</tr>
						</thead>
						<tbody>
							<?php
								if($this->clasificaciones <> NULL){
									$i=1;
									foreach ($this->clasificaciones as $key => $value) {
							?>
							<tr>
								<td>
									<?=$i++?>
								</td>
								<td>
									<?=$value[3]?><?=$value[4]?>
								</td>
								<td>
									<?=$value[5]?>
								</td>
							</tr>
							<?php
									}
								}
							?>
						</tbody>
					</table>
					<?php
									}
								}
							}
						}
					?>
				</div>
   		</section>
    <?php
        include '../Views/FOOTER_View.php';
        }
    }
    ?>
