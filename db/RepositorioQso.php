<?php
class RepositorioQso{
    public static $nomTabla="qso";

    public static function getById($id){
        try {
            $obj = GBD::findById(RepositorioQso::$nomTabla,$id);
            return Qso::arrayToQso($obj);    //code...
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function getEmisor($id)
    {

        $sql="select participante.* , ST_X(localizacion) as x,  ST_Y(localizacion) as y from participante join participacion on participante.id=participacion.participante_id
        join qso on qso.participacion_id=participacion.id
        where qso.id=$id";
        
        try
        {
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetch(PDO::FETCH_ASSOC);
            $participante = Participante::arrayToParticipante($datos);
            return $participante;
        } catch (Exception $e) {
            echo $e->getMessage();
        }   
    }

    public static function add(Qso $qso){
 
        $array = $qso->QsoToArray(); 
        $sql="insert into qso values (null,'".$array['fecha']->format('Y-m-d H:i:s')."',".$array['banda_id'].", ".$array['modo_id'].",".$array['participacion_id'].",".($array['valido']?"1":"0").",".$array['receptor_id'].")";
        //$sql = "INSERT INTO PARTICIPANTE VALUES (1,'sdf',1,'sdfds','ssdf','GeomFromText(POINT(20 10))','dfgdfgd','dfgdfg')";
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
    

    public static function aprobarMensaje($id){
        try {
            $sql = "update qso set valido=1 where id=$id";
            GBD::getConexion()->query($sql);
            //$parametros=array_merge($valores,array_values($valores));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }
    public static function update(Qso $qso){
        try {
            $valores = $qso->qsoToArray(); 
            $valores['fecha']=$valores['fecha']->format('Y-m-d H:i:s');
            //GBD::update(RepositorioParticipante::$nomTabla, $array);
            //$sql="update participante set identificador='".$valores['identificador']."', contrasena='".$valores['contrasena']."', admin=".$valores['admin'].", correo='".$valores['correo']."', localizacion=".$valores['localizacion'].", imagen='".$valores['imagen']."', nombre='".$valores['nombre']."' where id=".$valores['id'];
            $sql = "update qso set fecha='".$valores['fecha']."', banda_id=".$valores['banda_id'].", modo_id=".$valores['modo_id'].", participacion_id=".$valores['participacion_id'].", valido=".($valores['valido']?'1':'0').", receptor_id=".$valores['receptor_id']." where id=".$valores['id'];
            GBD::getConexion()->query($sql);
            //$parametros=array_merge($valores,array_values($valores));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

        public static function delete($id){
        try {
             GBD::delete(RepositorioQso::$nomTabla, $id);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function getAll(){
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