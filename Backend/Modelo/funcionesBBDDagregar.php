<?php 

function agregarNoticia(&$errores){
    $sql = "INSERT INTO `noticia` (`Titulo`, `Subtitulo`, `imagen`,`Fecha`, `Cuerpo`, `Id_Administrador`)
     VALUES ( :titulo, :subtitulo,:imagen,CURRENT_DATE, :cuerpo,:id)";
    $ret = false;
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["titulo" =>  $_SESSION["datos"]["titulo"],  
        "subtitulo"=> $_SESSION["datos"]["subtitulo"], "imagen" =>$_SESSION["datos"]["imagen"],
        "cuerpo" =>$_SESSION["datos"]["cuerpo"],"id" => $_SESSION["datosUsuario"]["id"]];
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

function existePermiso(&$errores){
    $ret = true;
    $sql = "SELECT nombre , codigo from permiso where codigo= :codigo and nombre= :nombre";
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["nombre" =>  $_SESSION["datos"]["nombre"], "codigo" => $_SESSION["datos"]["codigo"]];
        if ($stmt->execute($data)) {
           
            $res=$stmt->rowCount();
            
            if ($res != 0) {
                $ret=false;
                $errores->errorBBDD[] = "Ya existe un permiso con ese codigo y nombre";
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

function agregarRolPermiso(&$errores){
    try {
        $sql ="INSERT  INTO obtencion (ID_Rol ,ID_permiso ) VALUES( :rol ,:permiso )";
        $pdo=conectar();
        $ret=false;
        $stmt = $pdo->prepare($sql);
        $data=["rol" =>  $_SESSION["datos"]["IDrol"], "permiso" => $_SESSION["datos"]["id"]];
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
function agregarPermiso(&$errores){
    
    
    //comprobarmos si hay ya un permiso con el nombre accion o codigo
    //si no existe lo añadiremos a  permiso y luego en modificarRolPermiso en obtencion
    $existe=existePermiso($errores);
    //si coincide ese Permiso con rol quiere decir que no es necesario cambiarlo y aplicaremos los cambios necesarios.
    $ret = false;
    $sql = "INSERT INTO permiso (`descripcion` , `nombre` , `codigo`, `accion`) VALUES(:descripcion,:nombre,:codigo,:accion)";
    if($existe){
       
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["nombre" =>  $_SESSION["datos"]["nombre"], "codigo" => $_SESSION["datos"]["codigo"], "descripcion" => $_SESSION["datos"]["descripcion"]
        ,"accion" => $_SESSION["datos"]["cambiarAccion"]];
        if ($stmt->execute($data)) {
           
            $res=$stmt->rowCount();
            if ($res != 0) {
                $ret=true;
                $_SESSION["datos"]["id"]= $pdo->lastInsertId();
                agregarRolPermiso($errores);
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
}
    return $ret;
}

function agregarUsuariosGlobal(&$errores)
{
    //crear un select y evitar hacer insert si hay duplicaciones
    //donde no debe haberlas.
    $NoDuplicado = datosDuplicados($errores);
    $respuesta = false;
    if ($NoDuplicado) {
        $ret = false;
        IDrol();
        $sql = "INSERT INTO `usuario` (`Nombre`, `Apellido`, `nickname`,`email`, `dirección`, `ciudad`, `provincia`, `Codigo_Postal`, `DNI`, `pass`, `Id_Rol`) 
        VALUES (:nombre, :apellido,:usuario,:email, :direccion, :ciudad, :provincia, :codigopostal, :DNI, :pass, :rol);";

        try {
            $pdo = conectar();
            $stmt = $pdo->prepare($sql);
            
            $data = [
                'usuario' =>  $_SESSION["datos"]["usuarioNuevo"],
                'pass' =>  $_SESSION["datos"]["pass"],
                'nombre' =>  $_SESSION["datos"]["nombre"],
                'apellido' =>   $_SESSION["datos"]["apellidos"],
                'direccion' => $_SESSION["datos"]["direccion"],
                'provincia' =>  $_SESSION["datos"]["provincia"],
                'ciudad' =>  $_SESSION["datos"]["ciudad"],
                'codigopostal' =>  $_SESSION["datos"]["cpostal"],
                'email' =>  $_SESSION["datos"]["email"],
                'DNI' =>  $_SESSION["datos"]["DNI"],
                'rol' =>  $_SESSION["datos"]["rol"]
            ];

            if ($stmt->execute($data)) {
                $ret = $stmt->rowCount();
                if ($ret == 1) {
                    $respuesta = true;
                } else {

                    $errores->errorBBDD[] = "No se ha registrado correctamente";
                }
            } else {

                $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
            }
        }

        //Else por si hay algún error
        catch (PDOException $ex) {
            /**En caso de haber excepción será atrapada por el catch*/
            //Usarlo si es necesario.
           // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
            //($_SESSION["ErrorDepuracion"]);
            var_dump($ex->getMessage());
        };
    }
   
    return $respuesta;
}
function agregarProductoGlobal(&$errores){
    $ret = false;
     $sql ="INSERT INTO `producto` (`Nombre_Producto`, `descripcion`,`imagen`, `precio`, `stock`, `descuento`,`ID_vendedor`) 
     VALUES(:nombre,:descripcion,:imagen,:precio,:stock,:descuento,:id)";
   
     
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
function agregarProductoPropio(&$errores){
    $ret = false;
     $sql ="INSERT INTO `producto` (`Nombre_Producto`, `descripcion`,`imagen`,`precio`, `stock`, `descuento`,`ID_vendedor`) 
     VALUES(:nombre,:descripcion,:imagen,:precio,:stock,:descuento,:id)";
   
     
     try {
         
         $pdo=conectar();
         $stmt = $pdo->prepare($sql);
         $data=["nombre" =>  $_SESSION["datos"]["nombre"],"descripcion" =>  $_SESSION["datos"]["descripcion"],"stock" =>  $_SESSION["datos"]["stock"],
         "descuento" =>  $_SESSION["datos"]["descuento"],"precio" =>  $_SESSION["datos"]["precio"],
         "imagen" => $_SESSION["datos"]["imagen"],"id" => $_SESSION["datosUsuario"]["id"]];
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
function agregarRol(&$errores){
    $existentes=todosTiposRol($errores);
    agregamosENUMTipos($errores,$existentes);
    $sql = "INSERT INTO rol (`Tipo`) VALUES(:nuevo) ";
    $ret = false;
    
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["nuevo" =>  $_SESSION["datos"]["nombreRol"]];
        if ($stmt->execute($data)) {
           
            $res=$stmt->rowCount();
            if ($res != 0) {
                $ret=true;
            } else {
                
                $errores->errorBBDD[] = "No se han podido agregar rol";
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

function enviarMensajeAdminUsuario($errores){
    $sql = "INSERT INTO mensajesprivados (`asunto`,`mensaje`,`fecha_envio`,`email`,`usuario`,`ID_Administrador`) VALUES(:asunto,:mensaje,CURRENT_DATE,:email,:usuario,1) ";
    $ret = false;
    $id=recuperarIDUsuario($errores);
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["asunto" =>  $_SESSION["datos"]["asunto"],"mensaje" =>  $_SESSION["datos"]["mensaje"],"email" =>  $_SESSION["datos"]["email"],
        "usuario" =>  $id];
        if ($stmt->execute($data)) {
           
            $res=$stmt->rowCount();
            if ($res != 0) {
                $ret=true;
            } else {
                
                $errores->errorBBDD[] = "No se han podido agregar rol";
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

function enviarMensajeAdminAnonimo($errores){
    $sql = "INSERT INTO mensajesprivados (`asunto`,`mensaje`,`fecha_envio`,`email`,`ID_Administrador`) VALUES(:asunto,:mensaje,CURRENT_DATE,:email,1) ";
    $ret = false;
    
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["asunto" =>  $_SESSION["datos"]["asunto"],"mensaje" =>  $_SESSION["datos"]["mensaje"],"email" =>  $_SESSION["datos"]["email"]];
        if ($stmt->execute($data)) {
           
            $res=$stmt->rowCount();
            if ($res != 0) {
                $ret=true;
            } else {
                
                $errores->errorBBDD[] = "No se han podido agregar rol";
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

function leerMensajesPrivados($errores){
    $sql = "SELECT * FROM mensajesprivados where ID_Administrador = :id";
    $ret = false;
    
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data= ["id"=> $_SESSION["datosUsuario"]["id"]];
        if ($stmt->execute($data)) {
            
            $res=$stmt->fetchAll();
            if ($res != null) {
                $ret=true;
                for ($x = 0; $x < count($res); $x++) {
                    $clase = new stdClass();
                    $clase->id = $res[$x][0];
                    $clase->asunto = $res[$x][1];
                    $clase->mensaje = $res[$x][2];
                    $clase->fechaEnvio = $res[$x][3];
                    $clase->email = $res[$x][4];
                    $clase->usuario = $res[$x][5];
                    $clase->estado = $res[$x][6];

                    $array[] = $clase;
                }
            }
            else{
                $errores->errorBBDD[] = "Usuario o contraseña incorrectos";
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

    return  $array;
}
function contestadoMensaje($errores){
    $ret = false;
    $sql ="UPDATE `mensajesprivados` SET `estado` = 'Contestado' WHERE `ID_Mensaje` = :id";
  
    
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["id" =>  $_SESSION["datos"]["id"]];
        
        if ($stmt->execute($data)) {
           
            $res=$stmt->rowCount();
            if ($res != 0) {
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

function comprobarStock($errores){
    $ret = false;
    $sql ="SELECT * FROM delatierra.producto where stock >= :cantidad and ID_Producto = :producto";
  
    
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["cantidad" =>  $_SESSION["datos"]["cantidad"],"producto" =>  $_SESSION["datos"]["producto"]];
        
        if ($stmt->execute($data)) {
           
            $res=$stmt->rowCount();
            if ($res != 0) {
                $ret=true;
            } else {
                
                $errores->errorBBDD[] =  "No hay suficiente Stock";
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

function recuperarIDUsuario(&$errores)
 {   
     
     $ret = false;
     $usuario= $_SESSION["datos"]["usuario"];
     //Sentencia sql para conseguir los datos del usuario que deseamos usar.
     $sql = "select ID_Usuario from usuario where nickname = :usuario";
     try {
         //Conectamos la base de datos
         $ret = false;
         $pdo = conectar();
         
         //Hacemos la sentencia preparada
         $stmt = $pdo->prepare($sql);
         $stmt->bindParam(":usuario",$usuario,PDO::PARAM_STR);
         if ($stmt->execute()) {
             $res = $stmt->fetch(PDO::FETCH_ASSOC);
             //Si es correcta insertamos datos
             if ($res != null) {
                 $ret = $res["ID_Usuario"];
             }
             else{
                 $errores->errorBBDD[] = "Usuario o contraseña incorrectos";
             }
             
         }else{
             
             $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
         }
 
        
     }
 
     //Else por si hay algún error
     catch (PDOException $ex) {
         /**En caso de haber excepción será atrapada por el catch*/
         $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
     };
 
     return $ret;
     /*Por si se borrara el localstorage manualmente y entraras de nuevo realmente la sesión la tienes ya abierta comprobaremoso
         que coinciden con los de la sesión iniciada*/
 }

 function agregarPedido(&$errores,$productos)
 {   
     
     $ret = false;
     $total=calcularTotalPedido($productos);
     //Sentencia sql para conseguir los datos del usuario que deseamos usar.
     $sql = "INSERT INTO  pedido(fecha_realizado,total,ID_comprador) VALUES(CURRENT_DATE,:total,:usuario) ";
     try {
         //Conectamos la base de datos
         $ret = false;
         $pdo = conectar();
         
         //Hacemos la sentencia preparada
         $stmt = $pdo->prepare($sql);
         $data=["usuario"=> $_SESSION["datosUsuario"]["id"], "total"=>$total];
         if ($stmt->execute($data)) {
             $res = $stmt->rowCount();
             //Si es correcta insertamos datos
             if ($res != null) {
                $_SESSION["datos"]["nuevoPedido"]=$pdo->lastInsertId();
                
             }
             else{
                 $errores->errorBBDD[] = "Usuario o contraseña incorrectos";
             }
             
         }else{
             
             $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
         }
 
        
     }
 
     //Else por si hay algún error
     catch (PDOException $ex) {
        $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
         /**En caso de haber excepción será atrapada por el catch*/
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
         echo $ex->getMessage();
     };
 
     return $ret;
     /*Por si se borrara el localstorage manualmente y entraras de nuevo realmente la sesión la tienes ya abierta comprobaremoso
         que coinciden con los de la sesión iniciada*/
 }
 function agregarEnvio(&$errores,$productos)
 {   
     
     $ret = false;
     //Sentencia sql para conseguir los datos del usuario que deseamos usar.
     $sql = "INSERT INTO  historial(cantidad,ID_Producto,ID_Pedido) VALUES(:cantidad,:producto,:pedido) ";
     try {
         //Conectamos la base de datos
         $ret = false;
         $pdo = conectar();
         
         //Hacemos la sentencia preparada
         $stmt = $pdo->prepare($sql);
         $data=["pedido"=> $_SESSION["datos"]["nuevoPedido"], "cantidad"=>$productos[2], "producto"=>$productos[0]];
         if ($stmt->execute($data)) {
             $res = $stmt->rowCount();
             //Si es correcta insertamos datos
             if ($res != null) {
                //cambiar stock
                cambiarStockProducto($errores,$productos[0],$productos[2]);
             }
             else{
                 $errores->errorBBDD[] = "Usuario o contraseña incorrectos";
             }
             
         }else{
             
             $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
         }
 
        
     }
 
     //Else por si hay algún error
     catch (PDOException $ex) {
        $errores->errorBBDD[] = "Ha habido algún problema envio intenteló de nuevo";
         /**En caso de haber excepción será atrapada por el catch*/
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
         //echo $ex->getMessage();
     };
 
     return $ret;
     /*Por si se borrara el localstorage manualmente y entraras de nuevo realmente la sesión la tienes ya abierta comprobaremoso
         que coinciden con los de la sesión iniciada*/
 }

 function cambiarStockProducto(&$errores,$producto,$cantidad)
 {   
     
     $ret = false;
     //Sentencia sql para conseguir los datos del usuario que deseamos usar.
     $sql = "UPDATE producto  set `stock` = (`stock` - :cantidad) where ID_Producto = :producto ";
     try {
         //Conectamos la base de datos
         $ret = false;
         $pdo = conectar();
         
         //Hacemos la sentencia preparada
         $stmt = $pdo->prepare($sql);
         $data=["cantidad"=>$cantidad, "producto"=>$producto];
         if ($stmt->execute($data)) {
             $res = $stmt->rowCount();
             //Si es correcta insertamos datos
             if ($res != null) {
                ////
             }
             else{
                 $errores->errorBBDD[] = "Usuario o contraseña incorrectos";
             }
             
         }else{
             
             $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
         }
 
        
     }
 
     //Else por si hay algún error
     catch (PDOException $ex) {
        //$errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
         /**En caso de haber excepción será atrapada por el catch*/
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
         echo $ex->getMessage();
     };
 
     return $ret;
     /*Por si se borrara el localstorage manualmente y entraras de nuevo realmente la sesión la tienes ya abierta comprobaremoso
         que coinciden con los de la sesión iniciada*/
 }
?>