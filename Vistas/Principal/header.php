<?php
    Sesion::iniciar();
    //si no esta logeado y cookies de recuerdame
    if (!Sesion::estaLogeado() && isset($_COOKIE['recuerdame'])) {
        $participante = RepositorioParticipante::getByNombreContra($_COOKIE['usuario'], $_COOKIE['contrasena']);
        Sesion::iniciaSesion($participante, true);
    }

    $esAdmin=false;

    if (Sesion::estaLogeado() && Sesion::esAdmin()) {
        $esAdmin = true;
        $clase = 'c-header c-header--admin';
    }else{
        $clase = 'c-header';
    }
?>
<header class="<?php echo $clase ?>">
    <a href="./?menu=inicio"><img src="../../img/logo-blanco.png" class="c-header__logo" alt=""></a>
    <nav class="c-header__menu">
        <?php
            if (!Sesion::estaLogeado() || !$esAdmin) {
                echo '<a href="./?menu=concursos">Concursos</a>';
            }
            if (Sesion::estaLogeado() && $esAdmin) {
                
                echo '<a href="./?menu=listadoConcursos">Concursos</a>
                      <a href="./?menu=listadoParticipantes">Participantes</a>
                      <a href="./?menu=listadoBandas">Bandas</a>
                      <a href="./?menu=listadoModos">Modos</a>
                      ';
            }
        ?>
    </nav>
    <div class="c-header__indentificacion">
        <?php
         if (!Sesion::estaLogeado()) {
             echo '<a href="./?menu=login" id="login">Login</a>    
             <a href="./?menu=registro" class="c-boton c-boton--secundario">Registrarse</a>';    
        }else{
             $nombre = Sesion::leer('usuario')->getNombre();
            echo "<div class='c-header__indentificacion__logo-usuario'>
                    <div class='c-menu-desplegable'>
                        <img src='".Sesion::leer('usuario')->getImagen()."' class='logo' alt=''>
                        <span id='desplegable' class='btnDesplegable'>▼</span>

                        <div class='c-menu-desplegable__contenido' id='contenido-menu'>
                            <a href=''>$nombre<a>
                            <hr>
                            <a href='./?menu=datosPersonales'>Datos Personales</a>
                            <a href='./?menu=cerrarsesion'>Cerrar Sesion</a>
                        </div>
                    </div>
                  </div>";
         } 
        ?>
    </div>
</header>