<?php
session_start();

include '../Models/PISTA_Model.php';
include '../Views/GESTIONAR_PISTAS/GESTIONAR_PISTAS_SHOWALL_View.php';
include '../Views/GESTIONAR_PISTAS/GESTIONAR_PISTAS_ADD_View.php';
include '../Views/MESSAGE_View.php';

function get_data_form(){
  if(isset( $_REQUEST['id'])){
    $id = $_REQUEST['id'];
  }else{
    $id = NULL;
  }
  if(isset( $_REQUEST['nombre'])){
    $nombre = $_REQUEST['nombre'];
  }else{
    $nombre = NULL;
  }
  if(isset( $_REQUEST['tipo'])){
    $tipo = $_REQUEST['tipo'];
  }else{
    $tipo = NULL;
  }
  $PISTA = new PISTA_Model($id,$nombre,$tipo);
  return $PISTA;
}

if(isset($_REQUEST["action"]))  {
  $action = $_REQUEST["action"];
}else{
  $action = '';
}
switch ($action) {

  case 'ADD':
  if (!$_POST){
    new GESTIONAR_PISTAS_ADD();
  }
  else{
    $PISTA = get_data_form();
    $mensaje = $PISTA->ADD();
    $users = new MESSAGE($mensaje, '../Controllers/GESTIONAR_PISTAS_Controller.php');
  }
  break;

  case 'DELETE':
  $PISTA = new PISTA_Model($_REQUEST["pista_ID"], '', '');
  $mensaje = $PISTA->DELETE();
  $pistas = new MESSAGE($mensaje, '../Controllers/GESTIONAR_PISTAS_Controller.php');
  break;

  default:
  $PISTA = new PISTA_Model('','','');
  $pistas = $PISTA->SHOWALL();
  new GESTIONAR_PISTAS($pistas, '../Controllers/GESTIONAR_PISTAS_Controller.php');
  break;
}
?>
