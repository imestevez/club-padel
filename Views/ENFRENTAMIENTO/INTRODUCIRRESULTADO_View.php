<?php


class INTRODUCIRRESULTADO{
    var $enfrentamiento;

    function __construct($enfrentamiento){
        $this->enfrentamiento=$enfrentamiento;
        $this->render();
    }


function render(){

    include '../Views/HEADER_View.php'; 
?>
    
    <!-- Main -->
    <section id="main" class="container">
        <header>
           <h2>Resultado del enfrentamiento</h2>
        </header>
        <div class="box col-6">
            <form method="post" action="../Controllers/ENFRENTAMIENTO_Controller.php?action=RESULTADO">
                <div class="row gtr-50 gtr-uniform">
                    <div class="table-wrapper col-4" style="margin-left: 34%">
                        <table>
                            <thead >
                                <tr>
                                    <th>Pareja 1</th>
                                    <th>-</th>
                                    <th>Pareja 2</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                         <input type="number" maxlength="1" min="0" max="7" value="0" placeholder="" id="resultado" name="set1_1" />
                                    </td>
                                    <td>
                                    -
                                    </td>
                                    <td>
                                       <input type="number" maxlength="1" min="0" max="7" value="0" placeholder="" id="resultado" name="set1_2" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                         <input type="number" maxlength="1" min="0" max="7" value="0" placeholder="" id="resultado" name="set2_1" />
                                    </td>
                                    <td>
                                    -
                                    </td>
                                    <td>
                                       <input type="number" maxlength="1" min="0" max="7" value="0" placeholder="" id="resultado" name="set2_2" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                         <input type="number" maxlength="1" min="0" max="7" value="0" placeholder="" id="resultado" name="set3_1" />
                                    </td>
                                    <td>
                                    -
                                    </td>
                                    <td>
                                       <input type="number" maxlength="1" min="0" max="7" value="0" placeholder="" id="resultado" name="set3_2" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-12">
                        <input class="oculto" name="enfrentamiento_ID" readonly value="<?= $this->enfrentamiento?>">
                        <ul class="actions special">
                            <li><input type="submit" class="small" value="Continuar"  > </a></li>
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