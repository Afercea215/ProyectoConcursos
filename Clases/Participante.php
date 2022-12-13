<?php
class Participante{
    private $id;
    private string $identificador;
    private string $contrasena;
    private bool $admin;
    private string $correo;
    private Point $localizacion;
    private $imagen;
    private $nombre;

    public function __construct(int $id, string $identificador, string $contrasena, bool $admin, string $correo, Point $localizacion, string $nombre, string $imagen='')
    {
        $this->setId($id);
        $this->setIdentificador($identificador);
        $this->setContrasena($contrasena);
        $this->setAdmin($admin);
        $this->setCorreo($correo);
        $this->setLocalizacion($localizacion);
        $this->setImagen($imagen);
        $this->setNombre($nombre);

    }
        
    /**
     * arrayToParticipante
     * Convierte un array a un obj Participante
     * @param  mixed $array
     * @param  mixed $incluyeTabla
     * @return Participante
     */
    public static function arrayToParticipante(array $array, $incluyeTabla=false): Participante{
        $tabla="";
        if ($incluyeTabla) {
            $tabla=RepositorioParticipante::$nomTabla.".";
        }
        $id=$array[$tabla.'id'];
        $identificador=$array[$tabla.'identificador']; 
        $contrasena=GBD::encriptaContrasena($array[$tabla.'contrasena']); 
        $admin=($array[$tabla.'admin']==null)?false:$array[$tabla.'admin']; 
        $correo=$array[$tabla.'correo']; 
        $localizacion=new Point($tabla.$array['x'], $tabla.$array['y']); 
        $imagen=$array[$tabla.'imagen']; 
        $nombre=$array[$tabla.'nombre']; 
        
        return new Participante($id, $identificador, $contrasena, $admin, $correo, $localizacion, $nombre, $imagen);
    }
    
    /**
     * participanteToArray
     * Convierte un participante a un array
     * @return array
     */
    public function participanteToArray():array{
            $array['id']=$this->getId();
            $array['identificador']=$this->getIdentificador();
            $array['contrasena']=$this->getContrasena();
            $array['admin']=$this->getAdmin();
            $array['correo']=$this->getCorreo();
            $array['localizacion']=$this->getLocalizacion()->__toString();
            $array['imagen']=$this->getImagen();
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
     * Get the value of identificador
     */ 
    public function getIdentificador()
    {
        return $this->identificador;
    }

    /**
     * Set the value of identificador
     *
     * @return  self
     */ 
    public function setIdentificador($identificador)
    {
        $this->identificador = $identificador;

        return $this;
    }

    /**
     * Get the value of admin
     */ 
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Set the value of admin
     *
     * @return  self
     */ 
    public function setAdmin($admin)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Get the value of correo
     */ 
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set the value of correo
     *
     * @return  self
     */ 
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get the value of localizacion
     */ 
    public function getLocalizacion()
    {
        return $this->localizacion;
    }

    /**
     * Set the value of localizacion
     *
     * @return  self
     */ 
    public function setLocalizacion($localizacion)
    {
        $this->localizacion = $localizacion;

        return $this;
    }

    /**
     * Get the value of imagen
     */ 
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set the value of imagen
     *
     * @return  self
     */ 
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

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

    /**
     * Get the value of contrasena
     */ 
    public function getContrasena()
    {
        return $this->contrasena;
    }

    /**
     * Set the value of contrasena
     *
     * @return  self
     */ 
    public function setContrasena($contrasena)
    {
        $this->contrasena = $contrasena;

        return $this;
    }
}
?>