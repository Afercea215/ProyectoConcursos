<?php
if (isset($_GET['menu'])) {
    if ($_GET['menu'] == "inicio") {
        require_once 'index.php';
    }
    if ($_GET['menu'] == "login") {
        require_once './Vistas/Login/autentifica.php';
    }
    if ($_GET['menu'] == "registro") {
        require_once './Vistas/Login/registro.php';
    }
    if ($_GET['menu'] == "cerrarsesion") {
        require_once './Vistas/Login/cerrarsesion.php';
    }
    if ($_GET['menu'] == "listadoParticipantes") {
        require_once './Vistas/Mantenimiento/listadoParticipantes.php';
    }
    if ($_GET['menu'] == "listadoModos") {
        require_once './Vistas/Mantenimiento/listadoModo.php';
    }
    if ($_GET['menu'] == "listadoBandas") {
        require_once './Vistas/Mantenimiento/listadoBanda.php';
    }
    if ($_GET['menu'] == "listadoConcursos") {
        require_once './Vistas/Mantenimiento/listadoConcursos.php';
    }
    if ($_GET['menu'] == "verConcurso") {
        require_once './Vistas/Mantenimiento/verConcurso.php';
    }
    if ($_GET['menu'] == "concursos") {
        require_once './Vistas/Mantenimiento/concursos.php';
    }
    if ($_GET['menu'] == "verMensajesParticipante") {
        require_once './Vistas/Mantenimiento/verMensajesParticipante.php';
    }
}
    //Añadir otras rutas
