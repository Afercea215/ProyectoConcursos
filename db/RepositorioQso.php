<?php
class RepositorioQso{
    public static $nomTabla="qso";

    public static function getQsoById($id){
        try {
            $obj = GBD::findById(RepositorioQso::$nomTabla,$id);
            return Qso::arrayToQso($obj);    //code...
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function addQso(Qso $qso){
        try {
            $array = $qso->QsoToArray(); 
             GBD::add(RepositorioQso::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }
    

    public static function updateQso(Qso $qso){
        try {
            $array = $qso->qsoToArray(); 
             GBD::update(RepositorioQso::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

        public static function deleteQso(Qso $qso){
        try {
             GBD::delete(RepositorioQso::$nomTabla, $qso->getId());
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function getQsos(){
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