<?php
//si quiere inscribirse
if (isset($_GET['idConcurso']) && isset($_GET['accion']) && $_GET['accion']=='inscribe') {
    RepositorioConcurso::inscribeParticipante($_GET['idConcurso'], Sesion::leer('usuario')->getId());
}


if (Sesion::estaLogeado() && Sesion::esAdmin()) {
    
    echo '<h2 class="g-marg-bottom--3">Listado Concursos</h2>';

    $validacion = new Validacion();
    //si hay info en post para validar

    if (isset($_GET['accion']) && $_GET['accion']=='masiva') {
                
        if (!empty($_FILES) && $_FILES['csv']['type']=="text/csv") {
            $path = $_FILES['csv']['tmp_name'];
            $gestor = fopen($path, "r");
            $i = 0;
            $j=0;
            $fila=[];
            while ($dato = fgetcsv($gestor, 1000, ";")) {
                $datos[$i]=$dato;
                $i++;
            }
            imprimeFormMasiva($datos);

         fclose($gestor);

        }else{
            imprimeMasivo();
        }

        if (isset($_POST['nombre']) && isset($_POST['descrip']) && isset($_POST['fini'])) {
            for ($i=0; $i <sizeof($_POST['nombre']) ; $i++) { 
                $array['id']=1;
                $array['nombre']=$_POST['nombre'][$i];
                $array['descrip']=$_POST['descrip'][$i];
                $array['fini']=$_POST['fini'][$i]; 
                $array['ffin']=$_POST['ffin'][$i];
                $array['finiInscrip']=$_POST['finiInscrip'][$i];
                $array['ffinInscrip']=$_POST['ffinInscrip'][$i];
                $array['cartel']="./img/cartelDefault.png";
                $concurso = Concurso::arrayToConcurso($array);

                RepositorioConcurso::add($concurso);
            }
            header('location:./?menu=listadoConcursos');
        }
    }


    //si quiere borrar un cocurso
    if (isset($_GET['accion']) && $_GET['accion']=='borra'){
        echo '
            <div class="c-modalSeguro animZoom">
                <span><a href="./?menu=listadoConcursos"><img src="./img/x.webp"></a></span>
                <h2>Atención!</h2>
                <p>¿Estas segudo de realizar esta acción?</p>
                <div>
                    <span id="btnSi"><a href="./controladores/eliminaConcurso.php?id='.$_GET['id'].'">Si</a></span>
                    <span id="btnNo"><a href="./?menu=listadoConcursos">No</a></span>
                </div>
            </div>
            <div class="bgModal"></div>
        ';
    }

    //si se ha enviado algo podemos validarlo
    if (isset($_POST['submit']) && isset($_GET['accion'])) {
        $validacion->Requerido('nombre');
        $validacion->Requerido('descrip');
        $validacion->Requerido('fini');
        $validacion->Requerido('ffin');
        $validacion->Requerido('finiInscrip');
        $validacion->Requerido('ffinInscrip');
        $validacion->Requerido('banda_id');
        $validacion->Requerido('modo_id');
        $validacion->Requerido('participantes_id');
        $validacion->Requerido('jueces_id');
        
        $fini = new DateTime($_POST['fini']);
        $ffin = new DateTime($_POST['ffin']);
        $finiInscrip = new DateTime($_POST['finiInscrip']);
        $ffinInscrip = new DateTime($_POST['ffinInscrip']);
        if ($fini > $ffin) {
            $validacion->addError('ffin','La fecha de inicio debe de ser menos a la fecha de fin');
        }
        if ($finiInscrip > $ffinInscrip) {
            $validacion->addError('ffinInscrip','La fecha de inicio debe de ser menos a la fecha de fin');
        }
        //si no se valida se imprimen los datos con errores
        if (!$validacion->ValidacionPasada()) {
            if ($_GET['accion']=='edita') {
                imprimeEdicion($_GET['id'],$validacion);
            }else if ($_GET['accion']=='nuevo') {
                imprimeCreacion($validacion);
            }
            //si la pasa se actualiza o crea en la bd
        }else{
            if ($_GET['accion']=='edita') {
                //envio la id tb
                $_POST['id']=$_GET['id'];
                $concurso = RepositorioConcurso::getById($_GET['id']);
                //comprebo la imagen
                if (!empty($_FILES) && $_FILES['cartel']['type']=="image/jpeg" || $_FILES['cartel']['type']=="image/png") {
                    $path = $_FILES['cartel']['tmp_name'];
                    $_POST['cartel']=Imagenes::imgToBase64($path);
                }else { 
                    $_POST['cartel']=$concurso->getCartel();
                }        
                        
                try {
                    //actualizo la tabla concurso
                    RepositorioConcurso::update(Concurso::arrayToConcurso($_POST));

                    //modifico las relaciones de concurso con banda, modos, participantes...etc
                    $bandas = RepositorioBanda::getAll();
                    $bandasSeleccionadas = $_POST['banda_id']??RepositorioConcurso::getBandas($_GET['id']);

                    for ($i=0; $i < sizeof($bandas); $i++) { 
                        $selected=false;
                        for ($j=0; $j < sizeof($bandasSeleccionadas) ; $j++) { 
                            if ($bandas[$i]->getId()==$bandasSeleccionadas[$j]) {
                                //creo relacion si no existe ya;
                                if (!RepositorioConcurso::existeBanda($concurso->getId(),$bandas[$i]->getId())) {
                                    RepositorioConcurso::addBanda($concurso->getId(), $bandas[$i]->getId());
                                }
                                $selected=true;
                            }
                        }
                        if (!$selected) {
                            //borrar relacion
                            if (RepositorioConcurso::existeBanda($concurso->getId(),$bandas[$i]->getId())) {
                                RepositorioConcurso::deleteBanda($concurso->getId(), $bandas[$i]->getId());
                            }
                        }
                    }
                    
                    $modos = RepositorioModo::getAll();
                    $modosSeleccionadas = $_POST['modo_id']??RepositorioConcurso::getModos($_GET['id']);

                    for ($i=0; $i < sizeof($modos); $i++) { 
                        $selected=false;
                        for ($j=0; $j < sizeof($modosSeleccionadas) ; $j++) { 
                            if ($modos[$i]->getId()==$modosSeleccionadas[$j]) {
                                //creo relacion si no existe ya;
                                if (!RepositorioConcurso::existeModo($concurso->getId(),$modos[$i]->getId())) {
                                    RepositorioConcurso::addModo($concurso->getId(), $modos[$i]->getId(), $_POST['premio'][$j]);
                                }
                                $selected=true;
                            }
                        }
                        if (!$selected) {
                            //borrar relacion
                            if (RepositorioConcurso::existeModo($concurso->getId(),$modos[$i]->getId())) {
                                RepositorioConcurso::deleteModo($concurso->getId(), $modos[$i]->getId());
                            }
                        }
                    }

                    $participantes = RepositorioParticipante::getAll();
                    $participantesSeleccionados = $_POST['participantes_id']??RepositorioConcurso::getParticipantes($_GET['id']);

                    for ($i=0; $i < sizeof($participantes); $i++) { 
                        $selected=false;
                        for ($j=0; $j < sizeof($participantesSeleccionados) ; $j++) { 
                            if ($participantes[$i]->getId()==$participantesSeleccionados[$j]) {
                                //creo relacion si no existe ya;
                                if (!RepositorioConcurso::existeParticipante($concurso->getId(),$participantes[$i]->getId())) {
                                    RepositorioConcurso::addParticipante($concurso->getId(), $participantes[$i]->getId());
                                }
                                $selected=true;
                            }
                        }
                        if (!$selected) {
                            //borrar relacion
                            if (RepositorioConcurso::existeParticipante($concurso->getId(),$participantes[$i]->getId())) {
                                RepositorioConcurso::deleteParticipante($concurso->getId(), $participantes[$i]->getId());
                            }
                        }
                    }
                    
                    $participantesSeleccionados = RepositorioConcurso::getParticipantes($_GET['id']);
                    $juecesSeleccionados = $_POST['jueces_id']??RepositorioConcurso::getJueces($_GET['id']);

                    for ($i=0; $i < sizeof($participantesSeleccionados); $i++) { 
                        $selected=false;
                        for ($j=0; $j < sizeof($juecesSeleccionados) ; $j++) { 
                            if ($participantesSeleccionados[$i]['participante']->getId()==$juecesSeleccionados[$j]) {
                                //creo relacion si no existe ya;
                                if (!$participantesSeleccionados[$i]['juez']) {
                                    RepositorioParticipacion::setJuez($participantesSeleccionados[$i]['participante']->getId(), $concurso->getId());
                                }
                                $selected=true;
                            }
                        }
                        if (!$selected) {
                            //borrar relacion
                            if ($participantesSeleccionados[$i]['juez']) {
                                RepositorioParticipacion::unSetJuez($participantesSeleccionados[$i]['participante']->getId(), $concurso->getId());
                            }
                        }
                    }

                } catch (Exception $e) {
                   echo "a";
                }

                header('location:./?menu=listadoConcursos');

            }else if ($_GET['accion']=='nuevo') {
                $_POST['id']=1;
                if (!empty($_FILES) && $_FILES['cartel']['type']=="image/jpeg" || $_FILES['cartel']['type']=="image/png") {
                    $path = $_FILES['cartel']['tmp_name'];
                    $_POST['cartel']=Imagenes::imgToBase64($path);
                }else { 
                    $_POST['cartel']=Imagenes::imgToBase64("./img/cartelDefault.png");
                }                
                $concurso=Concurso::arrayToConcurso($_POST);
                RepositorioConcurso::add($concurso);
                $ultimoConcurso= RepositorioConcurso::getUltimo();

                //añado las bandas al cocurso
                for ($i=0; $i <sizeof($_POST['banda_id']) ; $i++) { 
                    RepositorioBanda::anadeAConcurso($ultimoConcurso->getId(),$_POST['banda_id'][$i]);
                }
                //añado los modos al cocurso
                for ($i=0; $i <sizeof($_POST['modo_id']) ; $i++) { 
                    RepositorioModo::anadeAConcurso($ultimoConcurso->getId(),$_POST['modo_id'][$i],($_POST['premio'][$i])??"");
                }
                //añado los participantes al cocurso
                for ($i=0; $i <sizeof($_POST['participantes_id']) ; $i++) { 
                    RepositorioConcurso::inscribeParticipante($ultimoConcurso->getId(),$_POST['participantes_id'][$i]);
                }
                //añado los jueces al cocurso
                for ($i=0; $i <sizeof($_POST['jueces_id']) ; $i++) { 
                   RepositorioParticipacion::setJuez($_POST['jueces_id'][$i],$ultimoConcurso->getId());
                }

                header('location:./?menu=listadoConcursos');
            }
        }
        //si quiere editar se imprime el form
    }else if (isset($_GET['id']) && isset($_GET['accion']) && $_GET['accion']=='edita') {
        imprimeEdicion($_GET['id']);
    }elseif (isset($_GET['accion']) && $_GET['accion']=='nuevo') {
        imprimeCreacion();
    }
    
    //si hay un error de cualquier tipo
    if (isset($_GET['error'])) {
        echo '<script>muestraPanelError("Error", "'.$_GET['error'].'")</script>';
    }
    

    $pag = isset($_GET['pag'])?$_GET['pag']:'1';
    $crecimiento= isset($_GET['crecimiento'])?$_GET['crecimiento']:'asc';
    $orderBy= isset($_GET['orderBy'])?$_GET['orderBy']:'id';

    $concursos = RepositorioConcurso::getPag($pag,$crecimiento,$orderBy);
    
}else{
    header('location:/?menu=login');
}
?>
<div class="c-nuevo">
    <a href="./?menu=listadoConcursos&accion=nuevo"><span class="c-boton">+ Nuevo</span></a>
    <a href="./?menu=listadoConcursos&accion=masiva"><span class="c-boton">+ Subida Masiva</span></a>
