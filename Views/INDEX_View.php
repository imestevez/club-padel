<?php

class Index {
    var $noticias;
    var $max;
	function __construct($noticias){
        $this->noticias = $noticias;
         $this->max = 3;
		$this->render();
    }

    function render(){
        include_once '../Views/HEADER_View.php';
        include_once '../Functions/Authentication.php';
    ?>
            <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css" />

<?php 
    if( IsAuthenticated() && ($this->noticias <> NULL)) {
                $num = 0;
                $num_rows = mysqli_num_rows($this->noticias);
                ?>

            <div id="slides" class="carousel slide ml-auto mr-auto" data-ride="carousel">
              <ul class="carousel-indicators">
                <?php
                $i = 0;
                $active = 'active';
                while( ($i < $this->max) && ($i<$num_rows)) {
                ?>
                    <li data-target="#slides" data-slide-to="<?=$i?>" class="<?=$active?>"></li>
                <?php
                    $active = '';
                    $i++;
                }
                ?>
              </ul>
                <?php
                $i = 0;
                $lista = NULL;
                while ( ($row = mysqli_fetch_array($this->noticias) ) && ($i<$this->max) ) {
                    $tipo = 'default';
                    if ((strpos($row['TITULO'], 'partidos') !== false) || (strpos($row['TITULO'], 'partido') !== false) ) {
                        $tipo = 'partido';
                    }else{
                         if ( (strpos($row['TITULO'], 'campeonatos') !== false) || (strpos($row['TITULO'], 'campeonato') !== false) ){
                            $tipo = 'campeonato';
                        }else{
                             if( ((strpos($row['TITULO'], 'clases') !== false)) || (strpos($row['TITULO'], 'clase') !== false) ){
                                $tipo = 'clase';
                            }
                        }
                    }
                $lista[$i] =  array($row['TITULO'], $row['DESCRIPCION'],$row['LINK'],$tipo);
                $i++;
            }
            ?>
                <div class="carousel-inner">
                <?php
                    if($num_rows >= 1){
                        ?>
                         <div  class="carousel-item active">
                            <img src="../Views/images/<?=$lista[0][3]?>?>.jpg" style="width: 100%; height: 50%; opacity: 0.8;">
                        <div class="my_carousel_div">
                        <a href="<?=$lista[0][2]?>"><B><h1 style="color: white" class="display-2"><?=$lista[0][0]?></h1></B></a>
                        <p style="color: white"><?=$lista[0][1]?></p>
                    </div>
                </div>
                <?php
                }
                if($num_rows >= 2){
                ?>
                <div  class="carousel-item">
                  <img src="../Views/images/<?=$lista[1][3]?>?>.jpg" style="width: 100%; height: 50%; opacity: 0.8;">
                     <div class="my_carousel_div">
                    <a href="<?=$lista[1][2]?>"><B><h1 style="color: white" class="display-2"><?=$lista[1][0]?></h1></B></a>
                    <p style="color: white"><?=$lista[1][1]?></p>
                  </div>
                </div>
                      <?php
                }
                if($num_rows >= 3){
                ?>
                <div  class="carousel-item">
                  <img src="../Views/images/<?=$lista[2][3]?>?>.jpg" style="width: 100%; height: 50%; opacity: 0.8;">
                     <div class="my_carousel_div">
                    <a href="<?=$lista[2][2]?>"><B><h1 style="color: white" class="display-2"><?=$lista[2][0]?></h1></B></a>
                    <p style="color: white"><?=$lista[2][1]?></p>
                  </div>
                </div>
                          <?php
                }
                ?>
                  <a class="carousel-control-prev" href="#slides" role="button" data-slide="prev">
                 <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                 </a>
              <a class="carousel-control-next" href="#slides" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
                </div>
            </div>
        <?php
        }
        if(IsAuthenticated()){
        ?>
            <section id="main" class="container">
        <?php
        }else{
        ?>
            <section id="banner">
        <?php
        }
        ?>
            <h2 style="align-content: center;">SóloPádelPro</h2>
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
