<?php


function modificarEstadoPedidoTramitando(&$errores){
    $sql = "UPDATE `Historial` SET `estado` = 'Tramitando', WHERE (`ID_Pedido` = :pedido) and ID_Producto = :producto and fecha_envio IS NULL and fecha_Entregado IS NULL" ;
    $ret = false;
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["pedido"=> $_SESSION["datos"]["pedido"],"producto"=> $_SESSION["datos"]["producto"]];
        if ($stmt->execute($data)) {
            $res = $stmt->rowCount();
            
            if ($res != 0) {
                $ret=true;
            } else {
                
                $errores->errorBBDD[] = "No se han encontrado pedidos";
            }
        }else{
              
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
        
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        /**En caso de haber excepción será atrapada por el catch*/
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
         echo $ex->getMessage();
         $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
    };

    return $ret;
}
function modificarEstadoPedidoEnviado(&$errores){
    $sql = "UPDATE `Historial` SET `estado` = 'Enviado', `fecha_Envio` = CURRENT_DATE  WHERE (`ID_Pedido` = :pedido) and ID_Producto = :producto and fecha_Entregado IS NULL" ;
   
    $ret = false;
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["pedido"=> $_SESSION["datos"]["pedido"],"producto"=> $_SESSION["datos"]["producto"]];
        if ($stmt->execute($data)) {
            $res = $stmt->rowCount();
            
            if ($res != 0) {
                $ret=true;
            } else {
                
                $errores->errorBBDD[] = "No se han encontrado pedidos";
            }
        }else{
              
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
        
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        /**En caso de haber excepción será atrapada por el catch*/
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
         echo $ex->getMessage();
         $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
    };

    return $ret;
}
function modificarEstadoPedidoFinalizado(&$errores){
    $sql = "UPDATE `Historial` SET `estado` = 'Finalizado', `fecha_entregado` = CURRENT_DATE  WHERE (`ID_Pedido` = :pedido) and ID_Producto = :producto and  fecha_envio IS NOT NULL" ;
    $ret = false;
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["pedido"=> $_SESSION["datos"]["pedido"],"producto"=> $_SESSION["datos"]["producto"]];
        if ($stmt->execute($data)) {
            $res = $stmt->rowCount();
            
            if ($res != 0) {
                $ret=true;
            } else {
                
                $errores->errorBBDD[] = "No se han encontrado pedidos";
            }
        }else{
              
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
        
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        /**En caso de haber excepción será atrapada por el catch*/
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
         echo $ex->getMessage();
         $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
    };

    return $ret;
}

function modificarEstadoPedidoTramitandoAdmin(&$errores){
    $sql = "UPDATE `Historial` SET `estado` = 'Tramitando' , fecha_Envio = null ,fecha_Entregado = null  WHERE (`ID_Pedido` = :pedido) and ID_Producto = :producto" ;
    $ret = false;
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["pedido"=> $_SESSION["datos"]["pedido"],"producto"=> $_SESSION["datos"]["producto"]];
        if ($stmt->execute($data)) {
            $res = $stmt->rowCount();
            
            if ($res != 0) {
                $ret=true;
            } else {
                
                $errores->errorBBDD[] = "No se han encontrado pedidos";
            }
        }else{
              
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
        
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        /**En caso de haber excepción será atrapada por el catch*/
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
         echo $ex->getMessage();
         $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
    };

    return $ret;
}
function modificarEstadoPedidoEnviadoAdmin(&$errores){
    $sql = "UPDATE `Historial` SET `estado` = 'Enviado', fecha_Envio = CURRENT_DATE ,fecha_Entregado = null   WHERE (`ID_Pedido` = :pedido) and ID_Producto = :producto " ;
   
    $ret = false;
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["pedido"=> $_SESSION["datos"]["pedido"],"producto"=> $_SESSION["datos"]["producto"]];
        if ($stmt->execute($data)) {
            $res = $stmt->rowCount();
            
            if ($res != 0) {
                $ret=true;
            } else {
                
                $errores->errorBBDD[] = "No se han encontrado pedidos";
            }
        }else{
              
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
        
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        /**En caso de haber excepción será atrapada por el catch*/
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
         echo $ex->getMessage();
         $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
    };

    return $ret;
}
function modificarEstadoPedidoFinalizadoAdmin(&$errores){
    $sql = "UPDATE `Historial` SET `estado` = 'Finalizado', `fecha_envio` = CURRENT_DATE,`fecha_entregado` = CURRENT_DATE  WHERE (`ID_Pedido` = :pedido) and ID_Producto = :producto " ;
    $ret = false;
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["pedido"=> $_SESSION["datos"]["pedido"],"producto"=> $_SESSION["datos"]["producto"]];
        if ($stmt->execute($data)) {
            $res = $stmt->rowCount();
            
            if ($res != 0) {
                $ret=true;
            } else {
                
                $errores->errorBBDD[] = "El pedido ya esta en ese estado";
            }
        }else{
              
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
        
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        /**En caso de haber excepción será atrapada por el catch*/
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
         echo $ex->getMessage();
         $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
    };

    return $ret;
}


