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

    public static function recordarSesion($participante){
        setcookie('recuerdame',true);
        setcookie('usuario',$participante->getNombre());
        setcookie('contrasena',$participante->getContrasena());
    }
    
    public static function estaLogeado(){
        return isset($_SESSION['usuario']);
    }

    public static function iniciaSesion($participante, $recuerdame=false){
        
        if ($participante) {
            Sesion::escribir('usuario',$participante);

            if ($recuerdame) {
                Sesion::recordarSesion($participante);
            }
        }
        //Sesion::escribir('identificador',$identificador);
    }

    public static function esAdmin()
    {
        return Sesion::leer('usuario')->getAdmin();
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