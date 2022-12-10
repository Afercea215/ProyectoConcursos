<?php
if (Sesion::estaLogeado()) {
    //si hay datos para mostrar los mmuestro
    if (isset($_GET['idParticipante']) && isset($_GET['idConcurso'])) {
        $idParticipante = $_GET['idParticipante'];
        $idConcurso = $_GET['idConcurso'];

        $pagParticipantes = isset($_GET['pag'])?$_GET['pag']:'1';
        $crecimientoParticipantes= isset($_GET['crecimiento'])?$_GET['crecimiento']:'desc';
        $orderByParticipantes= isset($_GET['orderBy'])?$_GET['orderBy']:'fecha';
        $mensajes = RepositorioConcurso::getMensajesParticipante($idParticipante,$idConcurso,$orderByParticipantes,$crecimientoParticipantes,$pagParticipantes,10);
    
        if (isset($_GET['accion']) && $_GET['accion']=='borra') {
            echo '
            <div class="c-modalSeguro animZoom">
                <span><a href="./?menu=listadoConcursos"><img src="./img/x.webp"></a></span>
                <h2>Atención!</h2>
                <p>¿Estas segudo de realizar esta acción?</p>
                <div>
                    <span id="btnSi"><a href="./controladores/eliminaMensaje.php?id='.$_GET['id'].'&idParticipante='.$_GET['idParticipante'].'&idConcurso='.$_GET['idConcurso'].'">Si</a></span>
                    <span id="btnNo"><a href="./?menu=verMensajesParticipante&idParticipante='.$_GET['idParticipante'].'&idConcurso='.$_GET['idConcurso'].'">No</a></span>
                </div>
            </div>
            <div class="bgModal"></div>
        ';
        }

    }else{header('location:./?menu=listadoConcursos');}

    //si es admin, todo lo de edicion
    $validacion = new Validacion();
    $edicionActiva;
    //si hay info en post para validar
    if (isset($_POST['submit']) && isset($_GET['accion'])) {
        $validacion->Requerido('fecha');
       /*  $validacion->Requerido('banda');
        $validacion->Requerido('modo');
        $validacion->Requerido('emisor');
        $validacion->Requerido('receptor'); */
        
        //si no se valida se imprimen los datos con errores
        if (!$validacion->ValidacionPasada()) {
            if ($_GET['accion']=='edita') {
                imprimeEdicion($_GET['id'],$_GET['idConcurso'],$validacion);
            }else if ($_GET['accion']=='nuevo') {
                imprimeCreacion($_GET['idParticipante'], $_GET['idConcurso'], $validacion);
            }
            //si la pasa se actualiza o crea en la bd
        }else{
            if ($_GET['accion']=='edita') {
                //envio la id tb
                $_POST['id']=$_GET['idMensaje'];
                $participacion = RepositorioParticipacion::getByConcursoParticipante($_GET['idConcurso'],$_GET['idParticipante']);
                $_POST['participacion_id']=$participacion->getId();
                try {
                    RepositorioQso::update(Qso::arrayToQso($_POST));
                    header('location:./?menu=verMensajesParticipante&idParticipante='.$_GET['idParticipante'].'&idConcurso='.$_GET['idConcurso']);
                } catch (Exception $th) {
                    echo "a";
                }
            }else if ($_GET['accion']=='nuevo') {
                $participacion = RepositorioParticipacion::getByConcursoParticipante($_GET['idConcurso'],$_GET['idParticipante']);
                $_POST['participacion_id']=$participacion->getId();
                $qso=Qso::arrayToQso($_POST);
                try {
                    RepositorioQso::add($qso);
                    header('location:./?menu=verMensajesParticipante&idParticipante='.$_GET['idParticipante'].'&idConcurso='.$_GET['idConcurso']);
                } catch (Exception $th) {
                    echo "a";
                }
            }
        }
        //si quiere editar se imprime el form
    }else if (isset($_GET['idMensaje']) && isset($_GET['accion']) && $_GET['accion']=='edita') {
        imprimeEdicion($_GET['idMensaje'], $_GET['idConcurso']);
    }else if(isset($_GET['accion']) && $_GET['accion']=='nuevo'){
        imprimeCreacion($_GET['idParticipante'], $_GET['idConcurso']);
    }
}else{
    header('location:/?menu=login');
}
$emisor = RepositorioParticipante::getById($idParticipante);