</div>
<table class="c-tabla">
    <thead>
        <tr>
            <th><a href="./?menu=listadoConcursos&orderBy=id&pag=1">Id ▼</a></th>
            <th><a href="./?menu=listadoConcursos&orderBy=nombre&pag=1">Nombre ▼</th>
            <th><a href="./?menu=listadoConcursos&orderBy=descrip&pag=1">Descripción ▼</th>
            <th><a href="./?menu=listadoConcursos&orderBy=fini&pag=1">Fecha Inicio ▼</th>
            <th><a href="./?menu=listadoConcursos&orderBy=ffin&pag=1">Fecha Fin ▼</th>
            <th><a href="./?menu=listadoConcursos&orderBy=finiInscrip&pag=1">Fecha inicio Inscrip ▼</th>
            <th><a href="./?menu=listadoConcursos&orderBy=ffinInscrip&pag=1">Fecha fin Inscrip ▼</th>
            <th><a href="./?menu=listadoConcursos&orderBy=cartel&pag=1">Cartel ▼</th>
        </tr>
    </thead>
    <tbody>
        <?php
        //datos tabla
        for ($i=0; $i <sizeof($concursos) ; $i++) { 
            echo '<tr>';
                echo '<td>'.$concursos[$i]->getId().'</td>';
                echo '<td>'.$concursos[$i]->getNombre().'</td>';
                echo '<td>'.$concursos[$i]->getDescrip().'</td>';
                echo '<td>'.$concursos[$i]->getFIni()->format('Y-m-d H:i:s').'</td>';
                echo '<td>'.$concursos[$i]->getFFin()->format('Y-m-d H:i:s').'</td>';
                echo '<td>'.$concursos[$i]->getFIniInscrip()->format('Y-m-d H:i:s').'</td>';
                echo '<td>'.$concursos[$i]->getFFinInscrip()->format('Y-m-d H:i:s').'</td>';
                echo '<td><img src="'.$concursos[$i]->getCartel().'"></td>';
                echo '<td><a href="./?menu=verConcurso&id='.$concursos[$i]->getId().'"><img src="../../img/iconoOjo.png"></a>';
                echo '<td><a href="./?menu=listadoConcursos&accion=edita&id='.$concursos[$i]->getId().'"><img src="../../img/iconoLapiz.png"></a>';
                echo '<td><a href="./?menu=listadoConcursos&accion=borra&id='.$concursos[$i]->getId().'"><img src="../../img/logoPapelera.png"></a>';
                ///controladores/eliminaConcurso.php
            echo '</tr>';
        }
        ?>
        
    </tbody>
