<?php
use PHPMailer\PHPMailer\PHPMailer;
class gestionContrasena{

    public static function enviaCorreoContrasena($destinatario, $contrasena)
    {
        require "./vendor/autoload.php";
        $mail = new PHPMailer();
        $mail->IsSMTP();
        // cambiar a 0 para no ver mensajes de error
        $mail->SMTPDebug  = 0;                          
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "tls";                 
        $mail->Host       = "smtp.gmail.com";    
        $mail->Port       = 587;                 
        // introducir usuario de google
        $mail->Username   = "telecogroupoficial@gmail.com"; 
        // introducir clave
        $mail->Password   = "hucudwhozfxshknw";       
        $mail->SetFrom('telecogroupoficial@gmail.com', 'Administracion');
        // asunto
        $asunto="Nueva Contraseña";
        $mail->Subject    = $asunto;
        // cuerpo
        $mail->MsgHTML('<h3>Se ha restablecido su contraseña</h3><p>Su nueva contraseña es: <b>"'.$contrasena.'".</b></p>');
        // adjuntos
        //$mail->addAttachment("adjunto.txt");
        // destinatario
        $address = $destinatario;
        $mail->AddAddress($address, "Test");
        // enviar
        $resul = $mail->Send();
        if(!$resul) {
        echo "Error" . $mail->ErrorInfo;
        } else {
        echo "Enviado";
        }
    }
    
    public static function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
?>