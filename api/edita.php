<?php
    require_once '../autoCargadores/autoCargador.php';
    $valido=true;    
    Sesion::iniciar();

    if (Sesion::estaLogeado()) {
        if (isset($_GET['tipo'])) {
            if (isset($_POST)) {
                try {
                    unset($_POST['imagen']);

                    if (isset($_POST['admin'])) {
                        $_POST['admin']=='on'?$_POST['admin']=1:$_POST['admin']=0;
                    }

                    if (isset($_POST['X']) && isset($_POST['Y'])) {
                        $_POST['localizacion']='POINT('.$_POST['X'].', '.$_POST['Y'].')';
                        unset($_POST['X']);
                        unset($_POST['Y']);
                    }

                    //GBD::update($_GET['tipo'],$_POST);
                    $sql="update ".$_GET['tipo']." set ";
                    $condicion=" where id=".$_POST['id'];
                    $keys=array_keys($_POST);

                    for ($i=0; $i < sizeof($keys) ; $i++) { 
                        if ($keys[$i]!='id') {
                            //si es la ultima linea no pongo coma, si si lo es la pongo
                            if ($i==sizeof($keys)-1) {
                                if ($keys[$i]=='admin' || $keys[$i]=='localizacion') {
                                    $sql.=$keys[$i]."= ".$_POST[$keys[$i]]." ";
                                }else{
                                    $sql.=$keys[$i]."= '".$_POST[$keys[$i]]."' ";
                                }
                            }else{
                                if ($keys[$i]=='admin' || $keys[$i]=='localizacion') {

                                    $sql.=$keys[$i]."= ".$_POST[$keys[$i]].", ";
                                }else{
                                    $sql.=$keys[$i]."= '".$_POST[$keys[$i]]."', ";
                                }
                            }
                        }
                    }

                    GBD::getConexion()->query($sql.$condicion);

                } catch (Exception $e) {
                    http_response_code(500);
                }
            }
        }
        http_response_code(200);
    }
?>