<?php
class RepositorioConcurso{
    public static $nomTabla="concurso";


    public static function getPag($pag, $crecimiento, $orderBy='id'){
        try {
            $obj = GBD::getPag(RepositorioConcurso::$nomTabla, $pag, $orderBy, $crecimiento, $tamañoPag=5);
            $concursos=[];
            for ($i=0; $i <sizeof($obj) ; $i++) { 
                $concursos[$i]=Concurso::arrayToConcurso($obj[$i]);
            }
            return $concursos;    //code...
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function getById($id){
        try {
            $obj = GBD::findById(RepositorioConcurso::$nomTabla,$id);
            return Concurso::arrayToConcurso($obj);    //code...
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function add(Concurso $concurso){
        try {
            $array = $concurso->concursoToArray(); 
             GBD::add(RepositorioConcurso::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function update(Concurso $concurso){
        try {
            $array = $concurso->concursoToArray(); 
             GBD::update(RepositorioConcurso::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

        public static function delete($id){
        try {
             GBD::delete(RepositorioConcurso::$nomTabla, $id);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        
    }

    public static function getAll(){
        $concursos = GBD::getAll("concurso");
        for ($i=0; $i <sizeof($concursos); $i++) { 
            $concursosObj[]=Concurso::arrayToConcurso($concursos[$i]);
        }
        return $concursosObj;
    }
public static function getJueces($id){
        $partipantes = RepositorioConcurso::getParticipantes($id);
        for ($i=0; $i <sizeof($partipantes); $i++) { 
            if ($partipantes[$i]['juez']) {
                $array[]=$partipantes[$i]['participante'];
            }
        }
        return $array;
    }

    public static function getBandas($id){

        $sql="SELECT banda.* FROM banda join banda_tiene_concurso on banda.id=banda_tiene_concurso.banda_id where concurso_id=".$id;
        try
        {
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetchAll(PDO::FETCH_ASSOC);
            if ($datos) {
                for ($i=0; $i <sizeof($datos); $i++) { 
                    $id = $datos[$i]['id'];
                    $distancia = $datos[$i]['distancia'];
                    $rangoMin = $datos[$i]['rangoMin'];
                    $rangoMax = $datos[$i]['rangoMax'];
    
                    $bandasObj[]=new Banda($id,$distancia,$rangoMin,$rangoMax);
                }
            }else{
                return false;
            }

            return $bandasObj;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function getModos($id){
        $sql="select modo.*, modo_tiene_concurso.premio from modo join modo_tiene_concurso on modo.id=modo_tiene_concurso.modo_id where modo_tiene_concurso.concurso_id=".$id;
        try
        {
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetchAll(PDO::FETCH_ASSOC);

            //for ($i=0; $i <sizeof($datos); $i++) { 
                //$modosObj[]=new Modo($datos[$i]['id'],$datos[$i]['banda.id']);
            //}
            
            return $datos;
        } catch (Exception $e) {
            echo $e->getMessage();
        }       
    }

    public static function getGanadoresDiplomas($id){
        
    }

    public static function getMensajes($id,$orderBy,$tipoOrden,$pag,$tamañoPag=5)
    {
        $limit=$tamañoPag;
        $offset=($pag-1)*$tamañoPag;

        $sql="select qso.* , banda.distancia, banda.rangoMin, banda.rangoMax, modo.nombre, participante.nombre as 'nombreUsuario', participante.identificador from participacion
        join qso on qso.participacion_id=participacion.id
        join participante on participante.id=participacion.participante_id
        join modo on modo.id=qso.modo_id
        join banda on banda.id=qso.banda_id

        where participacion.concurso_id=$id
        order by $orderBy $tipoOrden limit $limit offset $offset";
        
        try
        {
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetchAll(PDO::FETCH_ASSOC);

            if ($datos) {
                for ($i=0; $i <sizeof($datos); $i++) { 
                   $id=$datos[$i]['id'];
                   $fecha=$datos[$i]['fecha'];
                   $banda_id=$datos[$i]['banda_id'];
                   $modo_id=$datos[$i]['modo_id'];
                   $receptor_id=$datos[$i]['receptor_id'];
                   $participacion=$datos[$i]['participacion_id'];
                   $valido=$datos[$i]['valido'];
                   $mensaje=new Qso($id,$fecha,$valido,$receptor_id,$banda_id,$modo_id,$participacion,$valido);
                   
                   $mensajes[$i]['qso']=$mensaje;
                   $mensajes[$i]['banda']=[$datos[$i]['distancia'],$datos[$i]['rangoMin'],$datos[$i]['rangoMax']];
                   $mensajes[$i]['modo']=$datos[$i]['nombre'];
                   $mensajes[$i]['emisor']=$datos[$i]['nombreUsuario'];
   
               }
            }else{
                return false;
            }
            
            return $mensajes;
        } catch (Exception $e) {
            echo $e->getMessage();
        }  
    }
    
    public static function getParticipantes($id)
    {
        $sql="select participante.*, ST_X(localizacion) as x,  ST_Y(localizacion) as y, participacion.juez from participante join participacion on participante.id=participacion.participante_id where participacion.concurso_id=$id";
        try
        {
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetchAll(PDO::FETCH_ASSOC);
            if ($datos) {
                for ($i=0; $i <sizeof($datos); $i++) {    
                    $participantesObj[$i]['juez']=($datos[$i]['juez']=='1')?true:false;
                    unset($datos[$i]['juez']);
                    $participantesObj[$i]['participante']=Participante::arrayToParticipante($datos[$i]);
                                 
                } 
            }else{
                return false;
            }
            return $participantesObj;
        } catch (Exception $e) {
            echo $e->getMessage();
        }   
    }

    public static function getMensajesParticipante($idParticipante, $idConcurso ,$orderBy,$tipoOrden,$pag,$tamañoPag=5)
    {
        $limit=$tamañoPag;
        $offset=($pag-1)*$tamañoPag;

        $sql="select qso.* from participacion join qso on qso.participacion_id=participacion.id
        where participacion.concurso_id=$idConcurso and participacion.participante_id=$idParticipante
        order by $orderBy $tipoOrden limit $limit offset $offset";
        
        try
        {
            $qsoObj=[];
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetchAll(PDO::FETCH_ASSOC);
            for ($i=0; $i <sizeof($datos); $i++) {                 
                $qsoObj[]=Qso::arrayToQso($datos[$i]);
            } 
            return $qsoObj;
        } catch (Exception $e) {
            echo $e->getMessage();
        }   
    }

    ////////////TO DO
    public static function getGanadorModo($id)
    {
        
    }

    ////////////TO DO
    public static function getGanadoresDiploma(){

    }

    public static function getActivos(){

        $sql="SELECT * FROM concurso
        WHERE fini < now()
        AND ffin > now()
        ORDER BY fini desc";
        
        try
        {
            $obj=[];
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetchAll(PDO::FETCH_ASSOC);
            for ($i=0; $i <sizeof($datos); $i++) {                 
                $obj[]=Concurso::arrayToConcurso($datos[$i]);
            } 
            return $obj;
        } catch (Exception $e) {
            echo $e->getMessage();
        } 
    }

    public static function getFinalizados(){
        $sql="SELECT * FROM concurso
        WHERE ffin < now()
        ORDER BY ffin desc";
        
        try
        {
            $obj=[];
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetchAll(PDO::FETCH_ASSOC);
            for ($i=0; $i <sizeof($datos); $i++) {                 
                $obj[]=Concurso::arrayToConcurso($datos[$i]);
            } 
            return $obj;
        } catch (Exception $e) {
            echo $e->getMessage();
        } 
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