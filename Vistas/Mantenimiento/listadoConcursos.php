<?php
if (Sesion::estaLogeado() && Sesion::esAdmin()) {
    
    $validacion = new Validacion();
    $edicionActiva;
    //si hay info en post para validar
    if (isset($_POST['submit']) && isset($_GET['accion'])) {
        $validacion->Requerido('nombre');
        $validacion->Requerido('descrip');
        $validacion->Requerido('fini');
        $validacion->Requerido('fini');
        $validacion->Requerido('finiInscrip');
        $validacion->Requerido('ffinInscrip');
        
        //si no se valida se imprimen los datos con errores
        if (!$validacion->ValidacionPasada()) {
            if ($_GET['accion']=='edita') {
                imprimeEdicion($_GET['id'],$validacion);
            }else if ($_GET['accion']=='crea') {
                //imprimeCreacion($validacion);
            }
            //si la pasa se actualiza o crea en la bd
        }else{
            if ($_GET['accion']=='edita') {
                //envio la id tb
                $_POST['id']=$_GET['id'];
                //comprebo la imagen
                if (!empty($_FILES) && $_FILES['cartel']['type']=="image/jpeg" || $_FILES['cartel']['type']=="image/png") {
                    $path = $_FILES['cartel']['tmp_name'];
                    $_POST['cartel']=Imagenes::imgToBase64($path);
                }else { 
                    $_POST['cartel']=Imagenes::imgToBase64("./img/cartelDefault.png");
                }                
                RepositorioConcurso::update(Concurso::arrayToConcurso($_POST));
                header('location:./?menu=listadoConcursos');
            }else if ($_GET['accion']=='crea') {
                $concurso=Concurso::arrayToConcurso($_POST);
                RepositorioConcurso::add($concurso);
                header('location:./menu=listadoConsursos');
            }
        }
        //si quiere editar se imprime el form
    }else if (isset($_GET['id']) && isset($_GET['accion']) && $_GET['accion']=='edita') {
        imprimeEdicion($_GET['id']);
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

<table class="c-tabla">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Fecha inicio Inscrip</th>
            <th>Fecha fin Inscrip</th>
            <th>Cartel</th>
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
                echo '<td><a href="./controladores/eliminaConcurso.php?id='.$concursos[$i]->getId().'"><img src="../../img/logoPapelera.png"></a>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>


<?php
    function imprimeEdicion($id, $validacion=null){
        $concurso = RepositorioConcurso::getById($id);
        echo '<form class="c-form--edicion animZoom" method="post" action="./?menu=listadoConcursos&accion=edita&id='.$id.'" enctype="multipart/form-data">
        <span>
            <img src="../../img/x.webp" alt="">
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
            <input type="datetime-local" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('fini'):"").'" name="fini" value="'.(($_POST['fini'])??$concurso->getFini()->format('Y-m-d H:i:s')).'">
            '.(($validacion!=null)?$validacion->ImprimirError('fini'):"").'
        </div>
        <div class="c-form__componente">
            <label for="ffin">Fecha Finalización</label>
            <input type="datetime-local" name="ffin" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('ffin'):"").'" value="'.(($_POST['ffin'])??$concurso->getFfin()->format('Y-m-d H:i:s')).'">
            '.(($validacion!=null)?$validacion->ImprimirError('ffin'):"").'
        </div>
        <div class="c-form__componente">
            <label for="finiInscrip">Fecha Inicio Inscripciones</label>
            <input type="datetime-local" name="finiInscrip" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('finiInscrip'):"").'" value="'.(($_POST['finiInscrip'])??$concurso->getFiniInscrip()->format('Y-m-d H:i:s')).'">
            '.(($validacion!=null)?$validacion->ImprimirError('finiInscrip'):"").'
        </div>
        <div class="c-form__componente">
            <label for="ffinInscrip">Fecha Fin Inscripciones</label>
            <input type="datetime-local" name="ffinInscrip" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('ffinInscrip'):"").'" value="'.(($_POST['ffinInscrip'])??$concurso->getFfinInscrip()->format('Y-m-d H:i:s')).'">
            '.(($validacion!=null)?$validacion->ImprimirError('ffinInscrip'):"").'
        </div>
        <div class="c-form__componente">
            <label for="cartel">Cartel</label>
            <input type="file" name="cartel" class="'.(($validacion!=null)?$validacion->imprimeClaseInputError('cartel'):"").'">
            '.(($validacion!=null)?$validacion->ImprimirError('cartel'):"").'
        </div>
    
        <div class="c-form__footer">
            <hr>
            <button value="Guardar" name="submit" class="c-boton c-boton--secundario">Guardar</button>
        </div>
    </form>
    <div class="bgModal"></div>';

    }
?>

