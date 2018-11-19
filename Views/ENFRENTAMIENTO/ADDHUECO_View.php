<?php

class AddHueco{

    var $semana;
    var $dias;
    var $horarios;

    var $enfrentamiento_id;
    var $pareja_id;

	function __construct($horarios,$enfrentamiento_id, $pareja_id){
        $this->dias = 7;
        $this->enfrentamiento_id = $enfrentamiento_id;
        $this->pareja_id = $pareja_id;

        $this->semana = array (
                    date("d/m/Y"), 
                    date("d/m/Y",strtotime("+1 day")),
                    date("d/m/Y",strtotime("+2 day")),
                    date("d/m/Y",strtotime("+3 day")),
                    date("d/m/Y",strtotime("+4 day")),
                    date("d/m/Y",strtotime("+5 day")),
                    date("d/m/Y",strtotime("+6 day"))
        );
        $this->horarios = $horarios;

		$this->render();
	}


function render(){

    include '../Views/HEADER_View.php'; 
?>

    <!-- Main -->
    <section id="main" class="container medium">
        <header>
            <h2>Añadir disponibilidad</h2>
        </header>
        <div class="box">
            <form method="post" action="../Controllers/HUECO_Controller.php?action=ADD">
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-12">
                        <label>Fecha
                        <select id="fecha" name="fecha">
                            <?php
                                $i = 0;
                                for ($i=0; $i < $this->dias; $i++) { 
                            ?>
                                    <option value="<?php echo $this->semana[$i] ?>"><?php echo $this->semana[$i] ?></option>
                            <?php
                                }
                            ?>
                            
                        </select>
                        </label>
                    </div>
                    <div class="col-12">
                        <label>Hora
                        <select id="horario_id" name="horario_id">
                            <?php
                            while($rowHorarios = mysqli_fetch_array($this->horarios)){

                            ?><option value="<?php echo $rowHorarios['ID'] ?>">
                                        <?php echo $rowHorarios['HORA_INICIO']." ".$rowHorarios['HORA_FIN'] ?>
                                            </option>
                            <?php
                            }
                            ?>
                            
                        </select>
                        </label>
                    </div>
                    <input type="hidden" name="enfrentamiento_id" value="<?php echo $this->enfrentamiento_id?>">
                    <input type="hidden" name="pareja_id" value="<?php echo $this->pareja_id?>">

                    <div class="col-12">
                        <ul class="actions special">
                            <li><input type="submit" value="Continuar" /></a></li>
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