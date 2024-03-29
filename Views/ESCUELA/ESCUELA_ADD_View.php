<?php

class ESCUELA_ADD{
    var $horarios;
    var $pistas;

	function __construct($horarios,$pistas){	

        $this->horarios = $horarios;
        $this->pistas = $pistas;

		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 
?>
    
    <!-- Main -->
    <section id="main" class="container medium">
        <header>
            <h2>Añadir Clase de la Escuela Deportiva</h2>
            <p>Crea una nueva clase de Escuela Deportiva del club</p>
        </header>
        <div class="box">
            <form method="post" action="../Controllers/ESCUELA_Controller.php?action=ADD">
                <div class="row gtr-100 gtr-uniform">
                    <div class="col-12">
                        <input type="text" required maxlength="50" value="" placeholder="Nombre" id="nombre" name="nombre" />
                    </div>
                     <div class="col-3">
                       <select name="dia" class="col-3">
                            <option value="Monday"> Lunes </option>
                            <option value="Tuesday"> Martes </option>
                            <option value="Wednesday"> Miercoles </option>
                            <option value="Thursday"> Jueves </option>
                            <option value="Friday"> Viernes </option>
                            <option value="Saturday"> Sabado </option>
                            <option value="Sunday"> Domingo </option>
                        </select>
                    </div>
                    <div class="col-4">
                       <select name="horario_ID" class="col-4">
                        <?php 
                            if( ($this->horarios <> NULL) &&  (!is_string($this->horarios))) {
                                while($row = mysqli_fetch_array($this->horarios)){
                                    $hora_inicio = explode(":", $row["HORA_INICIO"]);
                                    $hora_fin = explode(":", $row["HORA_FIN"]);
                        ?>
                                    <option value="<?=$row['ID']?>"><?=$hora_inicio[0]?>:<?=$hora_inicio[1]?> - <?=$hora_fin[0]?>:<?=$hora_fin[1]?></option>
                        <?php
                                }//fin del while
                            }//fin del if
                        ?>  
                        </select>
                    </div>
                    <div class="col-3">
                       <select name="pista_ID" class="col-3">
                        <?php 
                            if( ($this->pistas <> NULL) &&  ( !is_string($this->pistas))) {
                                while($row = mysqli_fetch_array($this->pistas)) {
                        ?>
                                    <option value="<?=$row['ID']?>"><?=$row['NOMBRE']?></option>
                        <?php
                                }//fin del while
                            }//fin del if
                        ?>  
                        </select>
                    </div>
                    <div class="col-2">
                          <input type="submit" class="small" value="Añadir">
                    </div>
        </div>

            </form>
                    <ul class="actions special" style="float: right;">
                            <li><a href="../Controllers/ESCUELA_Controller.php" class="button small">Volver</a></li>
                    </ul>
    </section>

    <?php
        include '../Views/FOOTER_View.php';
        } //fin metodo render
    
    } //fin Login
    
    ?>