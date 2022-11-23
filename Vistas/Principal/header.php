<?php
    Sesion::iniciar();
    //si no esta logeado y cookies de recuerdame
    if (!Sesion::estaLogeado() && isset($_COOKIE['usuario']) && isset($_COOKIE['contrasena'])) {
            $participante = RepositorioParticipante::getByNombreContra($_COOKIE['usuario'], $_COOKIE['contrasena']);
            Sesion::iniciaSesion($participante, true);
    }
    $imagen=Sesion::leer('imagen');
?>
<header class="c-header">
    <img src="../../img/logo-blanco.png" class="c-header__logo" alt="">
    <nav class="c-header__menu">
        <a href="./?menu=inicio">Home</a>
        <a href="./?menu=concursos">Concursos</a>
    </nav>
    <div class="c-header__indentificacion">
        <?php
         if (!Sesion::estaLogeado()) {
            echo '<a href="./?menu=login" class="c-boton--secundario">Login</a>    
                  <a href="./?menu=registro" class="c-boton">Registrarse</a>';    
         }else{
            echo "<a href='./?menu=cerrarsesion'>Cerrar Sesion</a>
                  <div class='c-header__indentificacion__logo-usuario'>
                    <img src='".$imagen."' class='logo' alt=''>
                    <span>▼</span>
                  </div>";
         } 
        ?>
    </div>
</header>