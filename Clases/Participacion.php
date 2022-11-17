<?php
class Participacion{
    private $id;
    private bool $juez;
    private int $concurso_id;
    private int $participante_id;

    public function __construct(int $id, bool $juez, string $concurso_id, string $participante_id)
    {
        $this->setId($id);
        $this->setJuez($juez);
        $this->setConcurso_id($concurso_id);
        $this->setParticipante_id($participante_id);
    }

    public static function arrayToParticipacion(array $array): Participacion{
        $id=$array['id'];
        $juez=$array['juez']; 
        $concurso_id=$array['concurso_id']; 
        $participante_id=$array['participante_id']; 
        return new Participacion($id, $juez, $concurso_id, $participante_id);
    }

    public function participacionToArray (){
            $array['id']=$this->getId();
            $array['juez']=$this->getJuez();
            $array['concurso_id']=$this->getConcurso_id();
            $array['participante_id']=$this->getParticipante_id();            
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
     * Get the value of juez
     */ 
    public function getJuez()
    {
        return $this->juez;
    }

    /**
     * Set the value of juez
     *
     * @return  self
     */ 
    public function setJuez($juez)
    {
        $this->juez = $juez;

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

    /**
     * Get the value of participante_id
     */ 
    public function getParticipante_id()
    {
        return $this->participante_id;
    }

    /**
     * Set the value of participante_id
     *
     * @return  self
     */ 
    public function setParticipante_id($participante_id)
    {
        $this->participante_id = $participante_id;

        return $this;
    }
}
?>