<?php
class RepositorioModo{
    public static $nomTabla="modo";

    public static function getModoById($id){
        try {
            $obj = GBD::findById(RepositorioModo::$nomTabla,$id);
            return Modo::arrayToModo($obj);    //code...
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function addModo(Modo $modo){
        try {
            $array = $modo->modoToArray(); 
             GBD::add(RepositorioModo::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }
    

    public static function updateModo(Modo $modo){
        try {
            $array = $modo->modoToArray(); 
             GBD::update(RepositorioModo::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

        public static function deleteModo(Modo $modo){
        try {
             GBD::delete(RepositorioModo::$nomTabla, $modo->getId());
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function getModos(){
        $modos = GBD::getAll("modo");
        for ($i=0; $i <sizeof($modos); $i++) { 
            $modosObj[]=Modo::arrayToModo($modos[$i]);
        }
        return $modosObj;
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