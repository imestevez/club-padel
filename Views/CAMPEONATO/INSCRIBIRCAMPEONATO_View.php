<?php


class InscribirCampeonato{
    var $campeonato;

    function __construct($campeonato){
        $this->campeonato=$campeonato;
        if(isset($_SESSION["rol"]) && ($_SESSION["rol"] == 'ADMIN')){
            $this->render_admin();
        }else{
            $this->render(); 
        }

    }


function render(){

    include '../Views/HEADER_View.php'; 
?>
    
    <!-- Main -->
    <section id="main" class="container">
        <header>
           <h2>Inscripción</h2>
           <p>Escoge a tu pareja</p>
        </header>
        
        <div class="box">
            <form method="post" action="../Controllers/CAMPEONATOUSUARIO_Controller.php">
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-2">
                        <input type="hidden"   value="<?= $_SESSION['login']?>" id="login" name="login" />
                    </div>
                    <div class="col-5">
                        <input type="text" value="" maxlength="25" placeholder="Login de la pareja" id="loginPareja" name="loginPareja" />
                    </div>
                    <div class="col-2">
                        <input class="oculto" name="campeonato_ID" readonly value="<?= $_REQUEST['campeonato_ID']?>">
                        <input type="submit" class="small" name="action" value="Añadir"  >
                    </div>
                </div>
            </form>
        </div>
    </section>

    <?php
        include '../Views/FOOTER_View.php';
        } //fin metodo render

function render_admin(){

    include '../Views/HEADER_View.php'; 
?>
    
    <!-- Main -->
    <section id="main" class="container">
        <header>
           <h2>Inscripción</h2>
           <p>Inscribe la pareja</p>
        </header>
        
        <div class="box">
            <form method="post" action="../Controllers/CAMPEONATOUSUARIO_Controller.php">
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-5">
                        <input type="text" value="" maxlength="25" placeholder="Login capitan" id="login" name="login" />
                    </div>
                    <div class="col-5">
                        <input type="text" value="" maxlength="25" placeholder="Login de la pareja" id="loginPareja" name="loginPareja" />
                    </div>
                    <div class="col-2">
                        <input class="oculto" name="campeonato_ID" readonly value="<?= $_REQUEST['campeonato_ID']?>">
                        <input type="submit" class="small" name="action" value="Añadir"  >

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