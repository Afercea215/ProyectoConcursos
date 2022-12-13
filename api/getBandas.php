<?php
    require_once("../autoCargadores/autoCargador.php");
    Sesion::iniciar();
    if (Sesion::estaLogeado() && Sesion::esAdmin()) {
        $banda=GBD::getAllArray("banda");  
        echo json_encode($banda);
        http_response_code(200);

    }else{
        http_response_code(300);
        header('location:./?menu=login');
    }
?>