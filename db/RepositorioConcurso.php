<?php
class RepositorioConcurso{
    public static $nomTabla="concurso";


    public static function getPag($pag, $crecimiento, $orderBy='id'){
        try {
            $obj = GBD::getPag(RepositorioConcurso::$nomTabla, $pag, $orderBy, $crecimiento, $tamañoPag=5);
            $concursos=[];
            for ($i=0; $i <sizeof($obj) ; $i++) { 
                $concursos[$i]=Concurso::arrayToConcurso($obj[$i]);
            }
            return $concursos;    //code...
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function getById($id){
        try {
            $obj = GBD::findById(RepositorioConcurso::$nomTabla,$id);
            return Concurso::arrayToConcurso($obj);    //code...
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function add(Concurso $concurso){
        try {
            $array = $concurso->concursoToArray(); 
             GBD::add(RepositorioConcurso::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function update(Concurso $concurso){
        try {
            $array = $concurso->concursoToArray(); 
             GBD::update(RepositorioConcurso::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

        public static function delete($id){
        try {
             GBD::delete(RepositorioConcurso::$nomTabla, $id);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function getAll(){
        $concursos = GBD::getAll("concurso");
        for ($i=0; $i <sizeof($concursos); $i++) { 
            $concursosObj[]=Concurso::arrayToConcurso($concursos[$i]);
        }
        return $concursosObj;
    }

    ///////////////////////////////TO DO revisar
    public static function getBandas($id){

        /* SELECT * FROM concursos.banda_TIENE_concurso
        join concurso on concurso.id=banda_TIENE_concurso.concurso_id
        join banda on banda.id=banda_tiene_concurso.banda_id; */

        $sql="select * from ".RepositorioConcurso::$nomTabla." join banda_tiene_concurso on concurso.id=banda_TIENE_concurso.concurso_id join banda on banda.id=banda_tiene_concurso.banda_id"
        ." where concurso.id=".$id;
        try
        {
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetchAll(PDO::FETCH_ASSOC);

            for ($i=0; $i <sizeof($datos); $i++) { 
                $bandasObj[]=new Banda($datos[$i]['banda.id'],$datos[$i]['distancia.id'],$datos[$i]['rangoMin.id'],$datos[$i]['rangoMax.id']);
            }

            return $bandasObj;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    ///////////////////////////////TO DO tiene que devolver concursos
    public static function getModos($id){
        //$sql="select * from ".RepositorioConcurso::$nomTabla." join modo_tiene_concurso on concurso.id=modo_TIENE_concurso.concurso_id join modo on modo.id=modo_tiene_concurso.modo_id"
        //." where concurso.id=".$id();
        $sql="select * from ".RepositorioConcurso::$nomTabla." join modo_tiene_concurso on concurso.id=modo_TIENE_concurso.concurso_id join modo on modo.id=modo_tiene_concurso.modo_id"
        ." where concurso.id=".$id;
        try
        {
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetchAll(PDO::FETCH_ASSOC);

            for ($i=0; $i <sizeof($datos); $i++) { 
                $modosObj[]=new Modo($datos[$i]['modo.id'],$datos[$i]['banda.id']);
            }
            
            return $modosObj;
        } catch (Exception $e) {
            echo $e->getMessage();
        }       
    }

    public static function getGanadoresDiplomas($id){
        
    }

    public static function getMensajes($id)
    {
        $sql="select qso.* from participacion join qso on qso.participacion_id=participacion.id where participacion.concurso_id=".$id;
        try
        {
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetchAll(PDO::FETCH_ASSOC);

            for ($i=0; $i <sizeof($datos); $i++) { 
                $id=$datos[$i]['qso.id'];
                $fecha=$datos[$i]['qso.fecha'];
                $banda_id=$datos[$i]['qso.banda_id'];
                $modo_id=$datos[$i]['qso.modo_id'];
                $participacion=$datos[$i]['qso.participacion'];
                $valido=$datos[$i]['qso.valido'];
                
                $mensajesObj[]=new Qso($id,$fecha,$valido,$banda_id,$modo_id,$participacion,$valido);
            }
            
            return $mensajesObj;
        } catch (Exception $e) {
            echo $e->getMessage();
        }  
    }
    
    public static function getParticipantes($id)
    {
        $sql="select participante.* from participante join participacion on participante.id=participacion.participante_id where participacion.concurso_id=$id";
        try
        {
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetchAll(PDO::FETCH_ASSOC);

            for ($i=0; $i <sizeof($datos); $i++) {                 
                $participantesObj[]=Participante::arrayToParticipante($datos[$i], true);
            }
            
            return $participantesObj;
        } catch (Exception $e) {
            echo $e->getMessage();
        }   
    }

    ////////////TO DO
    public static function getGanadorModo($id)
    {
        
    }

    ////////////TO DO
    public static function getGanadoresDiploma(){

    }

    public static function getActivos(){
        
    }

    /**
     * Get the value of nomTabla
     */ 
    public function getNomTabla()
    {
        return $this->nomTabla;
    }

    /**
     * Set the value of nomTabla
     *
     * @return  self
     */ 
    public function setNomTabla($nomTabla)
    {
        $this->nomTabla = $nomTabla;

        return $this;
    }
}
?>