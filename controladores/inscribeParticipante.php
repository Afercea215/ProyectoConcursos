<?php
include_once '../autoCargadores/autoCargador.php';
Sesion::iniciar();
    
if (Sesion::estaLogeado()) {
    if (isset($_GET['idConcurso']) && isset($_GET['idParticipante'])) {
        RepositorioConcurso::inscribeParticipante($_GET['idConcurso'],$_GET['idParticipante']);       
    }
}

header("location: ../?menu=concursos");
?>