<?php
class Login
{
    //funcion verificar si es admin
    public static function usuarioEsAdmin(){
        if (sesion::leer('rol')=="admin") {
            return true;
        } else{
            return false;
        }
    }

    //es el login en si, comprueba si existe y crea el la sesion con los datos
    public static function identifica(string $usuario,string $contrasena, bool $recuerdame)
    {
        $participante = RepositorioParticipante::getByNombreContra($usuario,$contrasena);  

        if ($participante) {
            Sesion::iniciaSesion($participante,$recuerdame);
            return $participante;
        }else{
            return false;
        }
    }

    private static function existeUsuario(string $usuario,string $contrasena=null)
    {
        return RepositorioParticipante::getByNombreContra($usuario, $contrasena)!=null;
    }

    public static function usuarioEstaLogueado()
    {
        return sesion::existe('user');
    }
}