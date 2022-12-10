<?php
class RepositorioBanda{
    public static $nomTabla="banda";

    public static function getById($id){
        try {
            $obj = GBD::findById(RepositorioBanda::$nomTabla,$id);
            return Banda::arrayToBanda($obj);    //code...
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function add(Banda $banda){
        try {
            $array = $banda->bandaToArray(); 
             GBD::add(RepositorioBanda::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function anadeAConcurso($idConcurso, $idBanda){
        $sql="insert into banda_tiene_concurso values ('".$idBanda."','".$idConcurso."')";
        try
        {
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
        }
        catch(PDOException $e)
        {
            throw new PDOException("Error insertando registro: ".$e->getMessage());
        }
    }

    public static function update(Banda $banda){
        try {
            $array = $banda->bandaToArray(); 
             GBD::update(RepositorioBanda::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

        public static function delete($id){
        try {
             GBD::delete(RepositorioBanda::$nomTabla, $id);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function getAll(){
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