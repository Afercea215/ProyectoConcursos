<?php   
  $valida=new Validacion();
  $errorLogin="";
  if(isset($_POST) && isset($_POST['correo']))
  {
      $valida->existeEmail('correo',$_POST['correo']);
      //Comprobamos validacion
      if($valida->ValidacionPasada())
      {
        $nueva = gestionContrasena::randomPassword();
        $participante = RepositorioParticipante::getByCorreo($_POST['correo']);

        if ($participante!=null) {
          $participante->setContrasena($nueva);
  
          RepositorioParticipante::update($participante);
          gestionContrasena::enviaCorreoContrasena($participante->getCorreo(),$nueva);
          
          header('location:./?menu=login');
        }
      }
  }


?>

<form action='' method='post' novalidate class="c-form g-pad--5 g-shadow--3">
        <h2 class="g-marg-bottom--1">Cambiar contraseña</h2>
        <span class="error_mensaje"><?php echo $errorLogin ?></span>
        <input type='mail' class='form-control <?php $valida->imprimeClaseInputError('correo')?> val_required' name='correo' placeholder='Correo Electronico'
            required='required'>
        <?= $valida->ImprimirError('correo') ?>
        <button type='submit' class='c-boton c-boton--secundario g-marg-top--1' id="btnIniciaSesion">Cambiar Contraseña</button>
</form>