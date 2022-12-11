<?php
    if (isset($_GET['id'])) {
        $concurso = RepositorioConcurso::getById($_GET['id']);

        if ($concurso == null || $concurso->getFFin() > (new DateTime())) {
            header('location:./?menu=concurso');
        }

        $participantes = RepositorioConcurso::getParticipantes($_GET['id']);

        $ganadoresOro=[];
        $ganadoresPlata=[];
        $ganadoresBronce=[];

        //compruebo cada participante
        for ($i=0; $i < sizeof($participantes); $i++) { 
            $mensajes = RepositorioConcurso::getMensajesParticipante($participantes[$i]['participante']->getId(),$_GET['id'],'id','asc','1',999);
            $cont = 0;
            //cuento sus mensajes validados
            for ($j=0; $j < sizeof($mensajes); $j++) { 
                if ($mensajes[$j]->getValido()) {
                    $cont++;
                }
            }

            //metos los ganadors
            if ($cont >= 5) {
                $ganadoresOro[]=$participantes[$i]['participante'];
            }else if($cont >= 3){
                $ganadoresPlata[]=$participantes[$i]['participante'];
            }else if($cont >= 1){
                $ganadoresBronce[]=$participantes[$i]['participante'];
            }
        }

    }
?>
<h2>Resultados Concurso</h2>
<?php
if (Sesion::estaLogeado()) {
    $tieneDiploma = false;
    $tipoPremio = "";
    for ($i=0; $i < sizeof($ganadoresOro); $i++) { 
        if ($ganadoresOro[$i]->getId()==Sesion::leer('usuario')->getId()) {
            $tieneDiploma=true;
            $tipoPremio='Oro';
        }
    }
    for ($i=0; $i < sizeof($ganadoresPlata); $i++) { 
        if ($ganadoresPlata[$i]->getId()==Sesion::leer('usuario')->getId()) {
            $tieneDiploma=true;
            $tipoPremio='Plata';
        }
    }
    for ($i=0; $i < sizeof($ganadoresBronce); $i++) { 
        if ($ganadoresBronce[$i]->getId()==Sesion::leer('usuario')->getId()) {
            $tieneDiploma=true;
            $tipoPremio='Bronce';
        }
    }

    if ($tieneDiploma) {
        echo '<h3>Felicidades has ganado un diploma</h3>';
        echo '<a class="c-boton c-boton--secundario" href="./Vistas/Mantenimiento/diploma.php?idParticipante='.Sesion::leer('usuario')->getId().'&idConcurso='.$_GET['id'].'&premio='.$tipoPremio.'">Ver diploma</a>';
        //si tiene diploma le pongo el boton
    }
}
?>
<div id="resultados" class="c-resultados">
    <div class="c-resultados__plata">
        <h2>Ganadores Diploma de plata</h2>
        <?php
            for ($i=0; $i < sizeof($ganadoresPlata); $i++) { 
                echo '<p>'.$ganadoresPlata[$i]->getNombre().'</p>';
            }
        ?>
    </div>
    <div class="c-resultados__oro">
        <h2>Ganadores Diploma de oro</h2>
        <?php
            for ($i=0; $i < sizeof($ganadoresOro); $i++) { 
                echo '<p>'.$ganadoresOro[$i]->getNombre().'</p>';
            }
        ?>
    </div>
    <div class="c-resultados__bronce">
        <h2>Ganadores Diploma de oro</h2>
        <?php
            for ($i=0; $i < sizeof($ganadoresBronce); $i++) { 
                echo '<p>'.$ganadoresBronce[$i]->getNombre().'</p>';
            }
        ?>
    </div>
</div>


<div class="c-ganadores-modos">
<?php
    //calculo ganadores modos
    $modos = RepositorioConcurso::getModos($_GET['id']);
    for ($i=0; $i < sizeof($modos) ; $i++) { 
        $idGanador = RepositorioConcurso::getGandorModo($modos[$i]['id'],$_GET['id']);
        if ($idGanador=="" || $idGanador==null) {
            echo '<div>
                    <h3>No hay mensajes en este modo</h3>
                  </div>';
        }else{
            $ganador = RepositorioParticipante::getById($idGanador);
            echo '<div>
                    <h3>Ganador del Modo '.$modos[$i]['nombre'].'</h3>
                    <p>'.$ganador->getNombre().'</p>
                </div>';

        }
    }
?>

</div>