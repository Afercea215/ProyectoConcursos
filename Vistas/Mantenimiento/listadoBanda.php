<?php
if (Sesion::estaLogeado()) {
    echo "<script>imprimeBanda()</script>";
}else{
    header('location:/?menu=login');
}
?>