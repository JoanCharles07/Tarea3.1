<?php 
/**
 * Esta función agrega una noticia a la BBDD
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
function agregarNoticia(&$errores){
    $sql = "INSERT INTO `Noticia` (`Titulo`, `Subtitulo`, `imagen`,`Fecha`, `Cuerpo`, `Id_Administrador`)
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
                
                $errores->errorBBDD[] = "No se ha podido agregar noticia";
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
/**
 * Esta función comprueba si existe Permiso en la BBDD y así poder agregarlo desde la otra función
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
function existePermiso(&$errores){
    $ret = true;
    $sql = "SELECT nombre , codigo from Permiso where codigo= :codigo and nombre= :nombre";
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
/**
 * Esta función agrega a un permiso el rol correspondiente que puede hacerlo.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
function agregarRolPermiso(&$errores){
    try {
        $sql ="INSERT  INTO Obtencion (ID_Rol ,ID_permiso ) VALUES( :rol ,:permiso )";
        $pdo=conectar();
        $ret=false;
        $stmt = $pdo->prepare($sql);
        $data=["rol" =>  $_SESSION["datos"]["IDrol"], "permiso" => $_SESSION["datos"]["id"]];
        if ($stmt->execute($data)) {
           
            $res=$stmt->rowCount();
            if ($res != 0) {
                $ret=true;
            } else {
                
                $errores->errorBBDD[] = "No se han podido agregar rol permiso";
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
/**
 * Esta función agrega un nuevo permiso a la BBDD.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @see existerPermiso() comprueba que no haya otro permiso igual.
 * @return [BOOLEAN]  con resultado de la operación
 */
function agregarPermiso(&$errores){
    
    
    //comprobarmos si hay ya un permiso con el nombre accion o codigo
    //si no existe lo añadiremos a  permiso y luego en modificarRolPermiso en obtencion
    $existe=existePermiso($errores);
    //si coincide ese Permiso con rol quiere decir que no es necesario cambiarlo y aplicaremos los cambios necesarios.
    $ret = false;
    $sql = "INSERT INTO Permiso (`descripcion` , `nombre` , `codigo`, `accion`) VALUES(:descripcion,:nombre,:codigo,:accion)";
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
                
                $errores->errorBBDD[] = "No se han podido agregar permisos";
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
/**
 * Esta función agrega un nuevo usuario a la BBDD.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @see datosDuplicados() comprueba que no haya otro usuario igual.
 * @return [BOOLEAN]  con resultado de la operación
 */
function agregarUsuariosGlobal(&$errores)
{
    //crear un select y evitar hacer insert si hay duplicaciones
    //donde no debe haberlas.
    $NoDuplicado = datosDuplicados($errores);
    $respuesta = false;
    if ($NoDuplicado) {
        $ret = false;
        IDrol();
        $sql = "INSERT INTO `Usuario` (`Nombre`, `Apellido`, `nickname`,`email`, `dirección`, `ciudad`, `provincia`, `Codigo_Postal`, `DNI`, `pass`, `Id_Rol`) 
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

                    $errores->errorBBDD[] = "No se ha podido agregar usuario";
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
/**
 * Esta función agrega un nuevo producto a la BBDD.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
function agregarProductoGlobal(&$errores){
    $ret = false;
     $sql ="INSERT INTO `Producto` (`Nombre_Producto`, `descripcion`,`imagen`, `precio`, `stock`, `descuento`,`ID_vendedor`) 
     VALUES(:nombre,:descripcion,:imagen,:precio,:stock,:descuento,:id)";
   
     
     try {
         //valido si va vacio
         $pdo=conectar();
         $stmt = $pdo->prepare($sql);
         $data=["nombre" =>  $_SESSION["datos"]["nombre"],"descripcion" =>  $_SESSION["datos"]["descripcion"],"stock" =>  $_SESSION["datos"]["stock"],
         "descuento" =>  $_SESSION["datos"]["descuento"],"precio" =>  $_SESSION["datos"]["precio"],"imagen" => $_SESSION["datos"]["imagen"],"id" => $_SESSION["datos"]["id"]];
         if ($stmt->execute($data)) {
            
             $res=$stmt->rowCount();
             if ($res != 0) {
                 $ret=true;
             } else {
                 
                 $errores->errorBBDD[] = "No se han podido agregar Producto";
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
/**
 * Esta función agrega un nuevo producto a la BBDD de un agricultor en concreto.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
function agregarProductoPropio(&$errores){
    $ret = false;
     $sql ="INSERT INTO `Producto` (`Nombre_Producto`, `descripcion`,`imagen`,`precio`, `stock`, `descuento`,`ID_vendedor`) 
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
                 
                 $errores->errorBBDD[] = "No se han podido agregar Producto";
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
/**
 * Esta función agrega un nuevo Rol a la BBDD.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @see todosTiposRol() comprueba que no haya otro Rol igual.
 * @see agregamosENUMTipos() añadimos al enum tipos el nuevo tipo de rol.
 * @return [BOOLEAN]  con resultado de la operación
 */
function agregarRol(&$errores){
    $existentes=todosTiposRol($errores);
    agregamosENUMTipos($errores,$existentes);
    $sql = "INSERT INTO Rol (`Tipo`) VALUES(:nuevo) ";
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

/**
 * Esta función comprueba que hay Stock suficiente en la BBDD del producto para poder comprarla .
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
function comprobarStock($errores){
    $ret = false;
    $sql ="SELECT * FROM Producto where stock >= :cantidad and ID_Producto = :producto";
  
    
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
/**
 * Esta función recupera el ID del usuario mediante el nickname guardado en la sesion.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
function recuperarIDUsuario(&$errores)
 {   
     
     $ret = false;
     $usuario= $_SESSION["datos"]["usuario"];
     //Sentencia sql para conseguir los datos del usuario que deseamos usar.
     $sql = "select ID_Usuario from Usuario where nickname = :usuario";
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
                 $errores->errorBBDD[] = "No se puede conseguir ID usuario";
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
     $sql = "INSERT INTO  Pedido(fecha_realizado,total,ID_comprador) VALUES(CURRENT_DATE,:total,:usuario) ";
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
                 $errores->errorBBDD[] = "No se pudo calcular el total del pedido";
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
     $sql = "INSERT INTO  Historial(cantidad,precioVenta,ID_Producto,ID_Pedido) VALUES(:cantidad,:precio,:producto,:pedido) ";
     try {
         //Conectamos la base de datos
         $ret = false;
         $pdo = conectar();
         
         //Hacemos la sentencia preparada
         $stmt = $pdo->prepare($sql);
         $data=["pedido"=> $_SESSION["datos"]["nuevoPedido"], "cantidad"=>$productos[2],"precio"=>$productos[1], "producto"=>$productos[0]];
         if ($stmt->execute($data)) {
             $res = $stmt->rowCount();
             //Si es correcta insertamos datos
             if ($res != null) {
                //cambiar stock
                cambiarStockProducto($errores,$productos[0],$productos[2]);
             }
             else{
                 $errores->errorBBDD[] = "No se pudo realizar envío,pruebe más tarde";
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
     $sql = "UPDATE Producto  set `stock` = (`stock` - :cantidad) where ID_Producto = :producto ";
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