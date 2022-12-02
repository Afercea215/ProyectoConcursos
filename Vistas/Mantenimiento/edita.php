<?php
Class Edita{
    public static function imprimeEdita($id, $tipoDato){
        $datos = GBD::findById($tipoDato,$id);
        $keys = array_keys($datos);

        echo "<h2>Edición $tipoDato</h2>
              <form action='../../controladores/edita.php?tipoDato='$tipoDato class='c-form'>";
                for ($i=0; $i < sizeof($keys); $i++) { 
                    echo "<label for='".$keys[$i]."'>".$keys[$i]."</label>";
                    //datetime-local
                    if ($keys[$i]=='fini' && $keys[$i]=='ffin' && $keys[$i]=='finiInscrip' && $keys[$i]=='ffinInscrip') {
                        $fechaString = $datos[$keys[$i]];
                        echo "<input type='datetime-local' name='".$keys[$i]."' value='".$fechaString."'>".$keys[$i]."</label>";
                    }
                }
              echo "";
        
        echo "</form>";
    }
}
?>
    
</form>