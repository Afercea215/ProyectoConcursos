
<?php 
require_once '../autoCargadores/autoCargador.php';
Sesion::iniciar();

if (Sesion::estaLogeado()) {
    if (isset($_POST)) {
        try {
            for ($i=0; $i < sizeof($_POST['nombre']) ; $i++) {
                $array['id']=1;
                $array['nombre']=$_POST['nombre'][$i];
                $array['identificador']=$_POST['identificador'][$i];
                $array['contrasena']=$_POST['contrasena'][$i];
                $array['admin']=false;
                $array['correo']=$_POST['correo'][$i];
                $array['imagen']="./img/usuarioDefault.png";
                $array['x']=$_POST['loc_x'][$i];
                $array['y']=$_POST['loc_y'][$i];

                $participante = Participante::arrayToParticipante($array); 
                RepositorioParticipante::add($participante);
            }
        } catch (Exception $e) {
            http_response_code(500);
        }
    }
}
http_response_code(200);

?>