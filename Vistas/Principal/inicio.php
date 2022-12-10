
<section class="c-inicio">
    <img src="../../img/logo-azul.png" alt="">
    <h1>Los mejores concursos de radiofrecuencias para aficionados</h1>
    <p> lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu lorem ipsu </p>

    <?php
        $concurso = RepositorioConcurso::getUltimoActivo();
        if ($concurso->getCartel()=='') {
            $imagen = '../../img/cartelDefault.png';
        }else{
            $imagen = $concurso->getCartel();
        }
        $nombre = $concurso->getNombre();
        $desc = $concurso->getDescrip();
        $fini = 'Inicio :'.$concurso->getFIni()->format('d/m/Y');
        $ffin = '- Fin :'.$concurso->getFFin()->format('d/m/Y');
        
        $boton = '<span class="c-boton c-boton--secundario"><a href="./?menu=concursos&idConcurso='.$concurso->getId().'">Incribirse</a></span>'
                .'<span class=""><a href="./?menu=verConcurso&id='.$concurso->getId().'">Ver concurso</a></span>';

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
    ?>
</section>