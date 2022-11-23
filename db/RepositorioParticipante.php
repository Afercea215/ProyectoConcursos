<?php
class RepositorioParticipante{
    public static $nomTabla="participante";

    public static function getByNombreContra($nombre, $contrasena){
        try {
            
            $sql="select *, ST_X(localizacion) as x,  ST_Y(localizacion) as y from ".RepositorioParticipante::$nomTabla." where nombre like '".$nombre."' and contrasena like '".$contrasena."'";
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetch(PDO::FETCH_ASSOC);
            if ($datos) {
                return Participante::arrayToParticipante($datos);
            }else{
                return false;
            }
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /* public static function getRol($id, $contrasena){
        try {
            
            $sql="select * from ".RepositorioParticipante::$nomTabla." where identificador like '".$identificador."' and contrasena like '".$contrasena."'";
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetch(PDO::FETCH_ASSOC);

            if (!$datos) {
                return false;
            } else{
                return true;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } */

    public static function getById($id){
        try {
            /*$obj = GBD::findById(RepositorioParticipante::$nomTabla,$id);
            return Participante::arrayToParticipante($obj);    //code... */
            $sql="select *, ST_X(localizacion) as x,  ST_Y(localizacion) as y from ".RepositorioParticipante::$nomTabla." where ";
            $condicion="id=?";
            $sql.=$condicion;
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute([$id]);
            $datos=$consulta->fetchAll(PDO::FETCH_ASSOC);

            if (!$datos) {
                throw new Exception("Error leyendo por la id: ".$id);   
            }
            return Participante::arrayToParticipante($datos);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function getByNombre(string $nombre){
        try {
            $sql="select *, ST_X(localizacion) as x,  ST_Y(localizacion) as y from ".RepositorioParticipante::$nomTabla." where nombre like '".$nombre."'";
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetch(PDO::FETCH_ASSOC);
            if ($datos) {
                return Participante::arrayToParticipante($datos);
            }else{
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }  
    }

    public static function getImagenByNombre(string $nombre){
        try {
            $sql="select imagen from ".RepositorioParticipante::$nomTabla." where nombre like '".$nombre."'";
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetch(PDO::FETCH_ASSOC);
            if ($datos) {
                return $datos['imagen'];
            }else{
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }  
    }

    public static function getByCorreo(string $correo){
        try {
            $sql="select *, ST_X(localizacion) as x,  ST_Y(localizacion) as y from ".RepositorioParticipante::$nomTabla." where correo like '".$correo."'";
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetch(PDO::FETCH_ASSOC);
            if ($datos) {
                return Participante::arrayToParticipante($datos);
            }else{
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }  
    }

    public static function add(Participante $participante){
        try {
            /* ST_GeomFromText() */
            $array = $participante->ParticipanteToArray();
            //$localizacion = $array['localizacion']->getX()." ".$array['localizacion']->getY();
            //$array['localizacion']="GeomFromText(".$array['localizacion'].")";
            $loca = $array['localizacion']."";
            $admin = $array['admin']==false?"false":"true";
            GBD::getConexion()->query('INSERT INTO PARTICIPANTE (identificador, admin, contrasena, correo, localizacion, imagen, nombre)
                                        VALUES ("'.$array['identificador'].'",'.$admin.', "'.$array['contrasena'].'", "'.$array['correo'].'", '.$loca.', "'.$array['imagen'].'", "'.$array['nombre'].'")');
    
            //GBD::add(RepositorioParticipante::$nomTabla, $array);

        } catch (Exception $e) {
            echo $e->getMessage();
        }  
    }
    

    public static function update(Participante $participante){
        try {
            $valores = $participante->participanteToArray(); 
            //GBD::update(RepositorioParticipante::$nomTabla, $array);
            //$sql="update participante set identificador='".$valores['identificador']."', contrasena='".$valores['contrasena']."', admin=".$valores['admin'].", correo='".$valores['correo']."', localizacion=".$valores['localizacion'].", imagen='".$valores['imagen']."', nombre='".$valores['nombre']."' where id=".$valores['id'];
            GBD::getConexion()->query("update participante set identificador='".$valores['identificador']."', contrasena='".$valores['contrasena']."', admin=".$valores['admin'].", correo='".$valores['correo']."', localizacion=".$valores['localizacion'].", imagen='".$valores['imagen']."', nombre='".$valores['nombre']."' where id=".$valores['id']."");
            //$parametros=array_merge($valores,array_values($valores));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

        public static function delete($id){
        try {
             GBD::delete(RepositorioParticipante::$nomTabla, $id);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function getAllArray(){
        $sql="select id, identificador, admin, correo, contrasena, contrasena, imagen, nombre, ST_X(localizacion) as x,  ST_Y(localizacion) as y from ".RepositorioParticipante::$nomTabla;
        $consulta=GBD::getConexion()->prepare($sql);
        $consulta->execute();
        $datos=$consulta->fetchAll(PDO::FETCH_ASSOC);

    /*     for ($i=0; $i <sizeof($datos) ; $i++) { 
            unset($datos[$i]['localizacion']);
        } */
        

        /* for ($i=0; $i <sizeof($datos); $i++) { 
            $participantesObj[]=Participante::arrayToParticipante($datos[$i]);
        } */
        return $datos;
    }

    public static function getAll(){
        $sql="select *, ST_X(localizacion) as x,  ST_Y(localizacion) as y from ".RepositorioParticipante::$nomTabla;
        $consulta=GBD::getConexion()->prepare($sql);
        $consulta->execute([]);
        $datos=$consulta->fetchAll(PDO::FETCH_ASSOC);

        for ($i=0; $i <sizeof($datos); $i++) { 
            $participantesObj[]=Participante::arrayToParticipante($datos[$i]);
        }
        return $participantesObj;
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