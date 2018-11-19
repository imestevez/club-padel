<?php

class USER_EDIT{
    var $login;
    var $password;
    var $nombre;
    var $apellidos;
    var $genero;
    var $rol_ID;
    var $roles;

	function __construct($user,$roles){
        $user = mysqli_fetch_array($user);

        $this->login = $user['LOGIN'];
        $this->password = $user['PASSWORD'];
        $this->nombre = $user['NOMBRE'];
        $this->apellidos = $user['APELLIDOS'];
        $this->genero = $user['GENERO'];
        $this->rol_ID = $user['ROL_ID'];
        $this->roles = $roles;	
		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 
?>


    <!-- Main -->
    <section id="main" class="container medium">
        <header>
            <h2>Editar Usuarios</h2>
            <p>Edita usuarios del sistema</p>
        </header>
        <div class="box">
            <form method="post" action="../Controllers/USER_Controller.php?action=EDIT">
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-12">
                        <input type="text"  id="subject" value="<?=$this->login?>" placeholder="Usuario" name="login" readonly />
                    </div>
                    <div class="col-12">
                        <input type="password" id="message" value="<?=$this->password?>" placeholder="Contraseña" name="password" required />
                    </div>
                    <div class="col-12">
                        <input type="text"  id="subject" value="<?=$this->nombre?>" placeholder="Nombre" name="nombre"  required />
                    </div>
                    <div class="col-12">
                        <input type="text"  id="subject" value="<?=$this->apellidos?>" placeholder="Apellidos" name="apellidos"  required />
                    </div>

                    <div class="col-12">
                        <select name="genero" >
                          <option value="Mujer" <?php if($this->genero == 'Mujer') { ?> selected <?php }?> >Mujer</option>
                          <option value="Hombre" <?php if($this->genero == 'Hombre'){ ?> selected <?php }?> >Hombre</option>
                        </select> 
                    </div>

                    <div class="col-12">
                        <select name="rol_ID" >
                            <option value="">- ELIJA ROL</option>
                        <?php

                            if($this->roles <> NULL){
                                while ($row = mysqli_fetch_array($this->roles)) {
                            ?>
                                    <option value="<?=$row["ID"]?>" <?php if($this->rol_ID == $row["ID"]) { ?> selected <?php }?> ><?=$row["NOMBRE"]?></option>
                            <?php  
                                }
                            }
                         ?>
                        </select> 
                    </div>
                    
                    <div class="col-12">
                        <ul class="actions special">
                            <li><a href="../Controllers/USER_Controller.php"><input type="submit" value="Continuar" ></a></li>
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