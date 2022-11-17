<?php
class RepositorioBanda{
    public static $nomTabla="banda";

    public static function getBandaById($id){
        try {
            $obj = GBD::findById(RepositorioBanda::$nomTabla,$id);
            return Banda::arrayToBanda($obj);    //code...
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function addBanda(Banda $banda){
        try {
            $array = $banda->bandaToArray(); 
             GBD::add(RepositorioBanda::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function updateBanda(Banda $banda){
        try {
            $array = $banda->bandaToArray(); 
             GBD::update(RepositorioBanda::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

        public static function deleteBanda(Banda $banda){
        try {
             GBD::delete(RepositorioBanda::$nomTabla, $banda->getId());
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function getBandas(){
        $bandas = GBD::getAll("banda");
        for ($i=0; $i <sizeof($bandas); $i++) { 
            $bandasObj[]=Banda::arrayToBanda($bandas[$i]);
        }
        return $bandasObj;
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