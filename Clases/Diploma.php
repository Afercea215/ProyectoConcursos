<?php
class Diploma{
    private $id;
    private string $tipo;
    private int $minPuntos;
    private $concurso_id;

    public function __construct(int $id, string $tipo, int $minPuntos, $concurso_id)
    {
        $this->setId($id);
        $this->setTipo($tipo);
        $this->setMinPuntos($minPuntos);
        $this->setConcurso_id($concurso_id);
    }
    
    public static function arrayToDiploma(array $array): Diploma{
        $id=$array['id'];
        $tipo=$array['tipo']; 
        $minPuntos=$array['minPuntos']; 
        $concurso_id=$array['concurso_id']; 
        return new Diploma($id, $tipo, $minPuntos, $concurso_id);
    }

    public function diplomaToArray (){
        $array['id']=$this->getId();
        $array['tipo']=$this->getTipo();
        $array['minPuntos']=$this->getMinPuntos();
        $array['concurso_id']=$this->getConcurso_id();
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
     * Get the value of tipo
     */ 
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set the value of tipo
     *
     * @return  self
     */ 
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get the value of minPuntos
     */ 
    public function getMinPuntos()
    {
        return $this->minPuntos;
    }

    /**
     * Set the value of minPuntos
     *
     * @return  self
     */ 
    public function setMinPuntos($minPuntos)
    {
        $this->minPuntos = $minPuntos;

        return $this;
    }

    /**
     * Get the value of concurso_id
     */ 
    public function getConcurso_id()
    {
        return $this->concurso_id;
    }

    /**
     * Set the value of concurso_id
     *
     * @return  self
     */ 
    public function setConcurso_id($concurso_id)
    {
        $this->concurso_id = $concurso_id;

        return $this;
    }
}
?>