<?php
class RepositorioParticipacion{
    public static $nomTabla="participacion";

    public static function getParticipacionById($id){
        try {
            $obj = GBD::findById(RepositorioParticipacion::$nomTabla,$id);
            return Participacion::arrayToParticipacion($obj);    //code...
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function addParticipacion(Participacion $participacion){
        try {
            $array = $participacion->ParticipacionToArray(); 
             GBD::add(RepositorioParticipacion::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }
    

    public static function updateParticipacion(Participacion $participacion){
        try {
            $array = $participacion->participacionToArray(); 
             GBD::update(RepositorioParticipacion::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

        public static function deleteParticipacion(Participacion $participacion){
        try {
             GBD::delete(RepositorioParticipacion::$nomTabla, $participacion->getId());
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function getParticipacions(){
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