function modificarEstadoPedidoEntregadoAdmin(&$errores){
    $sql = "UPDATE `pedido` SET `estado` = 'Entregado'  WHERE (`ID_Pedido` = :pedido) ";
    $ret = false;
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["pedido"=> $_SESSION["datos"]["pedido"]];
        if ($stmt->execute($data)) {
            $res = $stmt->rowCount();
            
            if ($res != 0) {
                $ret=true;
            } else {
                
                $errores->errorBBDD[] = "No se han encontrado pedidos";
            }
        }else{
              
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
        
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        /**En caso de haber excepción será atrapada por el catch*/
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
         echo $ex->getMessage();
         $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
    };

    return $ret;
}
function modificarEstadoPedidoRealizadoAdmin(&$errores){
    $sql = "UPDATE `pedido` SET `estado` =  'Realizado' WHERE (`ID_Pedido` = :pedido)";
    $ret = false;
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["pedido"=> $_SESSION["datos"]["pedido"]];
        if ($stmt->execute($data)) {
            $res = $stmt->rowCount();
            
            if ($res != 0) {
                $ret=true;
            } else {
                
                $errores->errorBBDD[] = "No se han encontrado pedidos";
            }
        }else{
              
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
        
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        /**En caso de haber excepción será atrapada por el catch*/
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
         echo $ex->getMessage();
         $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
    };

    return $ret;
}

