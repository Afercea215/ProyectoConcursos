<?php
    if (Sesion::estaLogeado() && Sesion::esAdmin()) {
        $clase = 'c-footer c-footer--admin';
    }else{
        $clase = 'c-footer';
    }
?>

<footer class="<?php echo $clase ?>">
    <div class="c-footer__redesSociales">
        <a href=""><img src="../../img/logo_instagram.png" alt=""></a>
        <a href=""><img src="../../img/logoLinkedin.png" alt=""></a>
    </div>
    <a href="" class="c-boton c-boton--secundario">Contacto</a>
</footer>