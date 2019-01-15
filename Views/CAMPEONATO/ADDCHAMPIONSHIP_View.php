<?php

class ChampionshipAdd{
    var $categorias;

	function __construct($categorias){	
        $this->categorias = $categorias;
		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 
?>
    
    <!-- Main -->
    <section id="main" class="container medium">
        <header>
            <h2>Crear nuevo campeonato</h2>
        </header>
        <div class="box">
            <form method="post" action="../Controllers/CAMPEONATO_Controller.php">
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-12">
                        <label>Nombre
                        <input type="text" value="" placeholder="Nombre" id="nombre" name="nombre" />
                        </label>
                    </div>
                    <div class="col-12">
                        <label>Fecha<br>
                        <input type="date" name="fecha"  id="fecha" size="10"  >   
                        </label>
                        
                    </div>

                    <div class="col-12">
                        <label>Categoría/s
                            <br>
                            <?php 
                                while ( $row = mysqli_fetch_array($this->categorias)) {        
                            ?>
                                <input type="checkbox" name="categorias[]"  value=<?php echo $row['ID'] ?>  id=<?php echo $row['ID'] ?>  />
                                <label for=<?php echo $row['ID'] ?>><?php echo $row['NIVEL']." ".$row['GENERO']?></label><br>
                            <?php
                                }
                            ?>
                        </label>
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