<?php
class GBD
{
    private $usuario="root";
    private $password="1234";
    private $dsn="mysql:host=localhost;dbname=concursos";
    private static $conexion;

  /*   public function __construct()
    {
        try
        {
            $this->conexion=getConexion();
        }
        catch(PDOException $e)
        {
            throw new PDOException("Error en la conexión: ".$e->getMessage());
        }
    } */

    /**
     * Devuelve la conexión
     *
     * @return void
     */
    public static function getConexion()
    {
        if (!isset(GBD::$conexion)) {
            GBD::$conexion=new PDO("mysql:host=localhost;dbname=concursos","root","1234",[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
        }
        return GBD::$conexion;
    }

    /**
     * Lee todos los registros de una tabla pudiendo seleccionar los campos
     *
     * @param string $tabla nombre de la tabla
     * @param array $campos campos a leer o null para todos
     * @return array de objetos con los datos
     */
    public static function getAll(string $tabla, array $campos=null)
    {
        $otroscampos=null;
        if(is_null($campos))
        {
            $otroscampos="*";
        }
        else
        {
            $otroscampos=implode(",",$campos);
        }
        $sql="select ".$otroscampos." from ".$tabla;
        try
        {
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        }
        catch(PDOException $e)
        {
            throw new PDOException("Error de lectura de datos: ".$e->getMessage());
        }
        
    }

    /**
     * Lee todos los registros de una tabla pudiendo seleccionar los campos
     *
     * @param string $tabla nombre de la tabla
     * @param array $campos campos a leer o null para todos
     * @return array de objetos con los datos
     */
    public static function getAllMultipleTables(array $tablas)
    {
        /* $otroscampos=null;
        if(is_null($campos))
        {
            $otroscampos="*";
        }
        else
        {
            $otroscampos=implode(",",$campos);
        } */
        //$sql="select * from ".$tablas[0][];
        for ($i=0; $i <count($tablas) ; $i++) { 
            $sql.=" join ".$tablas[$i]." on ".$tablas[$i-1].".id=".$tablas[$i].".id";
        }
        try
        {
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
            $datos=$consulta->fetchAll(PDO::FETCH_ASSOC);
            return $datos;
        }
        catch(PDOException $e)
        {
            throw new PDOException("Error de lectura de datos: ".$e->getMessage());
        }
        
    }
     

    /**
     * Devuelve el registro con clave primaria
     *
     * @param string $tabla
     * @param ibj $valoresid valores de la/s clave/s primaria/s
     * @return void
     */
    public static function findById(string $tabla,$id)
    {
        $sql="select * from ".$tabla." where ";
        $condicion="id=?";

        $sql.=$condicion;
         try
         {
             $consulta=GBD::getConexion()->prepare($sql);
             $consulta->execute([$id]);
             $datos=$consulta->fetch(PDO::FETCH_ASSOC);

             if (!$datos) {
                throw new Exception("Error leyendo por la id: ".$id);   
             }else{
                return $datos;
             }
         }
         catch(PDOException $e)
         {
            throw new PDOException($e->getMessage());
         }
         
    }

/*     public function findByOne(string $tabla,$campovalor)
    {
         $sql="select * from ".$tabla." where ".array_keys($campovalor)[0]." = ?";
         try
         {
             $consulta=$this->conexion->prepare($sql);
             $consulta->bindParam(1,array_values($campovalor)[0]);
             $consulta->execute();
             $datos=$consulta->fetchAll(PDO::FETCH_CLASS,$tabla);
             return $datos;
         }
         catch(PDOException $e)
         {
             throw new PDOException("Error leyendo por clave primaria: ".$e->getMessage());
         }
    } */

    /**
     * Inserta una fila en una tabla
     *
     * @param string $tabla nombre de la tabla
     * @param array $valores array asociativo <campo>=><valor>
     * @return void
     */
    public static function add(string $tabla, array $valores)
    {
        unset($valores['id']);
        ////////////////////////////////
        for ($i=0; $i <sizeof($valores); $i++) { 
            $valores[$i]=GBD::compruebaValorVacio($valores[$i]);
        }
        $campos=implode(",",array_keys($valores));
        $parametros=str_repeat("?,",count($valores));
        $parametros=rtrim($parametros,",");
        $sql="insert into ".$tabla." (".$campos.") values (".$parametros.")";
        //$sql = "INSERT INTO PARTICIPANTE VALUES (1,'sdf',1,'sdfds','ssdf','GeomFromText(POINT(20 10))','dfgdfgd','dfgdfg')";
        try
        {
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute( array_values($valores));
        }
        catch(PDOException $e)
        {
            throw new PDOException("Error insertando registro: ".$e->getMessage());
        }
       
    }

    /**
     * Modifica una fila
     *
     * @param string $tabla nomnre de la tabla
     * @param array $camposvalores array asociativo <campo>=><valor>
     * @param array $valoresid valores de la/s clave/s primaria/s
     * @return void
     */
    public static function update(string $tabla, array $valores)
    {
        $sql="update $tabla set ";
        $condicion="id =".$valores['id'];
        unset($valores['id']);
        
        $campos=implode("=?, ",array_keys($valores));
        $campos.="=?";
        $sql.=$campos." where ";
        $sql.=$condicion;
        try
        {
            $consulta=GBD::getConexion()->prepare($sql);
            $valores=array_values($valores);
            //$parametros=array_merge($valores,array_values($valores));
            $consulta->execute($valores);
        }
        catch(PDOException $e)
        {
            throw new PDOException("Error modificando fila: ".$e->getMessage());
        }
    }

    public static function updateQuery(string $tabla, array $valores)
    {
        $sql="update $tabla set ";
        $condicion="id =".$valores['id'];
        unset($valores['id']);
        
        $campos=implode("=?, ",array_keys($valores));
        $campos.="=?";
        $sql.=$campos." where ";
        $sql.=$condicion;
        try
        {
            $consulta=GBD::getConexion()->prepare($sql);
            $valores=array_values($valores);
            //$parametros=array_merge($valores,array_values($valores));
            $consulta->execute($valores);
        }
        catch(PDOException $e)
        {
            throw new PDOException("Error modificando fila: ".$e->getMessage());
        }
    }

    /**
     * Borra una fila de la tabla por clave primaria
     *
     * @param string $tabla nombre de la tabla
     * @param array $valoresid valores de la/s clave/s primaria/s
     * @return void
     */
    public static function delete(string $tabla, string $id)
    {
        $condicion="id = ".$id;
        $sql="delete from $tabla where ".$condicion;
        try
        {
            $consulta=GBD::getConexion()->prepare($sql);
            $consulta->execute();
        }
        catch(PDOException $e)
        {
            throw new PDOException("Error borrando fila:".$e->getMessage());
        }
    }

    public static function compruebaValorVacio($valor){
        if (!isset($valor)) {
            return null;
        } else {
            return $valor;
        }
    }

    public static function creaFecha(string $fecha){
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $fecha);
        $date->format('d/m/Y H:i:s');


        /* $date = DateTime::createFromFormat('Y-m-d H:i:s', $fecha);
        $date->format('d/m/Y'); */


        return $date;
        //return date_create($fecha);
    }

    /**
     * Devuelve el campo que es clave primaria
     *
     * @param [string] $tabla nombre de la tabla
     * @return array con los nombres de la/s clave/s primaria/s
     */
    private function getPrimaryKey(string $tabla)
    {
        $sql="SHOW KEYS FROM $tabla WHERE Key_name = 'PRIMARY'";
        $consulta=$this->conexion->query($sql);
        $datos=$consulta->fetchAll(PDO::FETCH_ASSOC);
        return array_column($datos,"Column_name");
    }

    /**
     * Get the value of dsn
     */ 
    public function getDsn()
    {
        return $this->dsn;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the value of usuario
     */ 
    public function getUsuario()
    {
        return $this->usuario;
    }
}
