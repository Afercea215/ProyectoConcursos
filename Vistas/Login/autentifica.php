<?php
    $valida=new Validacion();
    if(isset($_POST['submit']))
    {
        $valida->Requerido('usuario');
        $valida->Requerido('contrasena');
        //Comprobamos validacion
        $recuerdame =isset($_POST['recuerdame'])?$_POST['recuerdame']:false;
        $participante = Login::Identifica($_POST['usuario'],$_POST['contrasena'],$recuerdame);
        if($valida->ValidacionPasada() && $participante)
        {
            Sesion::iniciaSesion($participante,$recuerdame);
            //si hay pagina anterior te lleva a eso y si no a inicio
            $url=(isset($_GET['returnurl']))?$_GET['returnurl']:"inicio";
            header("location:?menu=".$url);
        }
    }
?>
<div class='w-50 p-3 container'>
    <div class='login-form'>
        <form action='' method='post' novalidate>
            <h2 class='text-center'>Identificate</h2>
            <div class='form-group'>
                <input type='text' class='form-control <?php $valida->imprimeClaseInputError('usuario')?>' name='usuario' placeholder='Usuario' required='required'>
                <?= $valida->ImprimirError('usuario') ?>
            </div>
            <div class='form-group'>
                <input type='password' class='form-control <?php $valida->imprimeClaseInputError('contrasena')?>' name='contrasena' placeholder='Contraseña'
                    required='required'>
                <?= $valida->ImprimirError('contrasena') ?>
            </div>
            <div class='form-group'>
                <button type='submit' name='submit' class='btn btn-primary btn-block'>Logueate</button>
            </div>
            <div class='clearfix'>
                <label class='pull-left checkbox-inline'>
                    <input type='checkbox' name='recuerdame'> Recuerdame</label>
            </div>
        </form>
        <p class='text-center'><a href='./?menu=registro'>Crear una Cuenta</a></p>
    </div>
</div>