function modificarNoticia(&$errores){
    $sql = "UPDATE `delatierra`.`noticia` SET `Titulo`= :titulo, `Subtitulo`= :subtitulo,`imagen` = :imagen, `Fecha`= CURRENT_DATE, `Cuerpo`= :cuerpo, `Id_Administrador` = :idAdministrador WHERE (`Id_Noticia` = :idNoticia)";
    $ret = false;
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["titulo" =>  $_SESSION["datos"]["titulo"],  
        "subtitulo"=> $_SESSION["datos"]["subtitulo"], "imagen" =>$_SESSION["datos"]["imagen"], "idNoticia" =>$_SESSION["datos"]["id"],"cuerpo" =>$_SESSION["datos"]["cuerpo"],
        "idAdministrador" => $_SESSION["datosUsuario"]["id"]];
        if ($stmt->execute($data)) {
            $res = $stmt->rowCount();
            
            if ($res != 0) {
                $ret=true;
            } else {
                
                $errores->errorBBDD[] = "No se han encontrado noticias";
            }
        }else{
              
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
        
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        /**En caso de haber excepción será atrapada por el catch*/
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
         echo $ex->getMessage();
         $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
    };

    return $ret;
}
function passActual(&$errores, $id){
    $sql = "SELECT pass FROM `usuario`  WHERE (`ID_Usuario` = :id)";
    $ret = "";
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["id" => $id];
        if ($stmt->execute($data)) {
            $res = $stmt->fetch();
            
            if ($res != 0) {
                $ret=$res;
            } else {
                
                $errores->errorBBDD[] = "No se han podido modificar usuario";
            }
        }else{
              
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
        
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        /**En caso de haber excepción será atrapada por el catch*/
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
         echo $ex->getMessage();
         $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
    };

    return $ret;
}
function modificarUsuariosGlobal(&$errores){
    $sql = "UPDATE `usuario` SET `Nombre`= :nombre, `Apellido`= :apellidos,`nickname` = :usuario, `email`= :email, `dirección`= :direccion
    , `ciudad` = :ciudad, `provincia` = :provincia,`Codigo_Postal` = :cpostal,  `Id_Rol` = :rol  WHERE (`ID_Usuario` = :id)";
    $ret = false;
    //Usar para los acentos añadir a saneamiento
    
       
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["nombre" =>  $_SESSION["datos"]["nombre"],  "apellidos"=> $_SESSION["datos"]["apellidos"], 
        "usuario" =>$_SESSION["datos"]["nickname"], "email" =>$_SESSION["datos"]["email"],"direccion" =>$_SESSION["datos"]["direccion"],
        "ciudad" => $_SESSION["datos"]["ciudad"],"provincia" =>$_SESSION["datos"]["provincia"],"cpostal" =>$_SESSION["datos"]["cpostal"],
        "rol" =>  $_SESSION["datos"]["IDrol"],"id" => $_SESSION["datos"]["id"]];
        if ($stmt->execute($data)) {
            $res = $stmt->rowCount();
            
            if ($res != 0) {
                $ret=true;

            } else {
                
                $errores->errorBBDD[] = "No se han podido modificar usuario";
            }
        }else{
              
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
        
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        /**En caso de haber excepción será atrapada por el catch*/
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
         echo $ex->getMessage();
         $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
    };

    return $ret;
}
function modificarUsuariosPropio(&$errores){
    $sql = "UPDATE `usuario` SET `Nombre`= :nombre, `Apellido`= :apellidos,`nickname` = :usuario, `email`= :email, `dirección`= :direccion
    , `ciudad` = :ciudad, `provincia` = :provincia,`Codigo_Postal` = :cpostal  WHERE (`ID_Usuario` = :id)";
    $ret = false;
    //Usar para los acentos añadir a saneamiento
    
       
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["nombre" =>  $_SESSION["datos"]["nombre"],  "apellidos"=> $_SESSION["datos"]["apellidos"], 
        "usuario" =>$_SESSION["datos"]["nickname"], "email" =>$_SESSION["datos"]["email"],"direccion" =>$_SESSION["datos"]["direccion"],
        "ciudad" => $_SESSION["datos"]["ciudad"],"provincia" =>$_SESSION["datos"]["provincia"]
        ,"cpostal" =>$_SESSION["datos"]["cpostal"],"id" => $_SESSION["datosUsuario"]["id"]];
        if ($stmt->execute($data)) {
            $res = $stmt->rowCount();
            
            if ($res != 0) {
                $ret="Exito";
                $_SESSION["datosUsuario"]["usuario"]=$_SESSION["datos"]["nickname"];

            } else {
                $errores->errorBBDD[] = "No se han podido modificar datos";
            }
        }else{
              
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
        
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        /**En caso de haber excepción será atrapada por el catch*/
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
         echo $ex->getMessage();
         $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
    };

    return $ret;
}

