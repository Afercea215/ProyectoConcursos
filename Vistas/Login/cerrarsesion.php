<?php
Sesion::iniciar();
setcookie('recuerdame',false,time()-10);
Sesion::terminar();
header("location: ./?menu=inicio");
?>