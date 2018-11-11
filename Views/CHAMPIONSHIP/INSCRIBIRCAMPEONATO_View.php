<?php

class InscribirCampeonato{


	function __construct(){	
		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 
?>
    
    <!-- Main -->
    <section id="main" class="container medium">
        <header>
            <h2>Inscripción en el campeonato </h2>

        </header>
        <div class="box">
            <form method="post" action="../Controllers/USERCHAMPIONSHIP_Controller.php">
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-12">
                        <input type="hidden" value="<php $_SESSION['login']?>" id="login" name="login" />
                    </div>
                    <div class="col-12">
                        <input type="text" value="" placeholder="Login de la pareja" id="loginPareja" name="loginPareja" />
                    </div>
                    <div class="col-12">
                        <select name="capitan">
                          <option value="<php $_SESSION['login']?>">Yo</option>
                          <option value="<php $loginPareja ?>">Mi pareja</option>
                        </select> 
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