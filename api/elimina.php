<?php
include_once "../autoCargadores/autoCargador.php";
Sesion::iniciar();
if (Sesion::estaLogeado()) {
    if (isset($_POST)) {
        $id = $_POST['id'];
        $tipoDato = $_POST['tipoDato'];
        try {
            GBD::delete($tipoDato, $id);
        } catch (Exception $e) {
            echo $e;
        }
    }else{
        echo "faltan datos :(";
        http_response_code(500);
    }
} else{
    header('location ./?menu=login');
    http_response_code(200);
}
?>