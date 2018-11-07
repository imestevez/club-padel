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
							<li><a href="../index.php">Reservar Pistas</a></li>
							<li>
								<a href="#" class="icon fa-angle-down">Campeonatos</a>
								<ul>
									<li><a href="../Controllers/CHAMPIONSHIP_Controller.php?action=FORMADD">Nuevo Campeonato</a></li>
									<li><a href="../Controllers/USERCHAMPIONSHIP_Controller.php?action=USERCHAMPIONSHIPS">Tus Campeonatos</a></li>
									<li><a href="../Controllers/USERCHAMPIONSHIP_Controller.php?action=OPENCHAMPIONSHIPS">Campeonatos abiertos</a></li>
									<li><a href="#">Rankings</a></li>
								</ul>
							</li>
							<li><a href="../Controllers/PROMOTE_MATCHES_Controller.php">Promocionar Partidos</a></li>
							<li><a href="#" class="button" >
									<input type="image" id="login" src="../Views/images/avatar.png">
								</a>
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