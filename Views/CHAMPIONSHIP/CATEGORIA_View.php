<?php


class CATEGORIA{
    var $categorias;

    function __construct($categorias){
        $this->categorias=$categorias;
        $this->render();
    }


function render(){

    include '../Views/HEADER_View.php'; 
?>
    
    <!-- Main -->
    <section id="main" class="container medium">
        <header>
            <h2>Seleccione la categoría</h2>

        </header>
        <div class="box">
            <form method="post" action="../Controllers/CAMPEONATOUSUARIO_Controller.php">
                <div class="row gtr-50 gtr-uniform">

                    <div class="col-12">
                        <input type="text" value="" placeholder="Login de la pareja" id="loginPareja" name="loginPareja" />
                    </div>
                    <div class="col-12">
                        <input class="oculto" name="campeonato_ID" readonly value="<?= $_REQUEST['campeonato_ID']?>">
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