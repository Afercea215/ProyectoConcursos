<?php
if (Sesion::estaLogeado()) {
    echo '<h2 class="g-marg-bottom--3">Listado Participantes</h2>';
    echo "<script>imprimeParticipantes()</script>";
}else{
    header('location:/?menu=login');
}
?>