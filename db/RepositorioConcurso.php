<?php
class RepositorioConcurso{
    public static $nomTabla="concurso";

    public static function getConcursoById($id){
        try {
            $obj = GBD::findById(RepositorioConcurso::$nomTabla,$id);
            return Concurso::arrayToConcurso($obj);    //code...
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function addConcurso(Concurso $concurso){
        try {
            $array = $concurso->concursoToArray(); 
             GBD::add(RepositorioConcurso::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function updateConcurso(Concurso $concurso){
        try {
            $array = $concurso->concursoToArray(); 
             GBD::update(RepositorioConcurso::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

        public static function deleteConcurso(Concurso $concurso){
        try {
             GBD::delete(RepositorioConcurso::$nomTabla, $concurso->getId());
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function getConcursos(){
        $concursos = GBD::getAll("concurso");
        for ($i=0; $i <sizeof($concursos); $i++) { 
            $concursosObj[]=Concurso::arrayToConcurso($concursos[$i]);
        }
        return $concursosObj;
    }

    ///////////////////////////////TO DO tiene que devolver concursos
    public static function getBandas($id){

        /* SELECT * FROM concursos.banda_TIENE_concurso
        join concurso on concurso.id=banda_TIENE_concurso.concurso_id
        join banda on banda.id=banda_tiene_concurso.banda_id; */


/*         $sql="select * from ".RepositorioConcurso::$nomTabla." join banda_tiene_concurso on concurso.id=banda_TIENE_concurso.concurso_id join banda on banda.id=banda_tiene_concurso.banda_id"
        ." where concurso.id=".$id;
        try
        {
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            echo $e->getMessage();
        }         */
    }

    ///////////////////////////////TO DO tiene que devolver concursos
    public static function getModos($id){
/*         $sql="select * from ".RepositorioConcurso::$nomTabla." join modo_tiene_concurso on concurso.id=modo_TIENE_concurso.concurso_id join modo on modo.id=modo_tiene_concurso.modo_id"
        ." where concurso.id=".$id();
        try
        {
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        } catch (Exception $e) {
            echo $e->getMessage();
        }    */    
    }

    public static function getGanadoresDiplomas($id){
        
    }

    public static function getMensajes($id)
    {
        
    }
    
    public static function getParticipantes($id)
    {
        
    }

    public static function getGanadoresModo($id)
    {
        
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