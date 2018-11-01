<?php

class Login{


	function __construct(){	
		$this->render();
	}


function render(){

    include '../Views/HEADERBLACK_View.php'; 
?>

    <!-- Main -->
    <section id="main" class="container medium">
        <header>
            <h2>Iniciar sesión</h2>
        </header>
        <div class="box">
            <form method="post" action="#">
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-12">
                        <input type="text"  id="subject" value="" placeholder="Usuario" name="login" />
                    </div>
                    <div class="col-12">
                        <input type="password" id="message" placeholder="Contraseña" name="password"></input>
                    </div>
                    <div class="col-12">
                        <ul class="actions special">
                            <li><a href="../Controllers/LOGIN_Controller.php"><input type="submit" value="Acceder" /></a></li>
                        </ul>
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