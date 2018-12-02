<?php

class ESCUELA_ADD{


	function __construct(){	
		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 
?>
    
    <!-- Main -->
    <section id="main" class="container medium">
        <header>
            <h2>Añadir Escuela Deportiva</h2>
            <p>Crea una Escuela Deportiva para el club</p>
        </header>
        <div class="box">
            <form method="post" action="../Controllers/ESCUELA_Controller.php">
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-12">
                        <input type="text" value="" placeholder="Nombre" id="nombre" name="nombre" />
                    </div>
                    <div class="col-12">
                        <input type="text" name="fecha" class="tcal" id="fecha" size="10"  >
                    </div>
                    <div class="col-12">
                            <input type="submit" name="action" value="Añadir"  >
                    </div>
                </div>
            </form>
        </div>
    </section>

    <?php
        include '../Views/FOOTER_View.php';
        } //fin metodo render
    
    } //fin Login
    
    ?>