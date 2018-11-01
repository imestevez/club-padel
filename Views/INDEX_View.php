<?php

class Index {

	function __construct(){
		$this->render();
    }
    
    function render(){
        include_once '../Views/HEADER_View.php';
        include_once '../Functions/Authentication.php';
    ?>

        <section id="banner">
            <h2>SóloPádelPro</h2>
            <p>Administra los servicios de tu club de pádel preferido ahora</p>
            <ul class="actions special">
                <li><a href="../Controllers/LOGIN_Controller.php" class="button primary">Acceder</a></li>
                <?php
                if(IsAuthenticated()){
                ?>    
                    <li><a href="../Functions/Desconectar.php" class="button">Desconectarse</a></li>
                <?php
                }else{
                ?>    
                    <li><a href="../Controllers/REGISTER_Controller.php" class="button">Registrarse</a></li>
                <?php    
                }
                ?>
            </ul>
        </section>
        <!--<section id="cta">

            <h2>Sign up for beta access</h2>
            <p>Blandit varius ut praesent nascetur eu penatibus nisi risus faucibus nunc.</p>

            <form>
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-8 col-12-mobilep">
                        <input type="email" name="email" id="email" placeholder="Email Address" />
                    </div>
                    <div class="col-4 col-12-mobilep">
                        <input type="submit" value="Sign Up" class="fit" />
                    </div>
                    
                </div>
            </form>

        </section>-->

    <?php
        include_once '../Views/FOOTER_View.php';
    }

}    

?>