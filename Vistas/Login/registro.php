<?php
    //include_once("./helper/validacion.php");
    $valida=new Validacion();
    if(isset($_POST['usuario']) && isset($_POST['contrasena']) && isset($_POST['email']) && isset($_POST['local-x']) && isset($_POST['local-y']))
    {
        $valida->validaNombreUsuario('usuario',$_POST['usuario']);
        $valida->Requerido('contrasena');
        $valida->validaEmail('email', $_POST['email']);
        $valida->Requerido('local-x');
        $valida->Requerido('local-y');
        $valida->validaIdentificador('identificador',$_POST['identificador']);
        //Comprobamos validacion
        if($valida->ValidacionPasada())
        {
            if (isset($_POST['usuario'])&&isset($_POST['contrasena'])&&isset($_POST['email'])&&isset($_POST['local-x'])&&isset($_POST['local-y'])&&isset($_POST['identificador'])) {
                $array['id']=10;
                $array['nombre']=$_POST['usuario'];
                $array['contrasena']=$_POST['contrasena'];
                $array['correo']=$_POST['email'];
                $array['x']=$_POST['local-x'];
                $array['y']=$_POST['local-y'];
                ////////////////////////
                $array['identificador']=$_POST['identificador'];
                $array['admin']=false;

                if (!empty($_FILES) && $_FILES['imagen']['type']=="image/jpeg" || $_FILES['imagen']['type']=="image/png" || $_FILES['imagen']['type']=="application/octet-stream") {
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
<form action='' method='post' enctype="multipart/form-data" class="c-form g-pad--6 g-marg--2 g-shadow--3">
    <h2 class='g-marg-bottom--1'>Registro</h2>

    <p>Nombre de usuario</p>
    <input type='text' class='<?php $valida->imprimeClaseInputError('usuario')?> val_required val_text' name='usuario' placeholder='Nombre de usuario' value='<?php if (isset($_POST['usuario'])){
        echo $_POST['usuario'];
        } ?>'>
    <?= $valida->ImprimirError('usuario') ?>

    <p>Contraseña</p>
    <input type='password' class='<?php $valida->imprimeClaseInputError('contrasena')?> val_required val_text' name='contrasena' placeholder='Contraseña' value='<?php if (isset($_POST['usuario'])){
        echo $_POST['contrasena'];
        } ?>'>
    <?= $valida->ImprimirError('contrasena') ?>
    
    <p>Correo Electronico</p>
    <input type='email' class='<?php $valida->imprimeClaseInputError('email')?> val_required val_email' name='email' placeholder='Correo electrionico' value='<?php if (isset($_POST['usuario'])){
        echo $_POST['email'];
        } ?>'>
    <?= $valida->ImprimirError('email') ?>
    
    <p>Identificador</p>
    <input type='text' class='<?php $valida->imprimeClaseInputError('identificador')?> val_required val_text' name='identificador' placeholder='Identificador' value='<?php if (isset($_POST['usuario'])){
        echo $_POST['identificador'];
        } ?>'>
    <?= $valida->ImprimirError('identificador') ?>
    
    <h3>Coordenadas</h3>
    <p>Cordenada Eje X</p>
    <input type='number' class='<?php $valida->imprimeClaseInputError('local-x')?> val_required val_num' name='local-x' id='local-x' placeholder='Cordenadas X' value='<?php if (isset($_POST['usuario'])){
        echo $_POST['local-x'];
        } ?>'>
    <?= $valida->ImprimirError('local-x') ?>
    <p>Cordenada Eje Y</p>
    <input type='number' class='<?php $valida->imprimeClaseInputError('local-y')?> val_required val_num' name='local-y' id='local-y' placeholder='Cordenadas Y' value='<?php if (isset($_POST['usuario'])){
        echo $_POST['usuario'];
        } ?>'>
    <?= $valida->ImprimirError('local-y') ?>
    <input type="button" id="capturaLocalizacion" value="Capturar Localizacion" class="c-boton c-boton--secundario">

    <p>Foto de perfil</p>
    
    <video id="video" playsinline autoplay></video>
    <!-- Trigger canvas web API -->
    <canvas id="canvas" width="300" height="200" style="display: none;"></canvas>
        <button id="btnFoto" class="c-boton c-boton--secundario">Capturar</button>


    <input type='file' class='<?php $valida->imprimeClaseInputError('imagen')?>' name='imagen' id="inpFile">
    <?= $valida->ImprimirError('imagen') ?>
    <!-- onclick="validaForm(this)" -->
    <button type='submit' class='c-boton c-boton--secundario g-marg-top--2' id="btnRegistro">Crear Cuenta</button>
    <a href='./?menu=login' class=''>Iniciar Sesion</a>
</form>
