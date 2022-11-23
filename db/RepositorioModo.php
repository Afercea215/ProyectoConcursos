<?php
class RepositorioModo{
    public static $nomTabla="modo";

    public static function getById($id){
        try {
            $obj = GBD::findById(RepositorioModo::$nomTabla,$id);
            return Modo::arrayToModo($obj);    //code...
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function add(Modo $modo){
        try {
            $array = $modo->modoToArray(); 
             GBD::add(RepositorioModo::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }
    

    public static function update(Modo $modo){
        try {
            $array = $modo->modoToArray(); 
             GBD::update(RepositorioModo::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

        public static function delete($id){
        try {
             GBD::delete(RepositorioModo::$nomTabla, $id);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function getAll(){
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