<?php
class RepositorioQso{
    public static $nomTabla="qso";

    public static function getById($id){
        try {
            $obj = GBD::findById(RepositorioQso::$nomTabla,$id);
            return Qso::arrayToQso($obj);    //code...
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function add(Qso $qso){
        try {
            $array = $qso->QsoToArray(); 
             GBD::add(RepositorioQso::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }
    

    public static function update(Qso $qso){
        try {
            $array = $qso->qsoToArray(); 
             GBD::update(RepositorioQso::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

        public static function delete($id){
        try {
             GBD::delete(RepositorioQso::$nomTabla, $id);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function getAll(){
        $qsos = GBD::getAll("qso");
        for ($i=0; $i <sizeof($qsos); $i++) { 
            $qsosObj[]=Qso::arrayToQso($qsos[$i]);
        }
        return $qsosObj;
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