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