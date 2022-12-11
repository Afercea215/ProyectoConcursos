<?php
    require_once '../../autoCargadores/autoCargador.php';
    $participante = RepositorioParticipante::getById($_GET['idParticipante']);
    $concurso = RepositorioConcurso::getById($_GET['idConcurso']);
    $tipoPremio = $_GET['premio'];

    require_once '../../vendor/autoload.php';
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();
    ob_start();
    if ($tipoPremio=='Oro') {
        include './baseDiplomaOro.php';
    }
    if ($tipoPremio=='Plata') {
        include './baseDiplomaPlata.php';
    }
    if ($tipoPremio=='Bronce') {
        include './baseDiplomaBronce.php';
    }

    $html = ob_get_clean();
    $dompdf->loadHtml($html);
    $dompdf->render();

    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename=diploma.pdf');

    echo $dompdf->output();
?>