<?php
    function miAutocargador($class) {
        if (file_exists($_SERVER["DOCUMENT_ROOT"]."Clases/".$class.".php")){
            include $_SERVER["DOCUMENT_ROOT"]."Clases/".$class.".php";
        }
        if (file_exists($_SERVER['DOCUMENT_ROOT']."helper/".$class.".php")){
            include $_SERVER['DOCUMENT_ROOT']."helper/".$class.".php";
        }
    }
    
    spl_autoload_register('miAutocargador');
?>