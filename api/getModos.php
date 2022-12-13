<?php
    require_once("../autoCargadores/autoCargador.php");
    Sesion::iniciar();
    if (Sesion::estaLogeado() && Sesion::esAdmin()) {
        $modos=GBD::getAllArray("modo");  
        echo json_encode($modos);
        http_response_code(200);
    }else{
        http_response_code(300);
        header('location:./?menu=login');
    }
?>