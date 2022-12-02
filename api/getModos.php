<?php
    require_once("../autoCargadores/autoCargador.php");
    Sesion::iniciar();
    if (Sesion::estaLogeado()) {
        $modos=GBD::getAllArray("modo");  
        echo json_encode($modos);
    }else{
        header('location:./?menu=login');
    }
?>