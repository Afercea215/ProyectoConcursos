<?php
    //si quiere inscribe pero no esta logueado lo llevo a log
    if (isset($_GET['accion']) && $_GET['accion']=='inscribe' && !Sesion::estaLogeado()) {
        header('location:./?menu=login');
    }

    //inscribe
    if (isset($_GET['idConcurso']) && isset($_GET['accion']) && $_GET['accion']=='inscribe') {
        header('location: ./controladores/inscribeParticipante.php?idParticipante='.Sesion::leer('usuario')->getId().'&idConcurso='.$_GET['idConcurso']);
    }

    //filtar por finalizados o activos
    if (isset($_GET['ver']) && $_GET['ver']=='finalizados') {
        $activos=false;
    }else{
        $activos=true;
    }
?>
<h2>Concursos</h2>

<div class="c-listado g-shadow--4">
    <div class="c-listado__pestanas">
        <?php
            if ($activos) {
                echo '
                <span class="c-pestana-activa"><a href="./?menu=concursos&ver=activos">Activos</a></span>
                <span class="c-pestana-inactiva"><a href="./?menu=concursos&ver=finalizados">Finalizados</a></span>
                ';
            }else{
                echo '
                <span class="c-pestana-inactiva"><a href="./?menu=concursos&ver=activos">Activos</a></span>
                <span class="c-pestana-activa"><a href="./?menu=concursos&ver=finalizados">Finalizados</a></span>
                ';
            }
        ?>
    </div>
    <?php
        if ($activos) {
            $concursos = RepositorioConcurso::getActivos();
        }else{
            $concursos = RepositorioConcurso::getFinalizados();
        }

        for ($i=0; $i < sizeof($concursos); $i++) { 
            if ($concursos[$i]->getCartel()=='') {
                $imagen = '../../img/cartelDefault.png';
            }else{
                $imagen = $concursos[$i]->getCartel();
            }
            $nombre = $concursos[$i]->getNombre();
            $desc = $concursos[$i]->getDescrip();
            $fini = 'Inicio :'.$concursos[$i]->getFIni()->format('d/m/Y');
            $ffin = '- Fin :'.$concursos[$i]->getFFin()->format('d/m/Y');
            if ($activos) {
                if (Sesion::estaLogeado() && RepositorioConcurso::participanteEstaInscrito($concursos[$i]->getId(),Sesion::leer('usuario')->getId())) {
                    $boton ='<span class="c-boton c-boton--secundario">Estas inscrito</span>'.
                    '<span class=""><a href="./?menu=verConcurso&id='.$concursos[$i]->getId().'">Ver concurso</a></span>';
                }else{
                    $boton = '<span class="c-boton c-boton--secundario"><a href="./?menu=concursos&idConcurso='.$concursos[$i]->getId().'&accion=inscribe">Incribirse</a></span>'
                            .'<span class=""><a href="./?menu=verConcurso&id='.$concursos[$i]->getId().'">Ver concurso</a></span>';
                }
            }else{
                $boton = '<span class="c-boton c-boton--secundario"><a href="./?menu=verConcurso&id='.$concursos[$i]->getId().'">Ver concurso</a></span>';
            }

            echo <<<EOT
                    <div class='c-panel'>
                        <div class='c-panel__texto'>
                            <h2>$nombre</h2>
                            <p>$desc</p>
                            <div class="c-panel__texto__fechas">
                                <span>$fini</span>
                                <span>$ffin</span>
                            </div>
                            $boton
                        </div>
                        <img src="$imagen">
                    </div>
                EOT;
        }
    ?>
</div>