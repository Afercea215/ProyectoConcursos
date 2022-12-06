<?php
class Modo{
    private $id;
    private $nombre;

    public function __construct(int $id, string $nombre)
    {
        $this->setId($id);
        $this->setNombre($nombre);
    }

    public static function arrayToModo(array $array): Modo{
        $id=$array['id'];
        $nombre=$array['nombre']; 
        return new Modo($id, $nombre);
    }

    public function modoToArray (){
            $array['id']=$this->getId();
            $array['nombre']=$this->getNombre();
            return $array;
    }
    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  selfs
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
?>