<?php
    require_once("../autoCargadores/autoCargador.php");
    Sesion::iniciar();
    if (Sesion::estaLogeado() && Sesion::esAdmin()) {
        $participantes=RepositorioParticipante::getAllArray();  
        echo json_encode($participantes);
        http_response_code(200);

    }else{
        http_response_code(300);
        header('location:./?menu=login');
    }
?>