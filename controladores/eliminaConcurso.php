<?php
    include_once "../autoCargadores/autoCargador.php";
    Sesion::iniciar();
    if (Sesion::estaLogeado() && Sesion::esAdmin()) {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            try {
                RepositorioConcurso::delete($id);
                header('location: ../?menu=listadoConcursos');
            } catch (Exception $e) {
                header('location: ../?menu=listadoConcursos?error=No se puede eliminar debido a que otros elementos dependen de este concurso');
            }
        }
    }else{
        header('location ../?menu=login');
    }

?>