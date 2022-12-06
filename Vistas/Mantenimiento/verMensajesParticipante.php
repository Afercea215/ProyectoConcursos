<?php
if (Sesion::estaLogeado()) {
    if (Sesion::esAdmin()) {
        //si es admin, todo lo de edicion
        $validacion = new Validacion();
        $edicionActiva;
        //si hay info en post para validar
        if (isset($_POST['submit']) && isset($_GET['accion'])) {
            $validacion->Requerido('id');
            $validacion->Requerido('fecha');
            $validacion->Requerido('banda');
            $validacion->Requerido('modo');
            $validacion->Requerido('emisor');
            $validacion->Requerido('receptor');
            $validacion->Requerido('valido');
            
            //si no se valida se imprimen los datos con errores
            if (!$validacion->ValidacionPasada()) {
                if ($_GET['accion']=='edita') {
                    imprimeEdicion($_GET['id'],$_GET['idConcurso'],$validacion);
                }else if ($_GET['accion']=='crea') {
                    //imprimeCreacion($validacion);
                }
                //si la pasa se actualiza o crea en la bd
            }else{
                if ($_GET['accion']=='edita') {
                    //envio la id tb
                    $_POST['id']=$_GET['ididMensaje'];
                    RepositorioQso::update(Qso::arrayToQso($_POST));
                    header('location:./?menu=listadoConcursos');
                }else if ($_GET['accion']=='crea') {
                    $qso=Qso::arrayToQso($_POST);
                    RepositorioQso::add($qso);
                    header('location:./menu=listadoConsursos');
                }
            }
            //si quiere editar se imprime el form
        }else if (isset($_GET['idMensaje']) && isset($_GET['accion']) && $_GET['accion']=='edita') {
            imprimeEdicion($_GET['idMensaje'], $_GET['idConcurso']);
        }
    }

    if (isset($_GET['idParticipante']) && isset($_GET['idConcurso'])) {
        $idParticipante = $_GET['idParticipante'];
        $idConcurso = $_GET['idConcurso'];

        $pagParticipantes = isset($_GET['pag'])?$_GET['pag']:'1';
        $crecimientoParticipantes= isset($_GET['crecimiento'])?$_GET['crecimiento']:'desc';
        $orderByParticipantes= isset($_GET['orderBy'])?$_GET['orderBy']:'fecha';
        $mensajes = RepositorioConcurso::getMensajesParticipante($idParticipante,$idConcurso,$orderByParticipantes,$crecimientoParticipantes,$pagParticipantes,10);
    
    }else{header('location:./?menu=listadoConcursos');}

}else{
    header('location:/?menu=login');
}
$emisor = RepositorioParticipante::getById($idParticipante);
?>
<h2>Mensajes de <?php echo $emisor->getNombre()?></h2>
<!-- tabla qsos -->
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
        <?php
        //datos tabla
        for ($i=0; $i <sizeof($mensajes) ; $i++) { 
            $banda = RepositorioBanda::getById($mensajes[$i]->getBanda_id());
            $modo = RepositorioModo::getById($mensajes[$i]->getModo_id());

            echo '<tr>';
                echo '<td>'.$mensajes[$i]->getId().'</td>';
                echo '<td>'.$mensajes[$i]->getFecha()->format('Y-m-d H:i:s').'</td>';
                echo '<td>'.$banda->getDistancia().'m Rango : '.$banda->getRangoMin().' - '.$banda->getRangoMax().'</td>';
                echo '<td>'.$modo->getNombre().'</td>';
                echo '<td>'.$emisor->getNombre().'</td>';
                echo '<td>'.'to do'.'</td>';
                echo '<td>'.(($mensajes[$i]->getValido())?'Si':'No').'</td>';
                if (Sesion::esAdmin()) {
                    echo '<td><a href="./?menu=verMensajesParticipante&idParticipante='.$idParticipante.'&idConcurso='.$idConcurso.'&accion=edita&idMensaje='.$mensajes[$i]->getId().'"><img src="../../img/iconoLapiz.png"></a>';
                    echo '<td><a href="./controladores/eliminaMensaje.php?id='.$mensajes[$i]->getId().'"><img src="../../img/logoPapelera.png"></a>';
                }
                //si es juez del este concurso
                 if (RepositorioParticipante::esJuez(Sesion::leer('usuario')->getId(),$idConcurso)) {
                    echo '<td><a href="./controladores/aprobarMensaje.php?id='.$mensajes[$i]->getId().'"><img src="../../img/aprobar.png"></a>';
                }
                //echo '<td><a href="./?menu=verConcurso&id='.$bandas[$i]->getId().'"><img src="../../img/iconoOjo.png"></a>';
                // echo '<td><a href="./controladores/eliminaConcurso.php?id='.$bandas[$i]->getId().'"><img src="../../img/logoPapelera.png"></a>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>

<?php
    function imprimeEdicion($id, $idConcurso, $validacion=null){
        $mensaje = RepositorioQso::getById($id);
        echo '<form class="c-form--edicion animZoom" method="post" action="./?menu=listadoConcursos&accion=edita&id='.$id.'" enctype="multipart/form-data">
        <span>
            <img src="../../img/x.webp" alt="">
        </span>
    
        <div class="c-form__titulo">
        <h2 style="margin-bottom: 4%; margin-top: 4%;">Edicion Mensaje</h2>
        <hr>
        </div>
        
        <div class="c-form__componente">
            <label for="fecha">Fecha</label>
            <input type="datetime-local" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('fecha'):"").'" name="fecha" value="'.(($_POST['fecha'])??$mensaje->getFecha()->format('Y-m-d H:i:s')).'">
            '.(($validacion!=null)?$validacion->ImprimirError('fecha'):"").'
        </div>
        <div class="c-form__componente">
            <label for="modo">Modos</label>
            <select id="selecionaModos" name="modos" multiple>';
                $modosSeleccionados = RepositorioConcurso::getModos($idConcurso);
                $modos = RepositorioModo::getAll();
                //
                for ($i=0; $i < sizeof($modos); $i++) { 
                    $selected=false;
                    for ($j=0; $j < sizeof($modosSeleccionados); $j++) { 
                        if ($modos[$i]->getId()==$modosSeleccionados[$j]['id']) {
                            echo '<option selected value="'.$modos[$i]->getId().'">'.$modos[$i]->getNombre().'</option>';
                            $selected=true;
                        }
                    }
                    if (!$selected) {
                        echo '<option value="'.$modos[$i]->getId().'">'.$modos[$i]->getNombre().'</option>';
                    }
                }
echo '  </select>  
    </div>';

echo '<div class="c-form__componente">
            <label for="banda">Bandas</label>
            <select id="selecionaBandas" name="bandas" multiple>';
                $bandasSeleccionados = RepositorioConcurso::getBandas($idConcurso);
                $bandas = RepositorioBanda::getAll();

                for ($i=0; $i < sizeof($bandas); $i++) { 
                    $selected=false;
                    for ($j=0; $j < sizeof($bandasSeleccionados); $j++) { 
                        if ($bandas[$i]->getId()==$bandasSeleccionados[$j]->getId()) {
                            echo '<option selected value="'.$bandas[$i]->getId().'">'.$bandas[$i]->getDistancia().'m '.$bandas[$i]->getRangoMin().'Mhz - '.$bandas[$i]->getRangoMax().'Mhz</option>';
                            $selected=true;
                        }
                    }
                    if (!$selected) {
                        echo '<option value="'.$bandas[$i]->getId().'">'.$bandas[$i]->getDistancia().'m '.$bandas[$i]->getRangoMin().'Mhz - '.$bandas[$i]->getRangoMax().'Mhz</option>';
                    }
                }
        echo'</select>
        </div>';
        //EMISOR
    echo '<div class="c-form__componente">
            <label for="emisor">Emisor</label>
            <select id="selecionaEmisor" name="emisor" multiple>';
                $participantes = RepositorioConcurso::getParticipantes($idConcurso);
                $emisor = RepositorioQso::getEmisor($mensaje->getId());

                for ($i=0; $i < sizeof($participantes); $i++) { 
                    $selected=false;
                    
                    if ($participantes[$i]['participante']->getId()==$emisor->getId()) {
                        echo '<option selected value="'.$participantes[$i]['participante']->getId().'">'.$participantes[$i]['participante']->getNombre().'</option>';
                        $selected=true;
                    }
                    
                    if (!$selected) {
                        echo '<option value="'.$participantes[$i]['participante']->getId().'">'.$participantes[$i]['participante']->getNombre().'</option>';
                    }
                }
        echo'</select>
        </div>';
        //RECEPTOR
    echo '<div class="c-form__componente">
            <label for="receptor">Receptor</label>
            <select id="selecionaReceptor" name="receptor" multiple>';
                $jueces = RepositorioConcurso::getJueces($idConcurso);
                $receptor = RepositorioParticipante::getById($mensaje->getReceptor_id());

                for ($i=0; $i < sizeof($jueces); $i++) { 
                    $selected=false;
                    
                    if ($jueces[$i]->getId()==$receptor->getId()) {
                        echo '<option selected value="'.$participantes[$i]->getId().'">'.$participantes[$i]->getNombre().'</option>';
                        $selected=true;
                    }
                    
                    if (!$selected) {
                        echo '<option value="'.$participantes[$i]->getId().'">'.$participantes[$i]->getNombre().'</option>';
                    }
                }
        echo'</select>
        </div>';

        echo'<div class="c-form__footer">
            <hr>
            <button value="Guardar" name="submit" class="c-boton c-boton--secundario">Guardar</button>
        </div>
    </form>
    <div class="bgModal"></div>';

    }
?>
