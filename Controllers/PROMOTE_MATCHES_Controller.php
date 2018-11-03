<?php
                
    session_start();

    include '../Views/PROMOTE_MATCHES/PROMOTE_MATCHES_Alta_View.php'; 

    if(isset($_REQUEST["action"]))  {//Si trae acción, se almacena el valor en la variable action
        $action = $_REQUEST["action"];
    }else{//Si no trae accion
        $action = '';
    }
    new PROMOTE_MATCHES();
    ?>