</table>

<?php
    $maxPag = intval(sizeof($concursos)/5+1);
    $pagAnterior = $pag<=1?1:$pag-1;
    $pagSiguiente = $pag>=$maxPag?$maxPag:$pag+1;
    echo '<div class="c-paginacion">';
    echo '<span class="c-paginacion__noactual"><a href="./?menu=listadoConcursos&OrderBy=$orderBy&pag='.$pagAnterior.'"><</a></span>';
    echo '<span class="c-paginacion__actual">'.$pag.'</span>';
    echo '<span class="c-paginacion__noactual"><a href="./?menu=listadoConcursos&OrderBy=$orderBy&pag='.$pagSiguiente.'">></a></span>';
    echo '</div>';
?>

<?php
/* $_SERVER['REQUEST_URI'] */
    function imprimeEdicion($id, $validacion=null){
        $concurso = RepositorioConcurso::getById($id);
        $modosConcurso = RepositorioConcurso::getModos($id);
        $bandasConcurso = RepositorioConcurso::getBandas($id);
        $participantesConcurso = RepositorioConcurso::getParticipantes($id);
        $juecesConcurso = RepositorioConcurso::getJueces($id);

        echo '<form class="c-form--edicion animZoom" method="post" action="./?menu=listadoConcursos&accion=edita&id='.$id.'" enctype="multipart/form-data">
        <span class="btnSalir">
            <a href="./?menu=listadoConcursos">
            <img src="../../img/x.webp" alt=""></a>
        </span>
    
        <div class="c-form__titulo">
            <h2 style="margin-bottom: 4%; margin-top: 4%;">Edicion Concurso</h2>
            <hr>
        </div>
    
        <div class="c-form__componente">
            <label for="nombre">Nombre</label>
            <input type="text" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('nombre'):"").'" name="nombre" value="'.(($_POST['nombre'])??$concurso->getNombre()).'">
            '.(($validacion!=null)?$validacion->ImprimirError('nombre'):"").'
        </div> 
        <div class="c-form__componente">
            <label for="descrip">Descripción</label>
            <input type="text" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('descrip'):"").'" name="descrip" value="'.(($_POST['descrip'])??$concurso->getDescrip()).'">
            '.(($validacion!=null)?$validacion->ImprimirError('descrip'):"").'
        </div>
        <div class="c-form__componente">
            <label for="fini">Fecha Inicio</label>
            <input type="datetime-local" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('fini'):"").'" name="fini" value="'.(($_POST['fini'])??$concurso->getFIni()->format('Y-m-d H:i:s')).'">
            '.(($validacion!=null)?$validacion->ImprimirError('fini'):"").'
        </div>
        <div class="c-form__componente">
            <label for="ffin">Fecha Finalización</label>
            <input type="datetime-local" name="ffin" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('ffin'):"").'" value="'.(($_POST['ffin'])??$concurso->getFFin()->format('Y-m-d H:i:s')).'">
            '.(($validacion!=null)?$validacion->ImprimirError('ffin'):"").'
        </div>
        <div class="c-form__componente">
            <label for="finiInscrip">Fecha Inicio Inscripciones</label>
            <input type="datetime-local" name="finiInscrip" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('finiInscrip'):"").'" value="'.(($_POST['finiInscrip'])??$concurso->getFIniInscrip()->format('Y-m-d H:i:s')).'">
            '.(($validacion!=null)?$validacion->ImprimirError('finiInscrip'):"").'
        </div>
        <div class="c-form__componente">
            <label for="ffinInscrip">Fecha Fin Inscripciones</label>
            <input type="datetime-local" name="ffinInscrip" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('ffinInscrip'):"").'" value="'.(($_POST['ffinInscrip'])??$concurso->getFFinInscrip()->format('Y-m-d H:i:s')).'">
            '.(($validacion!=null)?$validacion->ImprimirError('ffinInscrip'):"").'
        </div>
        <div class="c-form__componente">
            <label for="cartel">Cartel</label>
            <input type="file" name="cartel" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('cartel'):$concurso->getCartel()).'">
            '.(($validacion!=null)?$validacion->ImprimirError('cartel'):"").'
        </div>';
        
        echo '<div class="c-form__componente">
        <label for="banda_id[]">Bandas</label>
        <select id="selecionaBanda" name="banda_id[]" multiple>';
            $bandas = RepositorioBanda::getAll();
            $bandasSeleccionadas = $bandasConcurso;

            for ($i=0; $i < sizeof($bandas); $i++) { 
                $selected=false;
                for ($j=0; $j < sizeof($bandasSeleccionadas) ; $j++) { 
                    if ($bandas[$i]->getId()==$bandasSeleccionadas[$j]->getId()) {
                        echo '<option selected value="'.$bandas[$i]->getId().'">'.$bandas[$i]->getDistancia().'m '.$bandas[$i]->getRangoMin().' - '.$bandas[$i]->getRangoMax().'Mhz</option>';
                        $selected=true;
                    }
                }
                if (!$selected) {
                    echo '<option value="'.$bandas[$i]->getId().'">'.$bandas[$i]->getDistancia().'m '.$bandas[$i]->getRangoMin().' - '.$bandas[$i]->getRangoMax().'Mhz</option>';
                }
            }
        echo'</select>
        </div>';
        
        echo '<div class="c-form__componente">
        <label for="modo_id[]">Modos</label>
        <select id="selecionaModo" name="modo_id[]" multiple>';
            $modos = RepositorioModo::getAll();
            $modosSeleccionadas = $modosConcurso;

            for ($i=0; $i < sizeof($modos); $i++) { 
                $selected=false;
                for ($j=0; $j < sizeof($modosSeleccionadas) ; $j++) { 
                    if ($modos[$i]->getId()==$modosSeleccionadas[$j]['id']) {
                        echo '<option selected value="'.$modos[$i]->getId().'">'.$modos[$i]->getNombre().'</option>';
                        $selected=true;
                    }
                }
                if (!$selected) {
                    echo '<option value="'.$modos[$i]->getId().'">'.$modos[$i]->getNombre().'</option>';
                }
            }
        echo'</select>
        </div>';
        
        echo '<div class="c-form__componente">
        <label for="participantes_id[]">Participantes</label>
        <select id="selecionaParticipantes" name="participantes_id[]" multiple>';
            $participantes = RepositorioParticipante::getAll();
            $participantesSeleccionados = $participantesConcurso;

            for ($i=0; $i < sizeof($participantes); $i++) { 
                $selected=false;
                for ($j=0; $j < sizeof($participantesSeleccionados) ; $j++) { 
                    if ($participantes[$i]->getId()==$participantesSeleccionados[$j]['participante']->getId()) {
                        echo '<option selected value="'.$participantes[$i]->getId().'">'.$participantes[$i]->getNombre().'</option>';
                        $selected=true;
                    }
                }
                if (!$selected) {
                    echo '<option value="'.$participantes[$i]->getId().'">'.$participantes[$i]->getNombre().'</option>';
                }
            }
        echo'</select>
        </div>';

        echo '<div class="c-form__componente">
        <label for="jueces_id[]">Jueces</label>
        <select id="selecionaParticipantes" name="jueces_id[]" multiple>';
            $juecesSeleccionados = $juecesConcurso;

            for ($i=0; $i < sizeof($participantesConcurso); $i++) { 
                $selected=false;
                for ($j=0; $j < sizeof($juecesSeleccionados) ; $j++) { 
                    if ($participantesConcurso[$i]['participante']->getId()==$juecesSeleccionados[$j]->getId()) {
                        echo '<option selected value="'.$participantesConcurso[$i]['participante']->getId().'">'.$participantesConcurso[$i]['participante']->getNombre().'</option>';
                        $selected=true;
                    }
                }
                if (!$selected) {
                    echo '<option value="'.$participantesConcurso[$i]['participante']->getId().'">'.$participantesConcurso[$i]['participante']->getNombre().'</option>';
                }
            }
        echo'</select>
        </div>';

        
        echo'
        <div class="c-form__footer">
            <hr>
            <button value="Guardar" name="submit" class="c-boton c-boton--secundario">Crear</button>
        </div>
    
        </form>
    <div class="bgModal"></div>';

    }



    function imprimeCreacion($validacion=null){
        echo '<form class="c-form--edicion animZoom" method="post" action="./?menu=listadoConcursos&accion=nuevo" enctype="multipart/form-data">
        <span class="btnSalir">
            <a href="./?menu=listadoConcursos">
            <img src="../../img/x.webp" alt=""></a>
        </span>
    
        <div class="c-form__titulo">
            <h2 style="margin-bottom: 4%; margin-top: 4%;">Creación Concurso</h2>
            <hr>
        </div>
    
        <div class="c-form__componente">
            <label for="nombre">Nombre</label>
            <input type="text" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('nombre'):"").'" name="nombre" value="'.(($_POST['nombre'])??"").'">
            '.(($validacion!=null)?$validacion->ImprimirError('nombre'):"").'
        </div> 
        <div class="c-form__componente">
            <label for="descrip">Descripción</label>
            <input type="text" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('descrip'):"").'" name="descrip" value="'.(($_POST['descrip'])??"").'">
            '.(($validacion!=null)?$validacion->ImprimirError('descrip'):"").'
        </div>
        <div class="c-form__componente">
            <label for="fini">Fecha Inicio</label>
            <input type="datetime-local" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('fini'):"").'" name="fini" value="'.(($_POST['fini'])??"").'">
            '.(($validacion!=null)?$validacion->ImprimirError('fini'):"").'
        </div>
        <div class="c-form__componente">
            <label for="ffin">Fecha Finalización</label>
            <input type="datetime-local" name="ffin" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('ffin'):"").'" value="'.(($_POST['ffin'])??"").'">
            '.(($validacion!=null)?$validacion->ImprimirError('ffin'):"").'
        </div>
        <div class="c-form__componente">
            <label for="finiInscrip">Fecha Inicio Inscripciones</label>
            <input type="datetime-local" name="finiInscrip" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('finiInscrip'):"").'" value="'.(($_POST['finiInscrip'])??"").'">
            '.(($validacion!=null)?$validacion->ImprimirError('finiInscrip'):"").'
        </div>
        <div class="c-form__componente">
            <label for="ffinInscrip">Fecha Fin Inscripciones</label>
            <input type="datetime-local" name="ffinInscrip" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('ffinInscrip'):"").'" value="'.(($_POST['ffinInscrip'])??"").'">
            '.(($validacion!=null)?$validacion->ImprimirError('ffinInscrip'):"").'
        </div>
        <div class="c-form__componente">
            <label for="cartel">Cartel</label>
            <input type="file" name="cartel" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('cartel'):"").'">
            '.(($validacion!=null)?$validacion->ImprimirError('cartel'):"").'
        </div>';
        
        echo '<div class="c-form__componente">
        <label for="banda_id[]">Bandas</label>
        <select id="selecionaBanda" name="banda_id[]" multiple>';
            $bandas = RepositorioBanda::getAll();
            $bandasSeleccionadas = $_POST['banda_id[]']??[];

            for ($i=0; $i < sizeof($bandas); $i++) { 
                $selected=false;
                for ($j=0; $j < sizeof($bandasSeleccionadas) ; $j++) { 
                    if ($bandas[$i]->getId()==$bandasSeleccionadas[$j]->getId()) {
                        echo '<option selected value="'.$bandas[$i]->getId().'">'.$bandas[$i]->getDistancia().'m '.$bandas[$i]->getRangoMin().' - '.$bandas[$i]->getRangoMax().'Mhz</option>';
                        $selected=true;
                    }
                }
                if (!$selected) {
                    echo '<option value="'.$bandas[$i]->getId().'">'.$bandas[$i]->getDistancia().'m '.$bandas[$i]->getRangoMin().' - '.$bandas[$i]->getRangoMax().'Mhz</option>';
                }
            }
        echo'</select>
        </div>';
        
        echo '<div class="c-form__componente">
        <label for="modo_id[]">Modos</label>
        <select id="selecionaModo" name="modo_id[]" multiple>';
            $modos = RepositorioModo::getAll();
            $modosSeleccionadas = $_POST['modo_id[]']??[];

            for ($i=0; $i < sizeof($modos); $i++) { 
                $selected=false;
                for ($j=0; $j < sizeof($modosSeleccionadas) ; $j++) { 
                    if ($modos[$i]->getId()==$modosSeleccionadas[$j]->getId()) {
                        echo '<option selected value="'.$modos[$i]->getId().'">'.$modos[$i]->getNombre().'</option>';
                        $selected=true;
                    }
                }
                if (!$selected) {
                    echo '<option value="'.$modos[$i]->getId().'">'.$modos[$i]->getNombre().'</option>';
                }
            }
        echo'</select>
        </div>';
        
        echo '<div class="c-form__componente" id="cajaParticipantes">
                <label>Participantes</label>
                <span class="c-boton c-boton--secundario" id="btnAsignaParticip">Asignar Participantes</span>
                <select id="selectParticipantes" multiple="" name="participantes_id[]"></select>
             </div>';
             
        echo '<div class="c-form__componente" id="cajaJueces">
                <label>Jueces</label>
                <span class="c-boton c-boton--secundario" id="btnAsignaJueces">Asignar Jueces</span>
                <select id="selectJueces" multiple="" name="jueces_id[]"></select>
            </div>';

        echo'
        <div class="c-form__footer">
            <hr>
            <button value="Guardar" name="submit" class="c-boton c-boton--secundario">Crear</button>
        </div>
    
        </form>
    <div class="bgModal"></div>';

    }
    function imprimeMasivo(){
        echo '<form class="c-form--edicion animZoom" method="post" action="./?menu=listadoConcursos&accion=masiva" enctype="multipart/form-data">
                <span class="btnSalir">
                    <a href="./?menu=listadoConcursos">
                    <img src="../../img/x.webp" alt=""></a>
                </span>        
                <label class="c-form__titulo">Adjunta tu csv</label>
                <input type="file" name="csv">
                <div class="c-form__footer">
                    <hr>
                    <button value="Guardar" name="submit" class="c-boton c-boton--secundario">Procesar datos</button>
                </div>
              </form>
        <div class="bgModal"></div>';

    }
    function imprimeFormMasiva($datos){
        echo '<div class="c-form c-form--masivo animZoom" style="position: absolute; z-index: 100;">
                <span class="btnSalir">
                    <a href="./?menu=listadoConcursos">
                    <img src="../../img/x.webp" alt=""></a>
                </span>
                <div class="c-form__titulo"><h2 style="margin-bottom: 4%; margin-top: 4%;">Importación Masiva</h2><hr></div>
                <form class="c-form--edicion animZoom" method="post" action="./?menu=listadoConcursos&accion=masiva" enctype="multipart/form-data">';
                
                for ($i=1; $i <sizeof($datos) ; $i++) { 
                    echo '<div>';
                    echo '<label for="'.$datos[0][1].'[]">'.$datos[0][1].'</label>';
                    echo '<input type="text" name="'.$datos[0][1].'[]" value="'.$datos[$i][1].'">';

                    echo '<label for="'.$datos[0][2].'[]">'.$datos[0][2].'</label>';
                    echo '<input type="text" name="'.$datos[0][2].'[]" value="'.$datos[$i][2].'">';

                    echo '<label for="'.$datos[0][3].'[]">'.$datos[0][3].'</label>';
                    echo '<input type="text" name="'.$datos[0][3].'[]" value="'.$datos[$i][3].'">';

                    echo '<label for="'.$datos[0][4].'[]">'.$datos[0][4].'</label>';
                    echo '<input type="text" name="'.$datos[0][4].'[]" value="'.$datos[$i][4].'">';
                    
                    echo '<label for="'.$datos[0][5].'[]">'.$datos[0][5].'</label>';
                    echo '<input type="text" name="'.$datos[0][5].'[]" value="'.$datos[$i][5].'">';

                    echo '<label for="'.$datos[0][6].'[]">'.$datos[0][6].'</label>';
                    echo '<input type="text" name="'.$datos[0][6].'[]" value="'.$datos[$i][6].'">';
                    echo '</div>';
                }

                echo '<button value="Crear" name="submit" class="c-boton c-boton--secundario" style="margin-top: 7%;">Crear</button>';
            echo '</form>
              </div>
        <div class="bgModal"></div>';

    }
?>

