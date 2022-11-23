<?php
class RepositorioDiploma{
    public static $nomTabla="diploma";

    public static function getById($id){
        try {
            $obj = GBD::findById(RepositorioDiploma::$nomTabla,$id);
            return Diploma::arrayToDiploma($obj);    //code...
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function add(Diploma $diploma){
        try {
            $array = $diploma->diplomaToArray(); 
             GBD::add(RepositorioDiploma::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }
    

    public static function update(Diploma $diploma){
        try {
            $array = $diploma->diplomaToArray(); 
             GBD::update(RepositorioDiploma::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

        public static function delete($id){
        try {
             GBD::delete(RepositorioDiploma::$nomTabla, $id);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function getAll(){
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