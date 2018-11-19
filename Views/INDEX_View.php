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
            <p>Administra los servicios de tu club de pádel preferido en nuestra web!</p>
            <ul class="actions special">
                <?php
                if(!IsAuthenticated()){
                ?>
								<li><a href="../Controllers/LOGIN_Controller.php" class="button primary">Acceder</a></li>
								<li><a href="../Controllers/REGISTER_Controller.php" class="button">Registrarse</a></li>
                <?php
                }
                ?>
            </ul>
        </section>
    <?php
        include_once '../Views/FOOTER_View.php';
    }

}

?>
