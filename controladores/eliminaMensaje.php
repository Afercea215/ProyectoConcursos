<?php
    include_once "../autoCargadores/autoCargador.php";
    Sesion::iniciar();
    if (Sesion::estaLogeado() && Sesion::esAdmin()) {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            try {
                RepositorioQso::delete($id);
                if (isset($_GET['idParticipante']) && isset($_GET['idConcurso'])) {
                    header('location: ../?menu=verMensajesParticipante&idParticipante='.$_GET['idParticipante'].'&idConcurso='.$_GET['idConcurso']);
                }else{
                    header('location: ../?menu=verConcurso&id='.$_GET['idConcurso']);
                }
            } catch (Exception $e) {
                header('location: ../?menu=verMensajesParticipante&idParticipante='.$_GET['idParticipante'].'&idConcurso='.$_GET['idConcurso'].'&qerror=No se puede eliminar debido a que otros elementos dependen de este concurso');
            }
        }
    }else{
        header('location ../?menu=login');
    }

?>