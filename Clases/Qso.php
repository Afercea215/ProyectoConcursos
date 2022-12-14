<?php
class Qso{
    private $id;
    private DateTime $fecha;
    private bool $valido;
    private $receptor_id;
    private $banda_id;
    private $modo_id;
    private $participacion_id;

    public function __construct(int $id, string $fecha, bool $valido,string $receptor_id, string $banda_id,string $modo_id,string $participacion_id)
    {
        $this->setId($id);
        $this->setFecha($fecha);
        $this->setValido($valido);
        $this->setReceptor_id($receptor_id);
        $this->setbanda_id($banda_id);
        $this->setmodo_id($modo_id);
        $this->setparticipacion_id($participacion_id);
    }
    
    public static function arrayToQso(array $array): Qso{
        $id=$array['id']??1;
        $fecha=$array['fecha']; 
        $valido=$array['valido']??0; 
        $receptor=$array['receptor_id']; 
        $banda_id=$array['banda_id']; 
        $modo_id=$array['modo_id']; 
        $participacion_id=$array['participacion_id']; 
        return new Qso($id, $fecha, $valido, $receptor, $banda_id, $modo_id, $participacion_id);
    }

    public function qsoToArray (){
        $array['id']=$this->getId();
        $array['fecha']=$this->getFecha();
        $array['valido']=$this->getValido();
        $array['receptor_id']=$this->getReceptor_id();
        $array['banda_id']=$this->getbanda_id();
        $array['modo_id']=$this->getmodo_id();
        $array['participacion_id']=$this->getparticipacion_id();
        return $array;
    }

    /**
     * Get the value of fecha
     */ 
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     *
     * @return  self
     */ 
    public function setFecha($fecha)
    {
        $this->fecha = GBD::creaFecha($fecha);

        return $this;
    }

    /**
     * Get the value of banda_id
     */ 
    public function getbanda_id()
    {
        return $this->banda_id;
    }

    /**
     * Set the value of banda_id
     *
     * @return  self
     */ 
    public function setbanda_id($banda_id)
    {
        $this->banda_id = $banda_id;

        return $this;
    }

    /**
     * Get the value of modo_id
     */ 
    public function getmodo_id()
    {
        return $this->modo_id;
    }

    /**
     * Set the value of modo_id
     *
     * @return  self
     */ 
    public function setmodo_id($modo_id)
    {
        $this->modo_id = $modo_id;

        return $this;
    }

    /**
     * Get the value of participacion_id
     */ 
    public function getparticipacion_id()
    {
        return $this->participacion_id;
    }

    /**
     * Set the value of participacion_id
     *
     * @return  self
     */ 
    public function setparticipacion_id($participacion_id)
    {
        $this->participacion_id = $participacion_id;

        return $this;
    }

    /**
     * Get the value of valido
     */ 
    public function getValido()
    {
        return $this->valido;
    }

    /**
     * Set the value of valido
     *
     * @return  self
     */ 
    public function setValido($valido)
    {
        $this->valido = $valido;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
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

    /**
     * Get the value of receptor_id
     */ 
    public function getReceptor_id()
    {
        return $this->receptor_id;
    }

    /**
     * Set the value of receptor_id
     *
     * @return  self
     */ 
    public function setReceptor_id($receptor_id)
    {
        $this->receptor_id = $receptor_id;

        return $this;
    }
}
?>