<?php


class INTRODUCIRRESULTADO{
    var $enfrentamiento;

    function __construct($enfrentamiento){
        $this->enfrentamiento=$enfrentamiento;
        $this->render();
    }


function render(){

    include '../Views/HEADER_View.php'; 
?>
    
    <!-- Main -->
    <section id="main" class="container">
        <header>
           <h2>Resultado del enfrentamiento</h2>
        </header>
        
        <div class="box">
            <form method="post" action="../Controllers/ENFRENTAMIENTO_Controller.php">
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-12">
                        <input type="text" value="" placeholder="X-X/X-X/X-X" id="resultado" name="resultado" />
                    </div>
                    <div class="col-12">
                        <input class="oculto" name="enfrentamiento_ID" readonly value="<?= $_REQUEST['enfrentamiento_ID']?>">
                            <input type="submit" name="action" value="RESULTADO"  >
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