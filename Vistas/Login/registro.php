<?php
    //include_once("./helper/validacion.php");
    $valida=new Validacion();
    if(isset($_POST['submit']))
    {
        $valida->validaNombreUsuario('usuario',$_POST['usuario']);
        $valida->Requerido('contrasena');
        $valida->validaEmail('email', $_POST['email']);
        $valida->Requerido('local-x');
        $valida->Requerido('local-y');
        //Comprobamos validacion
        if($valida->ValidacionPasada())
        {
            if (isset($_POST['usuario'])&&isset($_POST['contrasena'])&&isset($_POST['email'])&&isset($_POST['local-x'])&&isset($_POST['local-y'])) {
                $array['id']=10;
                $array['nombre']=$_POST['usuario'];
                $array['contrasena']=$_POST['contrasena'];
                $array['correo']=$_POST['email'];
                $array['x']=$_POST['local-x'];
                $array['y']=$_POST['local-y'];
                ////////////////////////
                $array['identificador']="asa";
                $array['admin']=false;

                if (!empty($_FILES) && $_FILES['imagen']['type']=="image/jpeg" || $_FILES['imagen']['type']=="image/png") {
                    $path = $_FILES['imagen']['tmp_name'];
                    $array['imagen']=Imagenes::imgToBase64($path);
                }else { 
                    $valida->addError("imagen","Formato de imagen no valido.");
                    $array['imagen']="./img/usuarioDefault.png";
                }
                $participante=Participante::arrayToParticipante($array);
                RepositorioParticipante::add($participante);

                header('location:./?menu=login');
            }
        }
        
    }
?>
<div class='w-50 p-3 container'>
    <div class='login-form'>
        <form action='' method='post' enctype="multipart/form-data">
            <h2 class='text-center'>Identificate</h2>
            <div class='form-group'>
                <p>Nombre de usuario</p>
                <input type='text' class='form-control <?php $valida->imprimeClaseInputError('usuario')?>' name='usuario' placeholder='Nombre de usuario' required='required'>
                <?= $valida->ImprimirError('usuario') ?>
            </div>
            <div class='form-group'>
                <p>Contraseña</p>
                <input type='password' class='form-control <?php $valida->imprimeClaseInputError('contrasena')?>' name='contrasena' placeholder='Contraseña' required='required'>
                <?= $valida->ImprimirError('contrasena') ?>
            </div>
            <div class='form-group'>
                <p>Correo Electronico</p>
                <input type='email' class='form-control <?php $valida->imprimeClaseInputError('email')?>' name='email' placeholder='Correo electrionico' required='required'>
                <?= $valida->ImprimirError('email') ?>
            </div>
            <p>Coordenadas</p>
            <div class='form-group'>
                <p>Cordenada Eje X</p>
                <input type='number' class='form-control <?php $valida->imprimeClaseInputError('local-x')?>' name='local-x' placeholder='Cordenadas X' required='required'>
                <?= $valida->ImprimirError('local-x') ?>
            </div>
            <div class='form-group'>
                <p>Cordenada Eje Y</p>
                <input type='number' class='form-control <?php $valida->imprimeClaseInputError('local-y')?>' name='local-y' placeholder='Cordenadas Y' required='required'>
                <?= $valida->ImprimirError('local-y') ?>
            </div>
            <div class='form-group'>
                <p>Foto de perfil</p>
                <input type='file' class='form-control <?php $valida->imprimeClaseInputError('imagen')?>' name='imagen'>
                <?= $valida->ImprimirError('imagen') ?>
            </div>
                        
            <div class='form-group'>
                <button type='submit' name='submit' class='btn btn-primary btn-block'>Crear Cuenta</button>
            </div>
            <div class='clearfix'>
                <label class='pull-left checkbox-inline'>
                    <input type='checkbox' name='recuerdame'> Recuerdame</label>
            </div>
        </form>
        <p class='text-center'><a href='./?menu=registro'>Crear una Cuenta</a></p>
    </div>
</div>