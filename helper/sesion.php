<?php
class Sesion
{
    public static function iniciar()
    {
        session_start();
    }

    public static function leer(string $clave)
    {
        return isset($_SESSION[$clave])?$_SESSION[$clave]:false;
    }

    public static function recordarSesion($usuario, $contrasena){
        setcookie('recuerdame',true);
        setcookie('usuario',$usuario);
        setcookie('contrasena',$contrasena);
    }
    
    public static function estaLogeado(){
        return isset($_SESSION['usuario']);
    }

    public static function iniciaSesion($participante, $recuerdame=false){
        
        if ($participante) {
            Sesion::escribir('usuario',$participante->getNombre());
            Sesion::escribir('rol',$participante->getAdmin());
            Sesion::escribir('imagen',$participante->getImagen());

            if ($recuerdame) {
                Sesion::recordarSesion($participante->getNombre(), $participante->getContrasena());
            }
        }
        //Sesion::escribir('identificador',$identificador);
    }

    public static function esAdmin()
    {
        return Sesion::leer('rol');
    }

    public static function existe(string $clave)
    {
        return isset($_SESSION[$clave]);
    }

    public static function escribir($clave,$valor)
    {
        $_SESSION[$clave]=$valor;
    }

    public static function eliminar($clave)
    {
        unset($_SESSION[$clave]);
    }

    public static function terminar()
    {
        session_destroy();
        if (isset($_COOKIE['usuario'])) {
            setcookie('usuario', null, -1, '/'); 
        }
        if (isset($_COOKIE['recuerdame'])) {
            setcookie('recuerdame', null, -1, '/'); 
        }
        if (isset($_COOKIE['contrasena'])) {
            setcookie('contrasena', null, -1, '/'); 
        }
    }
}