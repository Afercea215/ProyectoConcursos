<?php
class RepositorioDiploma{
    public static $nomTabla="diploma";

    public static function getDiplomaById($id){
        try {
            $obj = GBD::findById(RepositorioDiploma::$nomTabla,$id);
            return Diploma::arrayToDiploma($obj);    //code...
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function addDiploma(Diploma $diploma){
        try {
            $array = $diploma->diplomaToArray(); 
             GBD::add(RepositorioDiploma::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }
    

    public static function updateDiploma(Diploma $diploma){
        try {
            $array = $diploma->diplomaToArray(); 
             GBD::update(RepositorioDiploma::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

        public static function deleteDiploma(Diploma $diploma){
        try {
             GBD::delete(RepositorioDiploma::$nomTabla, $diploma->getId());
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function getDiplomas(){
        $diplomas = GBD::getAll("diploma");
        for ($i=0; $i <sizeof($diplomas); $i++) { 
            $diplomasObj[]=Diploma::arrayToDiploma($diplomas[$i]);
        }
        return $diplomasObj;
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