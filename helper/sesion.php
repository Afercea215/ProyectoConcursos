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
    
    /**
     * recordarSesion
     * Inserta una cookie con los datos de la sesion
     * @param  mixed $participante
     * @return void
     */
    public static function recordarSesion($participante){
        setcookie('recuerdame',true);
        setcookie('usuario',$participante->getNombre());
        setcookie('contrasena',$participante->getContrasena());
    }
        
    /**
     * estaLogeado
     * Comprueba si esta logeado
     * @return void
     */
    public static function estaLogeado(){
        return isset($_SESSION['usuario']);
    }
    
    /**
     * iniciaSesion
     * Inicia sesion con los datos de participante
     * @param  mixed $participante Participante
     * @param  mixed $recuerdame
     * @return void
     */
    public static function iniciaSesion($participante, $recuerdame=false){
        
        if ($participante) {
            Sesion::escribir('usuario',$participante);

            if ($recuerdame) {
                Sesion::recordarSesion($participante);
            }
        }
        //Sesion::escribir('identificador',$identificador);
    }
    
    /**
     * esAdmin
     * Comprueba si es admin
     * @return void
     */
    public static function esAdmin()
    {
        return Sesion::leer('usuario')->getAdmin();
    }

    
    /**
     * existe
     * Comprueba si existe un valor de la sesion
     * @param  mixed $clave
     * @return bool
     */
    public static function existe(string $clave):bool
    {
        return isset($_SESSION[$clave]);
    }

    public static function escribir($clave,$valor)
    {
        $_SESSION[$clave]=$valor;
    }

        
    /**
     * eliminar
     * Elimina un dato de la sesion
     * @param  mixed $clave
     * @return void
     */
    public static function eliminar($clave)
    {
        unset($_SESSION[$clave]);
    }
    
    /**
     * terminar
     * Termino la sesion
     * @return void
     */
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