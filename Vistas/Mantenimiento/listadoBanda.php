<?php
if (Sesion::estaLogeado()) {
    echo '<h2 class="g-marg-bottom--3">Listado Bandas</h2>';
    echo "<script>imprimeBanda()</script>";
}else{
    header('location:/?menu=login');
}
?>