<?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $concurso = RepositorioConcurso::getById($id);

        $pagModos = isset($_GET['pagModos'])?$_GET['pagModos']:'1';
        $crecimientoModos= isset($_GET['crecimientoModos'])?$_GET['crecimientoModos']:'asc';
        $orderByModos= isset($_GET['orderByModos'])?$_GET['orderByModos']:'id';
        $modos = RepositorioConcurso::getModos($id);
        
        $pagBandas = isset($_GET['pagBandas'])?$_GET['pagBandas']:'1';
        $crecimientoBandas= isset($_GET['crecimientoBandas'])?$_GET['crecimientoBandas']:'asc';
        $orderByBandas= isset($_GET['orderByBandas'])?$_GET['orderByBandas']:'id';
        $bandas = RepositorioConcurso::getBandas($id);
        
        $pagParticipantes = isset($_GET['pagParticipantes'])?$_GET['pagParticipantes']:'1';
        $crecimientoParticipantes= isset($_GET['crecimientoParticipantes'])?$_GET['crecimientoParticipantes']:'asc';
        $orderByParticipantes= isset($_GET['orderByParticipantes'])?$_GET['orderByParticipantes']:'id';
        $participantes = RepositorioConcurso::getParticipantes($id);
        
        $pagQso = isset($_GET['pagQso'])?$_GET['pagQso']:'1';
        $crecimientoQso= isset($_GET['crecimientoQso'])?$_GET['crecimientoQso']:'desc';
        $orderByQso= isset($_GET['orderByQso'])?$_GET['orderByQso']:'fecha';
        $qsos = RepositorioConcurso::getMensajes($id,$orderByQso,$crecimientoQso,$pagQso,10);
        
    }else{header('location:./?menu=listadoConcursos');}
?>
<!-- imprimir datos de un concurso
 -->
<h2>Bandas</h2>
 <!-- Tabla bandas -->
 <?php if (!$bandas) {
    echo '<h3 class="errorTexto">Este concurso no tiene modos actualmente</h3>';
}else{
    echo <<<EOT
    <table class="c-tabla">
        <thead>
            <tr>
                <th>Id</th>
                <th>Distancia</th>
                <th>Rango Minimo</th>
                <th>Rango Maximo</th>
            </tr>
        </thead>
        <tbody>
    EOT;
    //datos tabla
    for ($i=0; $i <sizeof($bandas) ; $i++) { 
        echo '<tr>';
        echo '<td>'.$bandas[$i]->getId().'</td>';
        echo '<td>'.$bandas[$i]->getDistancia().'</td>';
        echo '<td>'.$bandas[$i]->getRangoMin().'</td>';
        echo '<td>'.$bandas[$i]->getRangoMin().'</td>';
        //echo '<td><a href="./?menu=verConcurso&id='.$bandas[$i]->getId().'"><img src="../../img/iconoOjo.png"></a>';
        //echo '<td><a href="./?menu=listadoConcursos&accion=edita&id='.$bandas[$i]->getId().'"><img src="../../img/iconoLapiz.png"></a>';
        // echo '<td><a href="./controladores/eliminaConcurso.php?id='.$bandas[$i]->getId().'"><img src="../../img/logoPapelera.png"></a>';
    
        echo '</tr>';
       }

    echo '
       </tbody>
       </table>';
}
?>


 <h2>Modos</h2>
<!-- tabla modos -->
<?php if (!($modos)) {
    echo '<h3 class="errorTexto">Este concurso no tiene modos actualmente</h3>';
}else{
    echo <<<EOT
    <table class="c-tabla">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Premio</th>
        </tr>
    </thead>
    <tbody>
    EOT;
    //datos tabla
    for ($i=0; $i <sizeof($modos) ; $i++) { 
        echo '<tr>';
            echo '<td>'.$modos[$i]['id'].'</td>';
            echo '<td>'.$modos[$i]['nombre'].'</td>';
            echo '<td>'.$modos[$i]['premio'].'</td>';
            //echo '<td><a href="./?menu=verConcurso&id='.$bandas[$i]->getId().'"><img src="../../img/iconoOjo.png"></a>';
            //echo '<td><a href="./?menu=listadoConcursos&accion=edita&id='.$bandas[$i]->getId().'"><img src="../../img/iconoLapiz.png"></a>';
            // echo '<td><a href="./controladores/eliminaConcurso.php?id='.$bandas[$i]->getId().'"><img src="../../img/logoPapelera.png"></a>';
        echo '</tr>';
    }

    echo <<<EOT
        </tbody>
    </table>
    EOT;
}

?>

