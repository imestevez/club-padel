<?php
    session_start();
	include '../Views/INDEX_View.php';
	include_once '../Models/NOTICIA_Model.php';
	$NOTICIA = new NOTICIA_Model('','','','');
	$noticias = $NOTICIA->SHOWALL();
	new Index($noticias); //crea la vista de usuarios autenticados

?>