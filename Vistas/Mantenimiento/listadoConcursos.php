<?php
if (Sesion::estaLogeado() && Sesion::esAdmin()) {
    if (isset($_GET['id']) && isset($_GET['accion']) && $_GET['accion']=='edita') {
        imprimeEdicion($id);
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
            <th>Desc</th>
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
                echo '<td>'.$concursos[$i]->getCartel().'</td>';
                echo '<td><a href="./?accion=edita&tipoDato=concurso&id='.$concursos[$i]->getId().'"><img src="../../img/iconoLapiz.png"></a>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>