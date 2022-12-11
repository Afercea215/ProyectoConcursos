<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Concursos</title>
    <script src="../../js/api/getDatos.js"></script>
    <script src="../../js/objs/tabla.js"></script>
    <script src="../../js/listados/listadoParticipantes.js"></script>
    <script src="../../js/listados/listadoBandas.js"></script>
    <script src="../../js/listados/listadoModos.js"></script>
    <script src="../../js/errores.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../../js/gestionDOM/cerrarVentana.js"></script>
    
    <link rel="stylesheet" href="../../css/main.css">
</head>

<body>
    <?php
        require_once './Vistas/Principal/header.php';
        ?>
    <main id="cuerpo">
        <?php
        require_once './Vistas/Principal/enruta.php';
        ?>
    </main>
    
    <?php
        require_once './Vistas/Principal/footer.php';
    ?>

    <script src="../../js/objs/menu.js"></script>
    <script src="../../js/validacion/valida.js"></script>
    <script src="../../js/api/gestionParticipantesConcurso.js"></script>
    <script src="../../js/gestionDOM/capturaLocalizacion.js"></script>
    <script src="../../js/gestionDOM/capturarFoto.js"></script>
    <script src="../../js/contadorConcurso.js"></script>
    <script src="../../js/gestionDOM/imprime.js"></script>
    <script src="../../js/gestionDOM/descarga.js"></script>

</body>

</html>