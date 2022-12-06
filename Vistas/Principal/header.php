<?php
    Sesion::iniciar();
    //si no esta logeado y cookies de recuerdame
    if (!Sesion::estaLogeado() && isset($_COOKIE['recuerdame'])) {
            $participante = RepositorioParticipante::getByNombreContra($_COOKIE['usuario'], $_COOKIE['contrasena']);
            Sesion::iniciaSesion($participante, true);
    }
?>
<header class="c-header">
    <a href="./?menu=inicio"><img src="../../img/logo-blanco.png" class="c-header__logo" alt=""></a>
    <nav class="c-header__menu">
        <a href="./?menu=concursos">Concursos</a>
        <?php
            if (Sesion::estaLogeado() && Sesion::esAdmin()) {
                
                echo '<a href="./?menu=listadoConcursos">Mantenimiento Concursos</a>
                      <a href="./?menu=listadoParticipantes">Mantenimiento Participantes</a>
                      <a href="./?menu=listadoBandas">Mantenimiento Bandas</a>
                      <a href="./?menu=listadoModos">Mantenimiento Modos</a>
                      ';
            }
        ?>
    </nav>
    <div class="c-header__indentificacion">
        <?php
         if (!Sesion::estaLogeado()) {
            echo '<a href="./?menu=login" class="c-boton">Login</a>    
                  <a href="./?menu=registro" class="c-boton c-boton--secundario">Registrarse</a>';    
         }else{
            echo "<a href='./?menu=cerrarsesion'>Cerrar Sesion</a>
                  <div class='c-header__indentificacion__logo-usuario'>
                    <img src='".Sesion::leer('usuario')->getImagen()."' class='logo' alt=''>
                    <span>▼</span>
                  </div>";
         } 
        ?>
    </div>
</header>