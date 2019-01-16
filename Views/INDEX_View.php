<?php

class Index {
    var $noticias;
	function __construct($noticias){
        $this->noticias = $noticias;
		$this->render();
    }

    function render(){
        include_once '../Views/HEADER_View.php';
        include_once '../Functions/Authentication.php';
    ?>

<?php if( IsAuthenticated() && ($this->noticias <> NULL)) {
                $num = 0;
                $num_rows = mysqli_num_rows($this->noticias);
                ?>
            <div id="slides" class="carousel slide ml-auto mr-auto" data-ride="carousel">
              <ul class="carousel-indicators">
                <?php
                $i = 0;
                $active = 'active';
                while( ($i < 3) && ($i<$num_rows)) {
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
                while ( $row = mysqli_fetch_array($this->noticias)) {
                $active = 'active';
                    if($i == 3){
                        break;
                    }
                    $tipo = 'default';
                    if (strpos($row['TITULO'], 'partido') !== false) {
                        $tipo = 'partido';
                    }else{
                         if (strpos($row['TITULO'], 'campeonato') !== false) {
                            $tipo = 'campeonato';
                        }else{
                             if (strpos($row['TITULO'], 'clase') !== false) {
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
                    <div class="carousel-item active">
                      <img src="../Views/images/<?=$lista[0][3]?>?>.jpg" style="width: 100%; height: 60%;">
                      <div class="carousel-caption" style="background-color: black;">
                        <a href="<?=$lista[0][2]?>"><h1 class="display-2"><?=$lista[0][0]?></h1></a>
                        <p><?=$lista[0][1]?></p>
                      </div>
                    </div>
                <?php
                }
                if($num_rows >= 2){
                ?>
                <div class="carousel-item">
                  <img src="../Views/images/<?=$lista[1][3]?>?>.jpg" style="width: 100%; height: 60%;">
                      <div class="carousel-caption" style="background-color: black">

                    <a href="<?=$lista[1][2]?>"><h1 class="display-2"><?=$lista[1][0]?></h1></a>
                    <p><?=$lista[1][1]?></p>
                  </div>
                </div>
                      <?php
                }
                if($num_rows >= 3){
                ?>
                <div class="carousel-item">
                  <img src="../Views/images/<?=$lista[2][3]?>?>.jpg" style="width: 100%; height: 60%;">
                      <div class="carousel-caption" style="background-color: black">
                    <a href="<?=$lista[2][2]?>"><h1 class="display-2"><?=$lista[2][0]?></h1></a>
                    <p><?=$lista[2][1]?></p>
                  </div>
                </div>
                          <?php
                }
                ?>
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
