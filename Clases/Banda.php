<?php
class Banda{
    private $id;
    private $distancia;
    private $rangoMin;
    private $rangoMax;

    public function __construct(int $id, int $distancia,int $rangoMin,int $rangoMax)
    {
        $this->setId($id);
        $this->setDistancia($distancia);
        $this->setRangoMin($rangoMin);
        $this->setRangoMax($rangoMax);
    }
    
    public static function arrayToBanda(array $array): Banda{
        $id=$array['id'];
        $distancia=$array['distancia'];
        $rangoMin=$array['rangoMin'];
        $rangoMax = $array['rangoMax']; 
        return new Banda($id, $distancia, $rangoMin, $rangoMax);
    }

    public function bandaToArray (){
            $array['id']=$this->getId();
            $array['distancia']=$this->getDistancia();
            $array['rangoMin']=$this->getRangoMin();
            $array['rangoMax']=$this->getRangoMax();
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
     * Get the value of distancia
     */ 
    public function getDistancia()
    {
        return $this->distancia;
    }

    /**
     * Set the value of distancia
     *
     * @return  self
     */ 
    public function setDistancia($distancia)
    {
        $this->distancia = $distancia;

        return $this;
    }

    /**
     * Get the value of rangoMin
     */ 
    public function getRangoMin()
    {
        return $this->rangoMin;
    }

    /**
     * Set the value of rangoMin
     *
     * @return  self
     */ 
    public function setRangoMin($rangoMin)
    {
        $this->rangoMin = $rangoMin;

        return $this;
    }

    /**
     * Get the value of rangoMax
     */ 
    public function getRangoMax()
    {
        return $this->rangoMax;
    }

    /**
     * Set the value of rangoMax
     *
     * @return  self
     */ 
    public function setRangoMax($rangoMax)
    {
        $this->rangoMax = $rangoMax;

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