/**Recoge los que ya existen */
function todosTiposRol(&$errores){
    $existentes=[];
    $sql = "select Tipo from rol";
    
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
           
            $res=$stmt->fetchAll();
            if ($res != 0) {
                foreach ($res as $key => $value) {
                    array_push($existentes,$value[0]);
                }
            } else {
                
                $errores->errorBBDD[] = "No se han podido modificar rol";
            }
        }else{
              
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
        
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        /**En caso de haber excepción será atrapada por el catch*/
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
         echo $ex->getMessage();
         $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
    };
    return $existentes;
}
function agregamosENUMTipos(&$errores,$existentes){
    $sql = "ALTER table rol MODIFY Tipo ENUM('".implode("','",$existentes)."',:nuevo)";
    $ret = false;
    
    //Usar para los acentos añadir a saneamiento
    
       
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["nuevo" =>  $_SESSION["datos"]["nombreRol"]];
        if ($stmt->execute($data)) {
           
            /*
            if ($res != 0) {
                $ret=true;
            } else {
                
                $errores->errorBBDD[] = "No se han podido modificar rol";
            }*/
        }else{
              
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
        
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        /**En caso de haber excepción será atrapada por el catch*/
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
         echo $ex->getMessage();
         $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
    };

    return $ret;
}
function modificarRol(&$errores){
    $existentes=todosTiposRol($errores);
    agregamosENUMTipos($errores,$existentes);
    $sql = "UPDATE rol SET `Tipo` = :nuevo WHERE ID_Rol = :rol ";
    $ret = false;
    
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["nuevo" =>  $_SESSION["datos"]["nombreRol"], "rol" => $_SESSION["datos"]["IDrol"]];
        if ($stmt->execute($data)) {
           
            $res=$stmt->rowCount();
            if ($res != 0) {
                $ret=true;
            } else {
                
                $errores->errorBBDD[] = "No se han podido modificar rol";
            }
        }else{
              
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
        
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        /**En caso de haber excepción será atrapada por el catch*/
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
         echo $ex->getMessage();
         $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
    };

    return $ret;
}
function existeObtencion(&$errores){
    try {
        $sql ="SELECT R.ID_Rol FROM obtencion O  ,rol R where  O.ID_Rol = R.ID_Rol and  R.Tipo = :tipo and ID_permiso = :id ";
        $pdo=conectar();
        $ret=false;
        $stmt = $pdo->prepare($sql);
        $data=["tipo" =>  $_SESSION["datos"]["Tipo"], "id" => $_SESSION["datos"]["id"]];
        if ($stmt->execute($data)) {
           
            $res=$stmt->fetch();
            if ($res != null) {
                $ret=true;
            } else {
                
                $errores->errorBBDD[] = "No se han podido modificar rol";
            }
        }else{
              
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
        
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        /**En caso de haber excepción será atrapada por el catch*/
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
         echo $ex->getMessage();
         $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
    };

    return $ret;
}
function modificaRolPermiso(&$errores){
    try {
        $sql ="UPDATE  obtencion SET ID_Rol = :idRol  where  ID_permiso = :id ";
        $pdo=conectar();
        $ret=false;
        $stmt = $pdo->prepare($sql);
        $data=["idRol" =>  $_SESSION["datos"]["nuevoRol"], "id" => $_SESSION["datos"]["id"]];
        if ($stmt->execute($data)) {
           
            $res=$stmt->rowCount();
            if ($res != 0) {
                $ret=true;
            } else {
                
                $errores->errorBBDD[] = "No se han podido modificar rol";
            }
        }else{
              
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
        
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        /**En caso de haber excepción será atrapada por el catch*/
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
         echo $ex->getMessage();
         $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
    };

    return $ret;
}
function modificarPermiso(&$errores){
    
    
    //Primero comprobamos si ha cambiado el rol
    $existe=existeObtencion($errores);
    //si coincide ese Permiso con rol quiere decir que no es necesario cambiarlo y aplicaremos los cambios necesarios.
    $ret = false;
    $sql = "UPDATE permiso SET `descripcion` = :descripcion, `nombre` = :nombre, `codigo` = :codigo, accion = :accion WHERE ID_Permiso = :id ";
    if(!$existe){
        $_SESSION["datos"]["nuevoRol"]=recuperarIDRol($errores);
        if($_SESSION["datos"]["nuevoRol"] != false){
            modificaRolPermiso($errores);
        }
    }
       
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["nombre" =>  $_SESSION["datos"]["nombrePermiso"], "codigo" => $_SESSION["datos"]["codigo"], "descripcion" => $_SESSION["datos"]["descripcion"]
        ,"accion" => $_SESSION["datos"]["cambiarAccion"], "id" => $_SESSION["datos"]["id"]];
        if ($stmt->execute($data)) {
           
            $res=$stmt->rowCount();
            if ($res != 0) {
                $ret=true;
            } else {
                
                $errores->errorBBDD[] = "No se han podido modificar rol";
            }
        }else{
              
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
        
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        /**En caso de haber excepción será atrapada por el catch*/
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
         echo $ex->getMessage();
         $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
    };

    return $ret;
}

function recuperarIDRol(&$errores){
    
     $ret = false;
     
     $sql = "SELECT ID_Rol from rol where Tipo = :tipo";
     
     try {
         
         $pdo=conectar();
         $stmt = $pdo->prepare($sql);
         $data=["tipo" =>  $_SESSION["datos"]["Tipo"]];
         if ($stmt->execute($data)) {
            
             $res=$stmt->fetch();
             if ($res != null) {
                 $ret=$res[0];
             } else {
                 
                 $errores->errorBBDD[] = "No se han podido modificar rol";
             }
         }else{
               
             $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
         }
         
     } catch (PDOException $ex) {
         /**En caso de haber excepción será atrapada por el catch*/
         /**En caso de haber excepción será atrapada por el catch*/
          // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
          //($_SESSION["ErrorDepuracion"]);
          echo $ex->getMessage();
          $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
     };
 
     return $ret;
 }


function modificarProductoGlobal(&$errores){
    $ret = false;
     $sql ="UPDATE `producto` SET `Nombre_Producto` = :nombre, `descripcion`= :descripcion,`imagen`= :imagen, `stock` = :stock, `descuento` = :descuento ,`precio` = :precio WHERE (`ID_Producto` = :id)";
   
     
     try {
         
         $pdo=conectar();
         $stmt = $pdo->prepare($sql);
         $data=["nombre" =>  $_SESSION["datos"]["nombre"],"descripcion" =>  $_SESSION["datos"]["descripcion"],"stock" =>  $_SESSION["datos"]["stock"],
         "descuento" =>  $_SESSION["datos"]["descuento"],"precio" =>  $_SESSION["datos"]["precio"],"imagen" => $_SESSION["datos"]["imagen"],"id" => $_SESSION["datos"]["id"]];
         if ($stmt->execute($data)) {
            
             $res=$stmt->rowCount();
             if ($res != 0) {
                 $ret=true;
             } else {
                 
                 $errores->errorBBDD[] = "No se han podido modificar Producto o son los mismos";
             }
         }else{
               
             $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
         }
         
     } catch (PDOException $ex) {
         /**En caso de haber excepción será atrapada por el catch*/
         /**En caso de haber excepción será atrapada por el catch*/
          // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
          //($_SESSION["ErrorDepuracion"]);
          echo $ex->getMessage();
          $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
     };
 
     return $ret;
}
function modificarProductosPropio(&$errores){
    $ret = false;
     $sql ="UPDATE `producto` SET `Nombre_Producto` = :nombre, `descripcion`= :descripcion,`imagen`= :imagen, `stock` = :stock, `descuento` = :descuento ,`precio` = :precio WHERE (`ID_Producto` = :producto) and `ID_vendedor` = :vendedor";
   
     
     try {
         
         $pdo=conectar();
         $stmt = $pdo->prepare($sql);
         $data=["nombre" =>  $_SESSION["datos"]["nombre"],"descripcion" =>  $_SESSION["datos"]["descripcion"],"stock" =>  $_SESSION["datos"]["stock"],
         "descuento" =>  $_SESSION["datos"]["descuento"],"precio" =>  $_SESSION["datos"]["precio"],"imagen" => $_SESSION["datos"]["imagen"], 
         "producto" => $_SESSION["datos"]["id"],"vendedor" => $_SESSION["datosUsuario"]["id"]];
         
         if ($stmt->execute($data)) {
            
             $res=$stmt->fetch();
             if ($res != null) {
                 $ret=true;
             } else {
                 
                 $errores->errorBBDD[] =  "No se han podido modificar Producto o son los mismos";
             }
         }else{
               
             $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
         }
         
     } catch (PDOException $ex) {
         /**En caso de haber excepción será atrapada por el catch*/
         /**En caso de haber excepción será atrapada por el catch*/
          // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
          //($_SESSION["ErrorDepuracion"]);
          echo $ex->getMessage();
          $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
     };
 
     return $ret;
}

?>