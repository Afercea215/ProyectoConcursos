<?php
if (Sesion::estaLogeado()) {
    echo '<h2 class="g-marg-bottom--3">Listado Modos</h2>';
    echo "<script>imprimeModo()</script>";
}else{
    header('location:/?menu=login');
}
?>