<?php
if (Sesion::estaLogeado()) {
    echo "<script>imprimeParticipantes()</script>";
}else{
    header('location:/?menu=login');
}
?>