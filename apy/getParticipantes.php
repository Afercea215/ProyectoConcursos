<?php
require_once("../autoCargadores/autoCargador.php");

$participantes=RepositorioParticipante::getAllArray();  
//var_dump($participantes);
echo json_encode($participantes);
?>