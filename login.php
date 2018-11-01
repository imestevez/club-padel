<?php

class Login{


	function __construct(){	
		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 
?>

    <!-- Main -->
    <section id="main" class="container medium">
        <header>
            <h2>Iniciar sesión</h2>
        </header>
        <div class="box">
            <form method="post" action="#">
                <div class="row gtr-50 gtr-uniform">
                    <!--<div class="col-6 col-12-mobilep">
									<input type="text" name="name" id="name" value="" placeholder="Name" />
								</div>
								<div class="col-6 col-12-mobilep">
									<input type="email" name="email" id="email" value="" placeholder="Email" />
								</div>-->
                    <div class="col-12">
                        <input type="text" name="login" id="subject" value="" placeholder="Usuario" />
                    </div>
                    <div class="col-12">
                        <input type="password" id="message" placeholder="Contraseña"></input>
                    </div>
                    <div class="col-12">
                        <ul class="actions special">
                            <li><input type="submit" value="Acceder" /></li>
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