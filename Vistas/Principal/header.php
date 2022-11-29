<?php
    Sesion::iniciar();
    //si no esta logeado y cookies de recuerdame
    if (!Sesion::estaLogeado() && isset($_COOKIE['recuerdame'])) {
            $participante = RepositorioParticipante::getByNombreContra($_COOKIE['usuario'], $_COOKIE['contrasena']);
            Sesion::iniciaSesion($participante, true);
    }
?>
<header class="c-header">
    <img src="../../img/logo-blanco.png" class="c-header__logo" alt="">
    <nav class="c-header__menu">
        <a href="./?menu=inicio">Home</a>
        <a href="./?menu=concursos">Concursos</a>
        <?php
            if (Sesion::esAdmin()) {
                
                echo '<div class="menuDesplegable" id="mantenimiento">
                        Mantenimiento
                        <div id="submenu" class="menuDesplegable__submenu">
                            <a href="./?menu=listadoConcursos">Concursos</a>
                            <a href="./?menu=listadoParticipantes">Participantes</a>
                        </div>
                      </div>';
                echo '';
            }
        ?>
    </nav>
    <div class="c-header__indentificacion">
        <?php
         if (!Sesion::estaLogeado()) {
            echo '<a href="./?menu=login" class="c-boton">Login</a>    
                  <a href="./?menu=registro" class="c-boton--secundario">Registrarse</a>';    
         }else{
            echo "<a href='./?menu=cerrarsesion'>Cerrar Sesion</a>
                  <div class='c-header__indentificacion__logo-usuario'>
                    <img src='".Sesion::leer('imagen')."' class='logo' alt=''>
                    <span>▼</span>
                  </div>";
         } 
        ?>
    </div>
</header>