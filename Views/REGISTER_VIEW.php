<?php

class Register{


	function __construct(){	
		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 
?>


    <!-- Main -->
    <section id="main" class="container medium">
        <header>
            <h2>Registro</h2>
            <p>Registrate en el sistema para disfrutar de los servicios ofrecidos</p>
        </header>
        <div class="box">
            <form method="post" action="../Controllers/REGISTER_Controller.php">
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-12">
                        <input type="text"  id="subject" value="" placeholder="Usuario" name="login"  required />
                    </div>
                    <div class="col-12">
                        <input type="password" id="message" placeholder="Contraseña" name="password" required />
                    </div>
                    <div class="col-12">
                        <input type="text"  id="subject" value="" placeholder="Nombre" name="nombre" required  />
                    </div>
                    <div class="col-12">
                        <input type="text"  id="subject" value="" placeholder="Apellidos" name="apellidos"  required />
                    </div>

                    <div class="col-12">
                        <select name="genero" >
                          <option value="Mujer">Mujer</option>
                          <option value="Hombre">Hombre</option>
                        </select> 
                    </div>
                    
                    <div class="col-12">
                        <ul class="actions special">
                            <li><a href="../Controllers/REGISTER_Controller.php"><input type="submit" value="Continuar" ></a></li>
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