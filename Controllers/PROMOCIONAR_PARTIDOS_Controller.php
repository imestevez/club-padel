<?php
                
    session_start();

    include '../Views/PROMOCIONAR_PARTIDOS/PROMOCIONAR_PARTIDOS_Alta_View.php'; 

    if(isset($_REQUEST["action"]))  {//Si trae acción, se almacena el valor en la variable action
        $action = $_REQUEST["action"];
    }else{//Si no trae accion
        $action = '';
    }
    new Promocionar_Partidos();
    ?>