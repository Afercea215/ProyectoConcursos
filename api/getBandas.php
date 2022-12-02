<?php
    require_once("../autoCargadores/autoCargador.php");
    Sesion::iniciar();
    if (Sesion::estaLogeado()) {
        $banda=GBD::getAllArray("banda");  
        echo json_encode($banda);
    }else{
        header('location:./?menu=login');
    }
?>