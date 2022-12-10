<?php
    if (Sesion::estaLogeado()) {
        $datos = Sesion::leer('usuario');

        $validacion = new Validacion();
        if (isset($_POST['submit']) && isset($_GET['accion'])) {
            
            $validacion->Requerido('nombre');
            $validacion->Requerido('identificador');
            $validacion->Requerido('correo');
            $validacion->Requerido('contrasena');
            $validacion->Requerido('x');
            $validacion->Requerido('y');
            
            //si no se valida se imprimen los datos con errores
            if (!$validacion->ValidacionPasada()) {
                imprimeEdicion($datos,$validacion);
            }else{
                //envio la id tb
                $_POST['id']=$datos->getId();
                //comprebo la imagen
                if (!empty($_FILES) && $_FILES['imagen']['type']=="image/jpeg" || $_FILES['imagen']['type']=="image/png") {
                    $path = $_FILES['imagen']['tmp_name'];
                    $_POST['imagen']=Imagenes::imgToBase64($path);
                }else { 
                    $_POST['imagen']=$datos->getImagen();
                }                
                try {
                    RepositorioParticipante::update(Participante::arrayToParticipante($_POST));
                    $participante = RepositorioParticipante::getById($datos->getId());
                    Sesion::terminar();
                    Sesion::iniciaSesion($participante);
                    header('location:./?menu=datosPersonales');
                } catch (Exception $e) {
                    echo "<script>muestraPanelError('Error','No se han podido actualizar sus datos.s')<script>";
                }
            }
            //si quiere editar se imprime el form
        }else if (isset($_GET['accion']) && $_GET['accion']=='edita') {
            imprimeEdicion($datos);
        }
    }else{
        header('location:./?menu=login');
    }
?>
<a href="./?menu=datosPersonales&accion=edita" class="c-boton">Editar Datos</a>

<div class="c-perfil">
    <div class="c-perfil__logo">
        <img src="<?php echo $datos->getImagen() ?>" alt="">
        <h2><?php echo $datos->getNombre() ?></h2>
    </div>
    <div class="c-perfil__otros">
        <label for="">Nombre</label>
        <p><?php echo $datos->getNombre()?></p><hr>

        <label for="">Identificador</label>
        <p><?php echo $datos->getIdentificador()?></p><hr>
        
        <label for="">Correo</label>
        <p><?php echo $datos->getCorreo()?></p><hr>
        
        <label for="">Contraseña</label>
        <p>●●●●●●●●●</p><hr>

        <label for="">Localizacion X</label>
        <p><?php echo $datos->getLocalizacion()->getX()?></p>
        <label for="">Localizacion Y</label>
        <p><?php echo $datos->getLocalizacion()->getY()?></p>
    </div>
</div>


<?php

function imprimeEdicion($datos, $validacion=null){
    echo '
    <form class="c-form--edicion animZoom" method="post" action="./?menu=datosPersonales&accion=edita" enctype="multipart/form-data">
        <span class="btnSalir">
            <a href="./?menu=datosPersonales">
            <img src="../../img/x.webp" alt="">
            </a>
        </span>

        <div class="c-form__titulo">
            <h2 style="margin-bottom: 4%; margin-top: 4%;">Edicion perfil</h2>
            <hr>
        </div>

        <div class="c-form__componente">
            <label for="nombre">Nombre</label>
            <input type="text" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('nombre'):"").'" name="nombre" value="'.(($_POST['nombre'])??$datos->getNombre()).'">
            '.(($validacion!=null)?$validacion->ImprimirError('nombre'):"").'
        </div> 
        <div class="c-form__componente">
            <label for="identificador">Identificador</label>
            <input type="text" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('identificador'):"").'" name="identificador" value="'.(($_POST['identificador'])??$datos->getIdentificador()).'">
            '.(($validacion!=null)?$validacion->ImprimirError('identificador'):"").'
        </div>
        <div class="c-form__componente">
            <label for="correo">Correo</label>
            <input type="email" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('correo'):"").'" name="correo" value="'.(($_POST['correo'])??$datos->getCorreo()).'">
            '.(($validacion!=null)?$validacion->ImprimirError('fini'):"").'
        </div>
        <div class="c-form__componente">
            <label for="contrasena">Contraseña</label>
            <input type="password" name="contrasena" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('contrasena'):"").'" value="'.(($_POST['contrasena'])??$datos->getContrasena()).'">
            '.(($validacion!=null)?$validacion->ImprimirError('contrasena'):"").'
        </div>
        <div class="c-form__componente">
            <label for="x">Localizacion X</label>
            <input type="number" name="x" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('x'):"").'" value="'.(($_POST['x'])??$datos->getLocalizacion()->getX()).'">
            '.(($validacion!=null)?$validacion->ImprimirError('x'):"").'
        </div>
        <div class="c-form__componente">
            <label for="y">Localizacion Y</label>
            <input type="number" name="y" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('y'):"").'" value="'.(($_POST['y'])??$datos->getLocalizacion()->getY()).'">
            '.(($validacion!=null)?$validacion->ImprimirError('y'):"").'
        </div>
        <div class="c-form__componente">
            <label for="imagen">Imagen</label>
            <input type="file" name="imagen" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('imagen'):"").'">
            '.(($validacion!=null)?$validacion->ImprimirError('imagen'):"").'
        </div>

        <div class="c-form__footer">
            <hr>
            <button value="Guardar" name="submit" class="c-boton c-boton--secundario">Guardar</button>
        </div>
    </form>
    <div class="bgModal"></div>';

}

?>