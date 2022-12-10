<?php
class RepositorioParticipacion{
    public static $nomTabla="participacion";

    public static function getById($id){
        try {
            $obj = GBD::findById(RepositorioParticipacion::$nomTabla,$id);
            return Participacion::arrayToParticipacion($obj);    //code...
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function setJuez($idParticipante, $idConcurso){
        try {
            //$participacion = RepositorioParticipante::getParticipacion($idParticipante,$idConcurso);

            $sql="update participacion set juez=1 where participante_id=$idParticipante and concurso_id=$idConcurso";
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public static function unSetJuez($idParticipante, $idConcurso){
        try {
            //$participacion = RepositorioParticipante::getParticipacion($idParticipante,$idConcurso);

            $sql="update participacion set juez=0 where participante_id=$idParticipante and concurso_id=$idConcurso";
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function getByConcursoParticipante($idConcurso, $idParticipante){
        try {
            
            $sql="select * from ".self::$nomTabla." where concurso_id=$idConcurso and participante_id=$idParticipante";
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetch(PDO::FETCH_ASSOC);
            if ($datos) {
                return Participacion::arrayToParticipacion($datos);
            }else{
                return false;
            }
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function add(Participacion $participacion){
        try {
            $array = $participacion->ParticipacionToArray(); 
             GBD::add(RepositorioParticipacion::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }
    

    public static function update(Participacion $participacion){
        try {
            $array = $participacion->participacionToArray(); 
             GBD::update(RepositorioParticipacion::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

        public static function delete($id){
        try {
             GBD::delete(RepositorioParticipacion::$nomTabla, $id);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function getAll(){
        $participacions = GBD::getAll("participacion");
        for ($i=0; $i <sizeof($participacions); $i++) { 
            $participacionsObj[]=Participacion::arrayToParticipacion($participacions[$i]);
        }
        return $participacionsObj;
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