if (Sesion::leer('usuario')->getId()==$emisor->getId()) {
    echo "<a class='c-boton' href='./?menu=verMensajesParticipante&idParticipante=".$emisor->getId()."&idConcurso=".$idConcurso."&accion=nuevo'>Nuevo Mensaje</a>";
}
?>
<h2>Mensajes de <?php echo $emisor->getNombre()?></h2>
<!-- tabla qsos -->

        <?php
        if (sizeof($mensajes)>0) {
            echo '<table class="c-tabla">
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
            <tbody>';
        }else{
            echo '<p class="error">Este participante no ha enviado ningun mensaje en este concurso</p>';
        }
        //datos tabla
        for ($i=0; $i <sizeof($mensajes) ; $i++) { 
            $banda = RepositorioBanda::getById($mensajes[$i]->getBanda_id());
             $modo = RepositorioModo::getById($mensajes[$i]->getModo_id());
            $receptor = RepositorioParticipante::getById($mensajes[$i]->getReceptor_id());

            echo '<tr>';
                echo '<td>'.$mensajes[$i]->getId().'</td>';
                echo '<td>'.$mensajes[$i]->getFecha()->format('Y-m-d H:i:s').'</td>';
                echo '<td>'.$banda->getDistancia().'m Rango : '.$banda->getRangoMin().' - '.$banda->getRangoMax().'</td>';
                echo '<td>'.$modo->getNombre().'</td>';
                echo '<td>'.$emisor->getNombre().'</td>';
                echo '<td>'.$receptor->getNombre().'</td>';
                echo '<td>'.(($mensajes[$i]->getValido())?'Si':'No').'</td>';
                if (Sesion::esAdmin()) {
                    echo '<td><a href="./?menu=verMensajesParticipante&idParticipante='.$idParticipante.'&idConcurso='.$idConcurso.'&accion=edita&idMensaje='.$mensajes[$i]->getId().'"><img src="../../img/iconoLapiz.png"></a>';
                    echo '<td><a href="./?menu=verMensajesParticipante&idParticipante='.$idParticipante.'&idConcurso='.$idConcurso.'&accion=borra&id='.$mensajes[$i]->getId().'"><img src="../../img/logoPapelera.png"></a>';
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
        echo '<form class="c-form--edicion animZoom" method="post" action="./?menu=verMensajesParticipante&accion=edita&idParticipante='.$_GET['idParticipante'].'&idConcurso='.$idConcurso.'&idMensaje='.$_GET['idMensaje'].'" enctype="multipart/form-data">
        <span>
            <a href="./?menu=verMensajesParticipante&idParticipante='.$_GET['idParticipante'].'&idConcurso='.$idConcurso.'">
            <img src="../../img/x.webp" alt=""></a>
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
            <label for="modo_id">Modos</label>
            <select id="selecionaModos" name="modo_id">';
                $modosSeleccionados = RepositorioModo::getById($mensaje->getmodo_id());
                $modos = RepositorioModo::getAll();
                //
                for ($i=0; $i < sizeof($modos); $i++) { 
                    $selected=false;
                    if ($modos[$i]->getId()==$modosSeleccionados->getId()) {
                        echo '<option selected value="'.$modos[$i]->getId().'">'.$modos[$i]->getNombre().'</option>';
                        $selected=true;
                    }
                    
                    if (!$selected) {
                        echo '<option value="'.$modos[$i]->getId().'">'.$modos[$i]->getNombre().'</option>';
                    }
                }
echo '  </select>  
    </div>';

echo '<div class="c-form__componente">
            <label for="banda_id">Bandas</label>
            <select id="selecionaBandas" name="banda_id">';
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
            <label for="emisor_id">Emisor</label>
            <select id="selecionaEmisor" name="emisor_id">';
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
            <label for="receptor_id">Receptor</label>
            <select id="selecionaReceptor" name="receptor_id">';
                $jueces = RepositorioConcurso::getJueces($idConcurso);
                $receptor = RepositorioParticipante::getById($mensaje->getReceptor_id());

                for ($i=0; $i < sizeof($jueces); $i++) { 
                    $selected=false;
                    
                    if ($jueces[$i]->getId()==$receptor->getId()) {
                        echo '<option selected value="'.$jueces[$i]->getId().'">'.$jueces[$i]->getNombre().'</option>';
                        $selected=true;
                    }
                    
                    if (!$selected) {
                        echo '<option value="'.$jueces[$i]->getId().'">'.$jueces[$i]->getNombre().'</option>';
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
    function imprimeCreacion($idParticipante,$idConcurso,$validacion=null){
        echo '<form class="c-form--edicion animZoom" method="post" action="./?menu=verMensajesParticipante&accion=nuevo&idParticipante='.$idParticipante.'&idConcurso='.$idConcurso.'" enctype="multipart/form-data">
        <span>
            <a href="./?menu=verMensajesParticipante&idParticipante='.$idParticipante.'&idConcurso='.$idConcurso.'">
            <img src="../../img/x.webp" alt=""></a>
        </span>
    
        <div class="c-form__titulo">
        <h2 style="margin-bottom: 4%; margin-top: 4%;">Nuevo Mensaje</h2>
        <hr>
        </div>
        
        <div class="c-form__componente">
            <label for="fecha">Fecha</label>
            <input type="datetime-local" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('fecha'):"").'" name="fecha" value="'.($_POST['fecha']??"").'">
            '.(($validacion!=null)?$validacion->ImprimirError('fecha'):"").'
        </div>
        <div class="c-form__componente">
            <label for="modo_id">Modos</label>
            <select id="selecionaModos" name="modo_id">';
                $modosSeleccionado = isset($_POST['modo_id'])?$_POST['modo_id']:"";
                $modos = RepositorioModo::getAll();
                //
                for ($i=0; $i < sizeof($modos); $i++) { 
                    $selected=false;
                    if ($modos[$i]->getId()==$modosSeleccionado) {
                        echo '<option selected value="'.$modos[$i]->getId().'">'.$modos[$i]->getNombre().'</option>';
                        $selected=true;
                    }
                    if (!$selected) {
                        echo '<option value="'.$modos[$i]->getId().'">'.$modos[$i]->getNombre().'</option>';
                    }
                }
echo '  </select>  
    </div>';

echo '<div class="c-form__componente">
            <label for="banda_id">Bandas</label>
            <select id="selecionaBandas" name="banda_id">';
                $bandasSeleccionado = isset($_POST['banda_id'])?$_POST['banda_id']:"";
                $bandas = RepositorioBanda::getAll();

                for ($i=0; $i < sizeof($bandas); $i++) { 
                    $selected=false;
                    if ($bandas[$i]->getId()==$bandasSeleccionado) {
                        echo '<option selected value="'.$bandas[$i]->getId().'">'.$bandas[$i]->getDistancia().'m '.$bandas[$i]->getRangoMin().'Mhz - '.$bandas[$i]->getRangoMax().'Mhz</option>';
                        $selected=true;
                    }
                    if (!$selected) {
                        echo '<option value="'.$bandas[$i]->getId().'">'.$bandas[$i]->getDistancia().'m '.$bandas[$i]->getRangoMin().'Mhz - '.$bandas[$i]->getRangoMax().'Mhz</option>';
                    }
                }
        echo'</select>
        </div>';
        //EMISOR
    echo '<div class="c-form__componente">
            <label for="emisor_id">Emisor</label>
            <select id="selecionaEmisor" name="emisor_id">';
                $participantes = RepositorioConcurso::getParticipantes($idConcurso);
                $emisor = $_POST['emisor_id']??null;

                for ($i=0; $i < sizeof($participantes); $i++) { 
                    $selected=false;
                    
                    if ($participantes[$i]['participante']->getNombre()==$emisor) {
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
            <label for="receptor_id">Receptor</label>
            <select id="selecionaReceptor" name="receptor_id">';
                $jueces = RepositorioConcurso::getJueces($idConcurso);
                $receptor = $_POST['receptor_id']??null;

                for ($i=0; $i < sizeof($jueces); $i++) { 
                    if ($receptor!=$jueces[$i]) {
                        $selected=false;
                        if ($jueces[$i]->getNombre()==$receptor) {
                            echo '<option selected value="'.$jueces[$i]->getId().'">'.$jueces[$i]->getNombre().'</option>';
                            $selected=true;
                        }
                        
                        if (!$selected) {
                            echo '<option value="'.$jueces[$i]->getId().'">'.$jueces[$i]->getNombre().'</option>';
                        }
                    }
                }
        echo'</select>
        </div>';

        echo'<div class="c-form__footer">
            <hr>
            <button value="Crear" name="submit" class="c-boton c-boton--secundario">Crear</button>
        </div>
    </form>
    <div class="bgModal"></div>';

    }
?>
