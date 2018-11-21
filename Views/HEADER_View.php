<?php
include_once '../Functions/Authentication.php';
include '../Locales/Strings_SPANISH.php';

?>
<html>
<head>
  <title>SóloPádelPro - By ABP_41</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="stylesheet" href="../assets/css/main.css" />
  <link rel="stylesheet" type="text/css" href="../assets/css/tcal.css" />

  <script type="text/javascript" src="../assets/js/tcal.js"></script>
</head>
<body class="is-preload">
  <div id="page-wrapper">
    <!-- Header -->
    <header id="header">
      <h1><a href="../index.php">SóloPádelPro</a> By ABP_41</h1>
      <nav id="nav">
        <ul>
          <li><a href="../index.php">Inicio</a></li>
          <li>
            <?php
            if(IsAuthenticated()){
              ?>
              <a href="#" class="icon fa-angle-down">Gestionar Reservas</a>
              <ul>
                <?php
                if($_SESSION["rol"] == 'ADMIN'){
                  ?>
                  <li><a href="../Controllers/RESERVAR_PISTA_Controller.php?action=SHOW_RESERVAS">Ver Reservas</a></li>
                  <?php
                }
                else {
                  ?>
                  <li><a href="../Controllers/RESERVAR_PISTA_Controller.php?action=SHOW_RESERVAS">Tus Reservas</a></li>
                  <?php
                }
                ?>
                <li><a href="../Controllers/RESERVAR_PISTA_Controller.php">Reservar</a></li>
              </ul>
            </li>
            <?php //???
            if(isset($_SESSION["rol"]) && ($_SESSION["rol"] == 'ADMIN')){
              ?>
              <li>
                <a href="#" class="icon fa-angle-down">Gestionar Pistas y Horarios</a>
                <ul>
                  <li><a href="../Controllers/GESTIONAR_PISTAS_Controller.php">Gestionar Pistas</a></li>
                  <li><a href="../Controllers/HORARIO_Controller.php">Gestionar Horarios</a></li>
                </ul>
              </li>
              <?php
            }
            ?>
            <?php
            if(isset($_SESSION["rol"]) && ($_SESSION["rol"] == 'ADMIN')){
              ?>
              <li><a href="../Controllers/USER_Controller.php">Gestionar Usuarios</a></li>
              <?php
            }
            ?>
            <li>
              <a class="icon fa-angle-down">Gestionar Campeonatos</a>
              <ul>
                <li><a href="../Controllers/CLASIFICACION_Controller.php?action=SHOW">Rankings</a></li>
                <li>
                  <a>Gest. de Campeonatos</a>
                  <ul>
                    <li><a href="../Controllers/CAMPEONATOUSUARIO_Controller.php?action=CAMPEONATOUSUARIO">Tus Campeonatos</a></li>
                    <li><a href="../Controllers/CAMPEONATOUSUARIO_Controller.php?action=CAMPEONATOSABIERTOS">Campeonatos abiertos</a></li>
                    <?php
                    if(isset($_SESSION["rol"]) && ($_SESSION["rol"] == 'ADMIN')){
                      ?>
                      <li><a href="../Controllers/CAMPEONATO_Controller.php?action=CAMPEONATOSCERRADOS">Campeonatos cerrados</a></li>
                      <?php
                    }
                    ?>
                  </ul>
                </li>
                <li>
                  <a>Gest. de enfrentamientos</a>
                  <ul>
                    <?php
                    if(isset($_SESSION["rol"]) && ($_SESSION["rol"] == 'ADMIN')){
                    ?>
                    <li><a href="../Controllers/ENFRENTAMIENTO_Controller.php?action=SHOW" > Introducir resultados </a></li>
                    <?php
                    }
                    ?>
                    <li><a href="../Controllers/ENFRENTAMIENTO_Controller.php?action=SHOWPROXIMOS" > Próximos</a></li>
                    <?php
                    if(isset($_SESSION["rol"]) && ($_SESSION["rol"] == 'DEPORTISTA')){
                      ?>
                      <li><a href="../Controllers/ENFRENTAMIENTO_Controller.php?action=GESHORARIOS" >Establecer horarios</a></li>
                      <?php
                    }
                    ?>
                  </ul>
                </li>
              </ul>
            </li>
            
            <li>
              <a href="#" class="icon fa-angle-down">Gestionar Partidos</a>
              <ul>
                <li>
                  <a>Inscripciones</a>
                  <ul>
                    <li><a href="../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php">Ver Inscripciones</a></li>
                    <li><a href="../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php?action=SHOW_PARTIDOS">Inscribirte</a></li>
                  </ul>
                </li>
                
                <?php
                if(isset($_SESSION["rol"]) && ($_SESSION["rol"] == 'ADMIN')){
                  ?>
                  <li><a href="../Controllers/PROMOCIONAR_PARTIDOS_Controller.php">Promocionar Partidos</a></li>
                  <?php
                }
                ?>

              </ul>
            </li>
            <li><a href="#" class="class="icon fa-angle-down >
              <input type="image" id="login" src="../Views/images/avatar.png">
            </a>
            <ul>
              <li><a href="#" ><?=$_SESSION["login"]?></a>
              </li>
            </ul>

          </li>
          <li>
            <a href="../Functions/Desconectar.php" class="button">Cerrar sesión</a>
            <?php
          }
          else{
            ?>
            <a href="../Controllers/LOGIN_Controller.php" class="button">Acceder</a>
          </li>
          <li>
            <a href="../Controllers/REGISTER_Controller.php" class="button">Registrarse</a>
            <?php
          }
          ?>
        </li>
      </ul>
    </nav>
  </header>
