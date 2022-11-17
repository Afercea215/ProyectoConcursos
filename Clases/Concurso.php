<?php
    class Concurso{
        private $id;
        private $nombre;
        private $descrip;
        private DateTime $fIni;
        private DateTime $fFin;
        private DateTime $fIniInscrip;
        private DateTime $fFinInscrip;
        private $cartel;

        public function __construct(int $id, string $nombre, string $descrip,string $fIni,string $fFin,string $fIniInscrip,string $fFinInscrip,$cartel)
        {
            $this->setId($id);
            $this->setNombre($nombre);
            $this->setDescrip($descrip);
            $this->setFIni($fIni);
            $this->setFFin($fFin);
            $this->setFIniInscrip($fIniInscrip);
            $this->setFFinInscrip($fFinInscrip);
            $this->setCartel($cartel);
        }


        public static function arrayToConcurso(array $array): Concurso{
                $id=$array['id'];
                $nombre=$array['nombre'];
                $descrip=$array['descrip'];
                $fIni = $array['fini']; 
                $fFin = $array['ffin'];
                $fIniInscrip=$array['finiInscrip'];
                $fFinInscrip=$array['ffinInscrip'];
                $cartel=$array['cartel'];
                return new Concurso($id, $nombre, $descrip, $fIni, $fFin, $fIniInscrip, $fFinInscrip, $cartel);
        }


        public function concursoToArray (){
                $array['id']=$this->getId();
                $array['nombre']=$this->getNombre();
                $array['descrip']=$this->getDescrip();
                $array['fini']=$this->getFIni()->format('Y-m-d H:i:s');
                $array['ffin']=$this->getFFin()->format('Y-m-d H:i:s');
                $array['finiInscrip']=$this->getFIniInscrip()->format('Y-m-d H:i:s');
                $array['ffinInscrip']=$this->getFFinInscrip()->format('Y-m-d H:i:s');
                $array['cartel']=$this->getCartel();
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
         * Get the value of desc
         */ 
        public function getDescrip()
        {
                return $this->descrip;
        }

        /**
         * Set the value of desc
         *
         * @return  self
         */ 
        public function setDescrip($descrip)
        {
                $this->descrip = $descrip;

                return $this;
        }

        /**
         * Get the value of fIni
         */ 
        public function getFIni()
        {
                return $this->fIni;
        }

        /**
         * Set the value of fIni
         *
         * @return  self
         */ 
        public function setFIni($fIni)
        {
                $this->fIni = GBD::creaFecha($fIni);

                return $this;
        }

        /**
         * Get the value of fFin
         */ 
        public function getFFin()
        {
                return $this->fFin;
        }

        /**
         * Set the value of fFin
         *
         * @return  self
         */ 
        public function setFFin($fFin)
        {
                $this->fFin = GBD::creaFecha($fFin);

                return $this;
        }

        /**
         * Get the value of fIniInscrip
         */ 
        public function getFIniInscrip()
        {
                return $this->fIniInscrip;
        }

        /**
         * Set the value of fIniInscrip
         *
         * @return  self
         */ 
        public function setFIniInscrip($fIniInscrip)
        {
                $this->fIniInscrip = GBD::creaFecha($fIniInscrip);

                return $this;
        }

        /**
         * Get the value of fFinInscrip
         */ 
        public function getFFinInscrip()
        {
                return $this->fFinInscrip;
        }

        /**
         * Set the value of fFinInscrip
         *
         * @return  self
         */ 
        public function setFFinInscrip($fFinInscrip)
        {
                $this->fFinInscrip = GBD::creaFecha($fFinInscrip);

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

        /**
         * Get the value of cartel
         */ 
        public function getCartel()
        {
                return $this->cartel;
        }

        /**
         * Set the value of cartel
         *
         * @return  self
         */ 
        public function setCartel($cartel)
        {
                $this->cartel = $cartel;

                return $this;
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
         * @return  self
         */ 
        public function setNombre($nombre)
        {
                $this->nombre = $nombre;

                return $this;
        }
    }
?>