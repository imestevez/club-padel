<?php

class Promocionar_Partidos{
	var $today;
	var $semana;

	function __construct(){	
	$this->semana = array (
		array ( 
				date("l"),
				date("d/m/Y")
			),
		array ( 
				date("l",strtotime("+1 day")),
				date("d/m/Y",strtotime("+1 day"))
			),
		array ( 
				date("l",strtotime("+2 day")),
				date("d/m/Y",strtotime("+2 day"))
			),
		array ( 
				date("l",strtotime("+3 day")),
				date("d/m/Y",strtotime("+3 day"))
			),
		array ( 
				date("l",strtotime("+4 day")),
				date("d/m/Y",strtotime("+4 day"))
			),
		array ( 
				date("l",strtotime("+5 day")),
				date("d/m/Y",strtotime("+5 day"))
			),
		array ( 
				date("l",strtotime("+6 day")),
				date("d/m/Y",strtotime("+6 day"))
			),
		array ( 
			date("l",strtotime("+7 day")),
			date("d/m/Y",strtotime("+7 day"))
		)

	);
		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 

?>


    <!-- Main -->
    <section class="box">
        <h3>Promocionar Partidos</h3>
				<div class="table-wrapper">
					<table>
						<thead >
							<tr>
								<th><?=$strings[$this->semana[0][0]]." ".$this->semana[0][1]?></th>
								<th><?=$strings[$this->semana[1][0]]." ".$this->semana[1][1]?></th>
								<th><?=$strings[$this->semana[2][0]]." ".$this->semana[2][1]?></th>
								<th><?=$strings[$this->semana[3][0]]." ".$this->semana[3][1]?></th>
								<th><?=$strings[$this->semana[4][0]]." ".$this->semana[4][1]?></th>
								<th><?=$strings[$this->semana[5][0]]." ".$this->semana[5][1]?></th>
								<th><?=$strings[$this->semana[6][0]]." ".$this->semana[6][1]?></th>
								<th><?=$strings[$this->semana[7][0]]." ".$this->semana[7][1]?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><a href="../Controllers/PROMOCIONAR_PARTIDOS_Controller.php?dia=<?=$this->semana[0]?>&hora=9">9:00</td>
								<td><a href="../Controllers/PROMOCIONAR_PARTIDOS_Controller.php?dia=<?=$this->semana[1]?>&hora=9">9:00</td>
								<td><a href="../Controllers/PROMOCIONAR_PARTIDOS_Controller.php?dia=<?=$this->semana[2]?>&hora=9">9:00</td>
								<td><a href="../Controllers/PROMOCIONAR_PARTIDOS_Controller.php?dia=<?=$this->semana[3]?>&hora=9">9:00</td>
								<td><a href="../Controllers/PROMOCIONAR_PARTIDOS_Controller.php?dia=<?=$this->semana[4]?>&hora=9">9:00</td>
								<td><a href="../Controllers/PROMOCIONAR_PARTIDOS_Controller.php?dia=<?=$this->semana[5]?>&hora=9">9:00</td>
								<td><a href="../Controllers/PROMOCIONAR_PARTIDOS_Controller.php?dia=<?=$this->semana[6]?>&hora=9">9:00</td>
								<td><a href="../Controllers/PROMOCIONAR_PARTIDOS_Controller.php?dia=<?=$this->semana[7]?>&hora=9">9:00</td>
							</tr>
							<tr>
								<td><a href="../Controllers/PROMOCIONAR_PARTIDOS_Controller.php?dia=<?=$this->semana[0]?>&hora=11">11:00</td>
								<td><a href="../Controllers/PROMOCIONAR_PARTIDOS_Controller.php?dia=<?=$this->semana[1]?>&hora=11">11:00</td>
								<td><a href="../Controllers/PROMOCIONAR_PARTIDOS_Controller.php?dia=<?=$this->semana[2]?>&hora=11">11:00</td>
								<td><a href="../Controllers/PROMOCIONAR_PARTIDOS_Controller.php?dia=<?=$this->semana[3]?>&hora=11">11:00</td>
								<td><a href="../Controllers/PROMOCIONAR_PARTIDOS_Controller.php?dia=<?=$this->semana[4]?>&hora=11">11:00</td>
								<td><a href="../Controllers/PROMOCIONAR_PARTIDOS_Controller.php?dia=<?=$this->semana[5]?>&hora=11">11:00</td>
								<td><a href="../Controllers/PROMOCIONAR_PARTIDOS_Controller.php?dia=<?=$this->semana[6]?>&hora=11">11:00</td>
								<td><a href="../Controllers/PROMOCIONAR_PARTIDOS_Controller.php?dia=<?=$this->semana[7]?>&hora=11">11:00</td>
							</tr>					
						</tbody>
					</table>

				</div>
    </section>

    <?php
        include '../Views/FOOTER_View.php';
        } //fin metodo render
    
    } //fin Login
    
    ?>