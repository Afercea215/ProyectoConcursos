<?php
include_once '../autoCargadores/autoCargador.php';
    if (isset($_GET['id']) && isset($_GET['idConcurso'])) {
        try {
            RepositorioQso::aprobarMensaje($_GET['id']);
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }
    header('location:../?menu=verConcurso&id='.$_GET['idConcurso']);
?>