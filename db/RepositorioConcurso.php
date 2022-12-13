<?php
class RepositorioConcurso{
    public static $nomTabla="concurso";

        
    /**
     * inscribeParticipante
     * Incribe un participante en un concurso en especifico
     * @param  mixed $idConcurso
     * @param  mixed $idParticipante
     * @return void
     */
    public static function inscribeParticipante($idConcurso, $idParticipante)
    {
        $sql="insert into participacion values(null,false,$idConcurso,$idParticipante)";
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

        
    /**
     * getPag
     * Devuelve la pagina indicada de los concurso, indicando el orden y crecimiento
     * @param  mixed $pag Pagina a devolver
     * @param  mixed $crecimiento ASC o DESC
     * @param  mixed $orderBy columna por la que se quiere ordenar
     * @return array
     */
    public static function getPag($pag, $crecimiento, $orderBy='id'):array{
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

        
        
    /**
     * getById
     * Devuelve un concurso por la id
     * @param  mixed $id
     * @return Concurso
     */
    public static function getById($id):Concurso{
        try {
            $obj = GBD::findById(RepositorioConcurso::$nomTabla,$id);
            return Concurso::arrayToConcurso($obj);    //code...
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public static function getUltimo(){
        try {
            $sql = 'select * from concurso order by id desc limit 1';
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetch(PDO::FETCH_ASSOC);
            
            return Concurso::arrayToConcurso($datos);

        } catch (Exception $e) {
            echo $e->getMessage();
        }  
    }


    
    /**
     * addBanda
     * Añade una banda al concurso
     * @param  mixed $idConcurso
     * @param  mixed $idBanda
     * @return void
     */
    public static function addBanda($idConcurso, $idBanda){
        try {
            $sql = "INSERT INTO BANDA_TIENE_CONCURSO VALUES($idBanda,$idConcurso)";
                            
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();

        } catch (Exception $e) {
            echo $e->getMessage();
        }  
    }

        
    /**
     * deleteBanda
     * Borra una banda del concurso
     * @param  mixed $idConcurso
     * @param  mixed $idBanda
     * @return void
     */
    public static function deleteBanda($idConcurso, $idBanda){
        try {
            $sql = "DELETE FROM BANDA_TIENE_CONCURSO WHERE banda_id=$idBanda and concurso_id=$idConcurso";
                            
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }  
    }

        
    /**
     * existeBanda
     * Comprueba si una banda esta participando en un concurso
     * @param  mixed $idConcurso
     * @param  mixed $idBanda
     * @return bool true | false
     */
    public static function existeBanda($idConcurso, $idBanda):bool{
        try {
            $sql = "select * from concurso 
                            join banda_tiene_concurso on concurso.id=banda_tiene_concurso.concurso_id
                            where concurso.id=$idConcurso and banda_tiene_concurso.banda_id=$idBanda";

            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetch(PDO::FETCH_ASSOC);
            
            if ($datos) {
                return true;
            }else{
                return false;
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }  
    }

        
    /**
     * addModo
     * Añade un modo a el concurso
     * @param  mixed $idConcurso
     * @param  mixed $idModo
     * @param  mixed $cartel
     * @return void
     */
    public static function addModo($idConcurso, $idModo, $cartel){
        try {
            $sql = "INSERT INTO Modo_TIENE_CONCURSO VALUES($idModo,$idConcurso,'$cartel')";
                            
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();

        } catch (Exception $e) {
            echo $e->getMessage();
        }  
    }

        
    /**
     * deleteModo
     * Borra un modo de un concurso
     * @param  mixed $idConcurso
     * @param  mixed $idModo
     * @return void
     */
    public static function deleteModo($idConcurso, $idModo){
        try {
            $sql = "DELETE FROM MODO_TIENE_CONCURSO WHERE modo_id=$idModo and concurso_id=$idConcurso";
                            
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }  
    }

        
    /**
     * existeModo
     *  Comprueba si existe el modo en un concurso
     * @param  mixed $idConcurso
     * @param  mixed $idModo
     * @return bool
     */
    public static function existeModo($idConcurso, $idModo):bool{
        try {
            $sql = "select * from concurso 
                            join modo_tiene_concurso on concurso.id=modo_tiene_concurso.concurso_id
                            where concurso.id=$idConcurso and modo_tiene_concurso.modo_id=$idModo";

            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetch(PDO::FETCH_ASSOC);
            
            if ($datos) {
                return true;
            }else{
                return false;
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }  
    }

    
    /**
     * addParticipante
     * Añade una participacion de un participante a un concurso
     * @param  mixed $idConcurso
     * @param  mixed $idParticipante
     * @return void
     */
    public static function addParticipante($idConcurso, $idParticipante){
        try {
            $sql = "INSERT INTO participacion VALUES(null, 0, $idConcurso, $idParticipante)";
                            
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();

        } catch (Exception $e) {
            echo $e->getMessage();
        }  
    }
    
    /**
     * deleteParticipante
     * Borra la participacion de un participante a un concurso
     * @param  mixed $idConcurso
     * @param  mixed $idParticipante
     * @return void
     */
    public static function deleteParticipante($idConcurso, $idParticipante){
        try {
            $sql = "DELETE FROM participacion WHERE participante_id=$idParticipante and concurso_id=$idConcurso";
                            
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }  
    }
    
    /**
     * participanteEstaInscrito
     * Comprueba si un participante esta inscrito
     * @param  mixed $idConcurso
     * @param  mixed $idParticipante
     * @return bool
     */
    public static function participanteEstaInscrito($idConcurso, $idParticipante):bool{
        try {
            $sql = "select * from participacion
                            where concurso_id=$idConcurso and participante_id=$idParticipante";

            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetch(PDO::FETCH_ASSOC);
            
            if ($datos) {
                return true;
            }else{
                return false;
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }  
    }

    public static function existeParticipante($idConcurso, $idParticipante){
        try {
            $sql = "select * from participacion
                            where concurso_id=$idConcurso and participante_id=$idParticipante";

            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetch(PDO::FETCH_ASSOC);
            
            if ($datos) {
                return true;
            }else{
                return false;
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }  
    }

    
    /**
     * add
     * Inserta un concuros a la bd
     * @param  mixed $concurso
     * @return void
     */
    public static function add(Concurso $concurso){
        try {
            /* ST_GeomFromText() */
            $array = $concurso->concursoToArray();
            $sql = 'INSERT INTO concurso (nombre, descrip, fini, ffin, finiInscrip, ffinInscrip, cartel)
                    VALUES ("'.$array['nombre'].'","'.$array['descrip'].'", "'.$array['fini'].'", "'.$array['ffin'].'", "'.$array['finiInscrip'].'", "'.$array['ffinInscrip'].'", "'.$array['cartel'].'")';
            GBD::getConexion()->query($sql);

        } catch (Exception $e) {
            echo $e->getMessage();
        }  
    }
    
    /**
     * update
     * Actualiza un concurso
     * @param  mixed $concurso
     * @return void
     */
    public static function update(Concurso $concurso){
        try {
            $array = $concurso->concursoToArray(); 
             GBD::update(RepositorioConcurso::$nomTabla, $array);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }
    
    /**
     * delete
     * Borra un concurso
     * @param  mixed $id
     * @return void
     */
    public static function delete($id){
        try {
             GBD::delete(RepositorioConcurso::$nomTabla, $id);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        
    }
    
    /**
     * getAll
     * Get todos los concursos de la bd
     * @return array de Concursos
     */
    public static function getAll():array{
        $concursos = GBD::getAll("concurso");
        for ($i=0; $i <sizeof($concursos); $i++) { 
            $concursosObj[]=Concurso::arrayToConcurso($concursos[$i]);
        }
        return $concursosObj;
    }
    
    /**
     * getJueces
     * Consigo los jueces del concurso
     * @param  mixed $id
     * @return array
     */
    public static function getJueces($id):array{
        $partipantes = RepositorioConcurso::getParticipantes($id);
        for ($i=0; $i <sizeof($partipantes); $i++) { 
            if ($partipantes[$i]['juez']) {
                $array[]=$partipantes[$i]['participante'];
            }
        }
        return $array;
    }
    
    /**
     * getBandas
     * Consigo las bandas de un concurso
     * @param  mixed $id
     * @return void
     */
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

        
    /**
     * getModos
     * Consigo los modos de un concurso
     * @param  mixed $id
     * @return array
     */
    public static function getModos($id):array{
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
    
    /**
     * getMensajes
     * Consgio todos los mensajes del concurso por pag, ordenacion y tamaño
     * @param  mixed $id
     * @param  mixed $orderBy
     * @param  mixed $tipoOrden
     * @param  mixed $pag
     * @param  mixed $tama
     * @return void
     */
    public static function getMensajes($id,$orderBy,$tipoOrden,$pag,$tamañoPag=5):array
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

        
    /**
     * getGandorModo
     * Devuelve el ganador de un modo de un concurso
     * @param  mixed $idModo
     * @param  mixed $idConcurso
     * @return array
     */
    public static function getGandorModo($idModo,$idConcurso):array
    {

        $sql="
        select count(*)'cantidad',participacion.participante_id from participacion join qso on qso.participacion_id=participacion.id
                                    join concurso on concurso.id=participacion.concurso_id
                                    join modo_tiene_concurso on modo_tiene_concurso.concurso_id=concurso.id
                                    
                                    where concurso.id=$idConcurso and modo_tiene_concurso.modo_id=$idModo
                                    group by participacion.participante_id
                                    order by 'cantidad';";
        
        try
        {
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetch(PDO::FETCH_ASSOC);

            if ($datos) {
                return $datos['participante_id'];
            }else{
                return false;
            }
            
            return $datos;
        } catch (Exception $e) {
            echo $e->getMessage();
        }  
    }
        
    /**
     * getParticipantes
     * Consigo todos los participantes del concurso
     * @param  mixed $id
     * @return array
     */
    public static function getParticipantes($id):array
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
    
    /**
     * getMensajesParticipante
     * Consigo los mensajes de un participante en un concurso
     * @param  mixed $idParticipante
     * @param  mixed $idConcurso
     * @param  mixed $orderBy
     * @param  mixed $tipoOrden
     * @param  mixed $pag
     * @param  mixed $tama
     * @return array
     */
    public static function getMensajesParticipante($idParticipante, $idConcurso ,$orderBy,$tipoOrden,$pag,$tamañoPag=5):array
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
    
    /**
     * getUltimoActivo
     * Consigue el ultino concurso creado
     * @return Concurso
     */
    public static function getUltimoActivo():Concurso{

        $sql="SELECT * FROM concurso
        WHERE fini < now()
        AND ffin > now()
        ORDER BY fini desc";
        
        try
        {
            $obj=[];
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetch(PDO::FETCH_ASSOC);  

            return Concurso::arrayToConcurso($datos);
        } catch (Exception $e) {
            echo $e->getMessage();
        } 
    }
    
    /**
     * getActivos
     * Consigo loa concrusos activos
     * @return array
     */
    public static function getActivos():array{

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

        
    /**
     * getFinalizados
     * Consigue los concursis finalizados
     * @return array
     */
    public static function getFinalizados():array{
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