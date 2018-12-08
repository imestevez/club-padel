<?php

session_start();

include '../Models/RESERVA_Model.php';
include '../Models/PARTIDO_Model.php';
include '../Models/PISTA_Model.php';
include '../Models/HORARIO_Model.php';
include '../Views/RESERVAR_PISTA/RESERVAR_PISTA_Horario_View.php';
include '../Views/RESERVAR_PISTA/RESERVAR_PISTA_ADD_View.php';
include '../Views/RESERVAR_PISTA/RESERVAR_PISTA_SHOWALL_View.php';
include '../Views/RESERVAR_PISTA/RESERVAR_PISTA_SHOW_View.php';
include '../Views/MESSAGE_View.php';


function get_data_form(){
  if(isset( $_REQUEST['fecha'])){
    $fecha = $_REQUEST['fecha'];
  }else{
    $fecha = NULL;
  }
  $reserva_ID = NULL;
  if(isset( $_REQUEST['horario_ID'])){
    $horario_ID = $_REQUEST['horario_ID'];
  }else{
    $horario_ID = NULL;
  }
  if(isset( $_REQUEST['pista_ID'])){
    $pista_ID = $_REQUEST['pista_ID'];
  }else{
    $pista_ID = NULL;
  }
  $user_login = $_SESSION['login'];
  $RESERVA = new RESERVA_Model(NULL,$fecha,$user_login,$pista_ID,$horario_ID);
  return $RESERVA;
}


if(isset($_REQUEST["action"]))  {
  $action = $_REQUEST["action"];
}else{
  $action = '';
}
switch ($action) {

  case 'ADD':
    $RESERVA = get_data_form();
    $mensaje = $RESERVA->ADD();
    $users = new MESSAGE($mensaje, '../Controllers/RESERVAR_PISTA_Controller.php?action=SHOW_RESERVAS');
  break;


  case 'SHOW_PISTAS':
  if( (isset($_REQUEST["horario_ID"])) && (isset($_REQUEST["fecha"])) ) {
    $RESERVA = new RESERVA_Model('',$_REQUEST["fecha"], '', '', $_REQUEST["horario_ID"]);
    $pistas_sin_reserva = $RESERVA->SEARCH_PISTAS_LIBRES();
    if(is_string($pistas_sin_reserva)){
      $mensajes = new MESSAGE($pistas_sin_reserva, '../Controllers/RESERVAR_PISTA_Controller.php');
    }else{
      $HORARIO = new HORARIO_Model($_REQUEST["horario_ID"], '', '');
      $horario = $HORARIO->SHOW();
      if(is_string($horario)){
        $mensajes = new MESSAGE($horario, '../Controllers/RESERVAR_PISTA_Controller.php');
      }else{
        new RESERVAR_PISTA_ADD($pistas_sin_reserva, $_REQUEST["fecha"], $horario );
      }
    }
  }
  break;

  case 'SHOW_RESERVAS':
  $RESERVA = new RESERVA_Model('','','','','');
  if($_SESSION["rol"] == 'ADMIN'){
    $reservas = $RESERVA->SHOWALL_PISTAS_Login($_SESSION['login']);
  }
  else{
    $reservas = $RESERVA->SHOWALL_PISTAS_Login($_SESSION['login']);
  }
  new SHOW_RESERVAS($reservas, '../Controllers/RESERVAR_PISTA_Controller.php');
  break;

  case 'SHOW_RESERVAS_PISTA':
  if(isset($_REQUEST["pista_ID"])){
  $RESERVA = new RESERVA_Model('','','',$_REQUEST["pista_ID"],'');
  $PISTA  = new PISTA_Model($_REQUEST["pista_ID"],'','');
  $nombre = $PISTA->GET_NOMBRE();
  $reservas = $RESERVA->SHOWALL_Login($_SESSION['login']);
  new SHOW_RESERVAS_PISTA($reservas, $nombre, '../Controllers/RESERVAR_PISTA_Controller.php');
  }
  break;

  case 'DELETE':
  $RESERVA = new RESERVA_Model($_REQUEST["reserva_ID"],'','','','');
  $mensaje = $RESERVA->DELETE();
  $reservas = new MESSAGE($mensaje, '../Controllers/RESERVAR_PISTA_Controller.php?action=SHOW_RESERVAS');
  break;


  default:
  $HORARIO = new HORARIO_Model('','','');
  $RESERVA = new RESERVA_Model('','','','','','');
  $PISTA = new PISTA_Model('','','');
  $PARTIDO = new PARTIDO_Model('','','','','','');
  if($_SESSION["rol"] != 'ADMIN' && $RESERVA->CHECK_MAX()){
    new MESSAGE("Has alcanzado el número máximo de reservas!", '../Controllers/RESERVAR_PISTA_Controller.php?action=SHOW_RESERVAS');
  }
  else{
  $horarios = $HORARIO->SHOWALL();
  $reservas = $RESERVA->SHOWALL();
  $pistas =  $PISTA->SHOWALL();
  $partidos =  $PARTIDO->SHOWALL();
  new RESERVAR_PISTA_Horario($horarios,$reservas,$partidos, $pistas);
  }
  break;
}

?>
