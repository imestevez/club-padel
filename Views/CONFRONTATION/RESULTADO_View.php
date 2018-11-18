<?php

class RESULTADO{
	var $enfrentamiento_ID;

	function __construct($enfrentamiento_ID){	
		$this->enfrentamiento_ID = $enfrentamiento_ID;

		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 

?>

    <!-- Main -->
	<section id="main" class="container medium">
	<header>
	   <h2>Resultado</h2>
	    <p>Introduce el resultado del enfrentamiento con el formato: N-N/N-N/N-N </p>
	 </header>
				<div class="box">
					 <form method="post" action="../Controllers/ENFRENTAMIENTO_Controller.php">
		                <div class="row gtr-50 gtr-uniform">
		                    <div class="col-12">
		                        <input type="hidden" value="<?= $_SESSION['login']?>" id="login" name="login" />
		                    </div>
		                    <div class="col-12">
		                        <input type="text" value="" placeholder="X-X/X-X/X-X" id="resultado" name="resultado" />
		                    </div>
		                    <div class="col-12">
		                        <input type="submit" name="action" value="Introduce"  >
		                    </div>
		                </div>
		            </form>
				</div>
   		</section>
    <?php
        include '../Views/FOOTER_View.php';
        } //fin metodo render
    
    } //fin class
    
    ?>