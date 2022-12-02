<?php 
include_once "../autoCargadores/autoCargador.php";
if (Sesion::estaLogeado()) {
    if (isset($_POST) && isset($_POST['id']) && isset($_POST['tipoDato'])) {
        $id = $_POST['id'];
        $tipoDato = $_POST['tipoDato'];
        try {
            GBD::delete($tipoDato, $id);
        } catch (Exception $e) {
            echo $e;
        }
    }else{
        echo "faltan datos :(";
    }
} else{
    header('location ./?menu=login');
}

?>