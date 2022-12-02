<?php
if (Sesion::estaLogeado()) {
    echo "<script>imprimeModo()</script>";
}else{
    header('location:/?menu=login');
}
?>