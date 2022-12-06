<?php
include_once '../autoCargadores/autoCargador.php';

if (Sesion::estaLogeado() && Sesion::esAdmin()) {
    //si ha enviado datos por POST
    $validacion = new Validacion();
    if (isset($_POST['submit']) && isset($_GET['accion'])) {
        $valida->Requerido('id')
        ->Requerido('nombre')
        ->Requerido('descrip')
        ->Requerido('fini')
        ->Requerido('fini')
        ->Requerido('finiInscrip')
        ->Requerido('ffinInscrip');
        
        if ($validacion->ValidacionPasada()) {
            if ($_GET['accion']=='edita') {
                
            }else if ($_GET['accion']=='crea') {
                
            }
        }
    }
}

?>