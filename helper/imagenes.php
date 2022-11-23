<?php
class Imagenes{
    public static function imgToBase64 ($ruta):string{
        $type = pathinfo($ruta, PATHINFO_EXTENSION);
        $data = file_get_contents($ruta);
        $base64 = 'data:image/png;base64,' . base64_encode($data);
        return $base64;
    }
}
?>