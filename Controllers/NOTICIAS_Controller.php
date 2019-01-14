<?php
session_start();

include '../Models/NOTICIA_Model.php';
include '../Views/NOTICIAS/NOTICIAS_SHOWALL_View.php';
include '../Views/NOTICIAS/NOTICIAS_ADD_View.php';
include '../Views/MESSAGE_View.php';

function get_data_form(){
  if(isset( $_REQUEST['id'])){
    $id = $_REQUEST['id'];
  }else{
    $id = NULL;
  }
  if(isset( $_REQUEST['titulo'])){
    $titulo = $_REQUEST['titulo'];
  }else{
    $titulo = NULL;
  }
  if(isset( $_REQUEST['descripcion'])){
    $descripcion = $_REQUEST['descripcion'];
  }else{
    $descripcion = NULL;
  }
  if(isset( $_REQUEST['link'])){
    $link = $_REQUEST['link'];
  }else{
    $link = NULL;
  }
  $NOTICIA = new NOTICIA_Model($id,$titulo,$descripcion,$link);
  return $NOTICIA;
}

if(isset($_REQUEST["action"]))  {
  $action = $_REQUEST["action"];
}else{
  $action = '';
}
switch ($action) {
  case 'ADD':
  if (!$_POST){
    new NOTICIA_ADD();
  }
  else{
    $NOTICIA = get_data_form();
    $mensaje = $NOTICIA->ADD();
    $users = new MESSAGE($mensaje, '../Controllers/NOTICIAS_Controller.php');
  }
  break;

  case 'DELETE':
  $NOTICIA = new NOTICIA_Model($_REQUEST["noticia_ID"], '', '','');
  $mensaje = $NOTICIA->DELETE();
  $noticias = new MESSAGE($mensaje, '../Controllers/NOTICIAS_Controller.php');
  break;

  default:
  $NOTICIA = new NOTICIA_Model('','','','');
  $noticias = $NOTICIA->SHOWALL();
  new GESTIONAR_NOTICIAS($noticias, '../Controllers/NOTICIAS_Controller.php');
  break;
}
?>
