<?php
    require_once("../autoCargadores/autoCargador.php");
    Sesion::iniciar();
    if (Sesion::estaLogeado()) {
        $participantes=RepositorioParticipante::getAllArray();  
        echo json_encode($participantes);
    }else{
        header('location:./?menu=login');
    }
?>