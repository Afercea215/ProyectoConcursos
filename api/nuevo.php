<?php
    require_once '../autoCargadores/autoCargador.php';
    $valido=true;    
    Sesion::iniciar();

    if (Sesion::estaLogeado() && Sesion::esAdmin()) {
        if (isset($_GET['tipo'])) {
            if (isset($_POST)) {
                try {

                    if (isset($_POST['admin'])) {
                        $_POST['admin']=='on'?$_POST['admin']=1:$_POST['admin']=0;
                    }

                    if (isset($_POST['X']) && isset($_POST['Y'])) {
                        $_POST['localizacion']='POINT('.$_POST['X'].', '.$_POST['Y'].')';
                        unset($_POST['X']);
                        unset($_POST['Y']);
                    }

                    //GBD::update($_GET['tipo'],$_POST);
                    $sql="insert into ".$_GET['tipo']."(";

                    $keys=array_keys($_POST);
                    for ($i=0; $i <sizeof($_POST) ; $i++) { 
                        if ($i!=sizeof($_POST)-1) {
                            $sql.=$keys[$i].",";
                        }else{
                            $sql.=$keys[$i].")";
                        }
                    }
                    $sql.=" values (";
                    for ($i=0; $i <sizeof($_POST) ; $i++) { 
                        if ($i!=sizeof($_POST)-1) {
                            if ($keys[$i]=='distancia' || $keys[$i]=='rangoMax' || $keys[$i]=='rangoMin') {
                                $sql.=$_POST[$keys[$i]].", ";
                            }else if ($keys[$i]=='id' || $keys[$i]=='Id') {
                                $sql.="null,";
                            }else if ($keys[$i]=='localizacion') {
                                $sql.=$_POST[$keys[$i]].",";
                            }else{  
                                $sql.="'".$_POST[$keys[$i]]."',";
                            }
                        }else{
                            if ($keys[$i]=='distancia' || $keys[$i]=='rangoMax' || $keys[$i]=='rangoMax') {
                                $sql.=$_POST[$keys[$i]].")";
                            }else if ($keys[$i]=='localizacion') {
                                $sql.=$_POST[$keys[$i]].")";
                            }else{
                                $sql.="'".$_POST[$keys[$i]]."')";
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