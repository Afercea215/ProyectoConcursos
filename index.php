<?php
    require_once'./autoCargadores/autoCargador.php';

    //$conex = GBD::getConexion();
    //$conex->query('INSERT INTO PARTICIPANTE VALUES (3, "sdfsdffsd", 1, true, "asdf", POINT(2, 5), "sdfsdf", "sdfsdf")');
    
    //$participante = new Participante(3, "sdfsdffsd", "sdfsdf", true, "asdf", new Point(2,5), "sdfsdf", "sdfsdf");
    //$participante = new Participante(3, "aaaa", "bbb", true, "ccc",new Point(2, 5), "eee", "sdsdffsdf");
    var_dump(RepositorioParticipante::getParticipantes());
    
    //var_dump($concurso->getLocalizacion());
?>