<h2>Mensajes</h2>
<!-- tabla qsos -->
<?php if (!($qsos)) {
    echo '<h3 class="errorTexto">Este concurso no tiene bandas actualmente</h3>';
}else{
    echo <<<EOT
    <table class="c-tabla">
        <thead>
            <tr>
                <th>Id</th>
                <th>Fecha</th>
                <th>Banda</th>
                <th>Modo</th>
                <th>Nombre Emisor</th>
                <th>Nombre Receptor</th>
                <th>Valido</th>
            </tr>
        </thead>
        <tbody>
    EOT;
    //datos tabla
    for ($i=0; $i <sizeof($qsos) ; $i++) { 
        echo '<tr>';
            echo '<td>'.$qsos[$i]['qso']->getId().'</td>';
            echo '<td>'.$qsos[$i]['qso']->getFecha()->format('Y-m-d H:i:s').'</td>';
            echo '<td>'.$qsos[$i]['banda'][0].'m Rango : '.$qsos[$i]['banda'][1].' - '.$qsos[$i]['banda'][2].'</td>';
            echo '<td>'.$qsos[$i]['modo'].'</td>';
            echo '<td>'.$qsos[$i]['emisor'].'</td>';
            echo '<td>'.'to do'.'</td>';
            echo '<td>'.(($qsos[$i]['qso']->getValido())?'Si':'No').'</td>';
            if (Sesion::esAdmin()) {
                echo '<td><a href="./controladores/eliminaMensaje.php?id='.$qsos[$i]['qso']->getId().'"><img src="../../img/logoPapelera.png"></a>';
            }
            //si es juez del este concurso
            if (RepositorioParticipante::esJuez(Sesion::leer('usuario')->getId(),$_GET['id'])) {
                echo '<td><a href="./controladores/aprobarMensaje.php?id='.$qsos[$i]['qso']->getId().'"><img src="../../img/aprobar.png"></a>';
            }
            //echo '<td><a href="./?menu=verConcurso&id='.$bandas[$i]->getId().'"><img src="../../img/iconoOjo.png"></a>';
            //echo '<td><a href="./?menu=listadoConcursos&accion=edita&id='.$bandas[$i]->getId().'"><img src="../../img/iconoLapiz.png"></a>';
            // echo '<td><a href="./controladores/eliminaConcurso.php?id='.$bandas[$i]->getId().'"><img src="../../img/logoPapelera.png"></a>';
        echo '</tr>';
    }
    echo '
    </tbody>
    </table>';
}
 ?>


<h2>Participantes</h2>
<?php if (!($qsos)) {
    echo '<h3 class="errorTexto">Este concurso no tiene bandas actualmente</h3>';
}else{
    echo <<<EOT
    <table class="c-tabla">
    <thead>
        <tr>
            <th>Id</th>
            <th>Identificador</th>
            <th>Administrador</th>
            <th>Correo</th>
            <th>Localizacion</th>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Juez</th>
        </tr>
    </thead>
    <tbody>
    EOT;
        
        //datos tabla
        for ($i=0; $i <sizeof($participantes) ; $i++) { 
            echo '<tr>';
                echo '<td>'.$participantes[$i]['participante']->getId().'</td>';
                echo '<td>'.$participantes[$i]['participante']->getIdentificador().'</td>';
                echo '<td>'.(($participantes[$i]['participante']->getAdmin()?'Si':'No')).'</td>';
                echo '<td>'.$participantes[$i]['participante']->getCorreo().'</td>';
                echo '<td>X: '.$participantes[$i]['participante']->getLocalizacion()->getX().', Y: '.$participantes[$i]['participante']->getLocalizacion()->getY().' </td>';
                echo '<td><img src="'.$participantes[$i]['participante']->getImagen().'"></td>';
                echo '<td>'.$participantes[$i]['participante']->getNombre().'</td>';
                echo '<td>'.(($participantes[$i]['juez'])?'Si':'No').'</td>';
                if (Sesion::esAdmin()) {
                    echo '<td><a href="./controladores/eliminaParticipanteConcurso.php?idParticipante='.$participantes[$i]['participante']->getId().'&idConcurso='.$_GET['id'].'"><img src="../../img/logoPapelera.png"></a>';
                }
                echo '<td><a href="./?menu=verMensajesParticipante&idParticipante='.$participantes[$i]['participante']->getId().'&idConcurso='.$_GET['id'].'"><img src="../../img/iconoOjo.png"></a>';
                //echo '<td><a href="./?menu=listadoConcursos&accion=edita&id='.$bandas[$i]->getId().'"><img src="../../img/iconoLapiz.png"></a>';
                // echo '<td><a href="./controladores/eliminaConcurso.php?id='.$bandas[$i]->getId().'"><img src="../../img/logoPapelera.png"></a>';
            echo '</tr>';
        }
        echo'
        </tbody>
    </table>';
}
        ?>
        