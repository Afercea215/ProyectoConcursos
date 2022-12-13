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
        
        if (isset($_GET['accion']) && $_GET['accion']=='eliminaMensaje') {
            echo '
            <div class="c-modalSeguro animZoom">
                <span><a href="./?menu=verConcurso&id='.$_GET['id'].'"><img src="./img/x.webp"></a></span>
                <h2>Atención!</h2>
                <p>¿Estas segudo de realizar esta acción?</p>
                <div>
                    <span id="btnSi"><a href="./controladores/eliminaMensaje.php?id='.$_GET['idMensaje'].'&idConcurso='.$_GET['id'].'">Si</a></span>
                    <span id="btnNo"><a href="./?menu=verConcurso&id='.$_GET['id'].'">No</a></span>
                </div>
            </div>
            <div class="bgModal"></div>
        ';
        }
        
    }else{header('location:./?menu=listadoConcursos');}
    ?>

<h2 class="g-marg-bottom--0">Concurso <?php echo $concurso->getNombre() ?></h2>
<?php
    $concurso = RepositorioConcurso::getById($_GET['id']);
    echo '<span id="contador" data-fecha="'.$concurso->getFFin()->format('Y-m-d H:i:s').'"></span>';

    if ($concurso->getCartel()=='') {
        $imagen = '../../img/cartelDefault.png';
    }else{
        $imagen = $concurso->getCartel();
    }
    $nombre = $concurso->getNombre();
    $desc = $concurso->getDescrip();
    $fini = 'Inicio :'.$concurso->getFIni()->format('d/m/Y');
    $ffin = '- Fin :'.$concurso->getFFin()->format('d/m/Y');

    $btnResult = "";

    if ($concurso->getFfin() < (new Datetime())) {
        $btnResult = '<a href="./?menu=resultados&id='.$concurso->getId().'"><span class="c-boton c-boton--secundario g-marg-top--2">Ver resultados</span></a>';
    }
    
    echo <<<EOT
            <div class='c-panel c-panel--pequeno'>
            <div class='c-panel__texto'>
                <h2>$nombre</h2>
                <p>$desc</p>
                <div class="c-panel__texto__fechas">
                    <span>$fini</span>
                    <span>$ffin</span>
                </div>
                $btnResult
            </div>
            <img src="$imagen">
        </div>
    EOT;
?>
<!-- imprimir datos de un concurso
 -->
 <div class="c-verConcurso">
     <section id="bandas">
    
        <h3>Bandas</h3>
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
     </section>

     <section id="bandas">
    
        <h3>Bandas</h3>
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
     </section>
    
    <section id="modos">
        <h3>Modos</h3>
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
    </section>
    
    <section id="participantes">
    
        <h3>Participantes</h3>
        <?php if (!($participantes)) {
            echo '<h3 class="errorTexto">Este concurso no tiene participantes actualmente</h3>';
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
                        if (Sesion::estaLogeado() && Sesion::esAdmin()) {
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
    </section>
    
    <section id="mensajes">
        <h3>Mensajes</h3>
        <!-- tabla qsos -->
        <?php
        if (Sesion::estaLogeado() && RepositorioConcurso::participanteEstaInscrito($_GET['id'],Sesion::leer('usuario')->getId())) {
            echo '<span>';
        }
        
        if (!($qsos)) {
            echo '<h3 class="errorTexto">Este concurso no tiene mensajes actualmente</h3>';
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
                    $receptor = RepositorioParticipante::getById($qsos[$i]['qso']->getReceptor_id());
                    echo '<td>'.$receptor->getNombre().'</td>';
                    echo '<td>'.(($qsos[$i]['qso']->getValido())?'Si':'No').'</td>';
                    if (Sesion::estaLogeado() && Sesion::esAdmin()) {
                        echo '<td><a href="./?menu=verConcurso&id='.$_GET['id'].'&accion=eliminaMensaje&idMensaje='.$qsos[$i]['qso']->getId().'"><img src="../../img/logoPapelera.png"></a>';
                    }
                    //si es juez del este concurso y receptor de ese mensaje y mensaje no valido
                    if (Sesion::estaLogeado() && RepositorioParticipante::esJuez(Sesion::leer('usuario')->getId(),$_GET['id']) && $receptor->getId()==Sesion::leer('usuario')->getId() && !$qsos[$i]['qso']->getValido()) {
                        echo '<td><a href="./controladores/aprobarMensaje.php?id='.$qsos[$i]['qso']->getId().'&idConcurso='.$concurso->getId().'"><img src="../../img/martillo.png"></a>';
                    }else if($qsos[$i]['qso']->getValido()){
                        echo '<td><img src="../../img/aprobar.png"></td>';
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
    </section>
 </div>

        