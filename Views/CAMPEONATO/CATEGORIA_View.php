<?php


class CATEGORIA{
    var $categorias;
    var $pareja_ID;

    function __construct($categorias, $pareja_ID){
        $this->categorias=$categorias;
        $this->pareja_ID=$pareja_ID;        
        $this->render();
    }


function render(){

    include '../Views/HEADER_View.php'; 
?>
    
    <!-- Main -->
     <section id="main" class="container">
        <header>
           <h2>Categoría</h2>
           <p>Seleccione la categoría en la que desea inscribirse</p>
        </header>

        <div class="box">
            <form method="post" action="../Controllers/CAMPEONATOUSUARIO_Controller.php?action=CATEGORIA">
                <div class="row gtr-50 gtr-uniform">

                    
                    <div class="col-3">
                        <input class="oculto" name="pareja_ID" readonly value="<?= $this->pareja_ID?>">
                    </div>
                    <select name="cam_cat_ID" class="col-5">
                        <?php 
                        if( ($this->categorias <> NULL) &&  ( !is_string($this->categorias))) {
                                foreach ($this->categorias as $key => $value) {
                        ?>
                            <option value="<?=$key?>"><?=$value[0]?><?=$value[1]?></option>
                        <?php
                                }//fin del while
                            }//fin del if
                        ?>  
                    </select>


                    <div class="col-2">
                            <input type="submit" class="small" value="Continuar"  >
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