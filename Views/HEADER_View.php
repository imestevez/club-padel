<?php
include_once '../Functions/Authentication.php';
include '../Locales/Strings_SPANISH.php';

?>
<html>
<head>
  <title>SóloPádelPro</title>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css" >

  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="stylesheet" href="../assets/css/main.css" />
  <link rel="stylesheet" type="text/css" href="../assets/css/tcal.css" />
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script type="text/javascript" src="../assets/js/tcal.js"></script>
</head>
<body class="is-preload">
  <div id="page-wrapper">
    <!-- Header -->
    <header id="header">
      <h1><a href="../index.php">SóloPádelPro</a></h1>
      <nav id="nav">
        <ul>
          <li><a href="../index.php">Inicio</a></li>

            <?php
            if(IsAuthenticated()){
              ?>
              <li><a href="../Controllers/NOTICIAS_Controller.php?action=SHOW_NOTICIAS">Noticias</a></li>
              <li>
              <a href="#" class="icon fa-angle-down">Reservas</a>
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
            <?php
            if(isset($_SESSION["rol"]) && ($_SESSION["rol"] == 'ADMIN')){
              ?>
              <li>
                <a href="#" class="icon fa-angle-down">Pistas</a>
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
              <li><a href="../Controllers/USER_Controller.php">Usuarios</a></li>
              <?php
            }
            ?>
            <li>
              <a class="icon fa-angle-down">Campeonatos</a>
              <ul>
                <li><a href="../Controllers/CLASIFICACION_Controller.php?action=SHOW">Rankings</a></li>
                <li>
                  <a>Gest. de Campeonatos</a>
                  <ul>
                    <?php
                    if(isset($_SESSION["rol"]) && ($_SESSION["rol"] == 'DEPORTISTA')){
                      ?>
                    <li><a href="../Controllers/CAMPEONATOUSUARIO_Controller.php?action=CAMPEONATOUSUARIO">Tus Campeonatos</a></li>
                     <?php
                    }
                    ?>
                    <?php
                    if(isset($_SESSION["rol"]) && ($_SESSION["rol"] == 'ADMIN')){
                      ?>
                    <li><a href="../Controllers/CAMPEONATO_Controller.php?action=FORMADD">Crear campeonato</a></li>
                     <?php
                    }
                    ?>
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
                  <a  href="../Controllers/ENFRENTAMIENTO_Controller.php?action" >Gest. de enfrentamientos</a>
                  <ul>
                    <?php
                    if(isset($_SESSION["rol"]) && ($_SESSION["rol"] == 'DEPORTISTA')){
                      ?>
                    <li><a href="../Controllers/ENFRENTAMIENTO_Controller.php?action=GESHORARIOS">Gestionar horarios</a></li>
                    <?php
                    }
                    ?>
                  </ul>
                </li>
              </ul>
            </li>

            <li>
              <a href="#" class="icon fa-angle-down">Partidos</a>
              <ul>
                <li>
                  <a>Inscripciones</a>
                  <ul>
                    <li><a href="../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php">Ver Inscripciones</a></li>
                    <li><a href="../Controllers/INSCRIBIRSE_PARTIDOS_Controller.php?action=SHOW_PARTIDOS">Inscribir</a></li>
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
             <li>
              <a href="#" class="icon fa-angle-down">Clases</a>
              <ul>
                <li>
                  <a>Inscripciones</a>
                  <ul>
                    <li><a href="../Controllers/INSCRIBIRSE_ESCUELA_Controller.php">Ver Inscripciones</a></li>
                    <li><a href="../Controllers/INSCRIBIRSE_ESCUELA_Controller.php?action=SHOW_ESCUELAS">Inscribir</a></li>
                  </ul>
                </li>
                <?php
                if(isset($_SESSION["rol"]) && ($_SESSION["rol"] == 'ADMIN')){
                  ?>
                  <li><a href="../Controllers/ESCUELA_Controller.php">Ver Clases</a></li>
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
            <a href="../Controllers/LOGIN_Controller.php" class="small button">Acceder</a>
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
