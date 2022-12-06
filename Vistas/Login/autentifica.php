<?php
    $valida=new Validacion();
    $errorLogin="";
    if(isset($_POST['submit']))
    {
        $valida->Requerido('usuario');
        $valida->Requerido('contrasena');
        //Comprobamos validacion
        $recuerdame =isset($_POST['recuerdame'])?true:false;
        $participante = Login::Identifica($_POST['usuario'],$_POST['contrasena'],$recuerdame);
        if($valida->ValidacionPasada() && $participante)
        {
            Sesion::iniciaSesion($participante,$recuerdame);
            //si hay pagina anterior te lleva a eso y si no a inicio
            $url=(isset($_GET['returnurl']))?$_GET['returnurl']:"inicio";
            header("location:?menu=".$url);
        }else{
            $errorLogin="Usuario o contraseña incorrectos";
        }
    }
?>
<form action='' method='post' novalidate class="c-form g-pad--5 g-shadow--3">
        <h2 class="g-marg-bottom--1">Identificate</h2>
        <span class="error_mensaje"><?php echo $errorLogin ?></span>
        <input type='text' class='<?php $valida->imprimeClaseInputError('usuario')?> val_required' name='usuario' placeholder='Usuario' required='required'>
        <?= $valida->ImprimirError('usuario') ?>
        <input type='password' class='form-control <?php $valida->imprimeClaseInputError('contrasena')?> val_required' name='contrasena' placeholder='Contraseña'
            required='required'>
        <?= $valida->ImprimirError('contrasena') ?>
        <button type='submit' name='submit' class='c-boton c-boton--secundario g-marg-top--1' id="btnIniciaSesion">Iniciar Sesion</button>
        <a href='./?menu=registro'>Crear una Cuenta</a>
        <div class="g-pad-top--0">
            <input type='checkbox' name='recuerdame' value="">
            <span>Recuerdame</span>
        </div>
</form>