<?php

/**
 * Este script contendrá todas las funciones que conectan con la base de datos.
 * 
 * @author Juan Carlos Rodríguez Miranda
 * @version 1.0.0
 */

 /**
 * Esta función confirma si existe el comentario.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [Boolean] con resultado de la operación
 */
function existeComentario(&$errores){
    $sql = "SELECT * FROM comentario where ID_Producto = :idPro and ID_Comprador = :idCom";
    $producto= $_SESSION["datos"]["IDproducto"];
    $comprador=$_SESSION["datosUsuario"]["id"] ;
    $res=false;
    try {
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data = ['idPro' => $producto , 'idCom' => $comprador];
        if ($stmt->execute($data)) {
            $res = $stmt->rowCount();
            if ($res == 0) {
                $res=true;
            } 
            else{
                $res=false;
                $errores->errorBBDD[] = "Ya has comentado en este producto.";
            }
        }else{
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        //Usarlo si es necesario.
           // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
            //($_SESSION["ErrorDepuracion"]);
    };

    return $res;
}

 /**
 * Esta función borra el producto añadido por un usuario en concreto
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [Boolean] con resultado de la operación
 */
function borrarCarrito(&$errores){
    $sql = "DELETE FROM carrito where ID_Producto = :idPro and ID_comprador = :idCom";
    $producto= $_SESSION["datos"]["id"];
    $comprador=$_SESSION["datosUsuario"]["id"] ;
    $res=false;
    try {
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data = ['idPro' => $producto , 'idCom' => $comprador];
        if ($stmt->execute($data)) {
            $res = $stmt->rowCount();
            if ($res != 0) {
                $res=true;
            } 
            else{
                $res=false;
                $errores->errorBBDD[] = "Ya has comentado en este producto.";
            }
        }else{
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        //Usarlo si es necesario.
           // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
            //($_SESSION["ErrorDepuracion"]);
    };

    return $res;
}
 /**
 * Esta función borrar todos los productos que un usario tiene en el carrito.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [Boolean] con resultado de la operación
 */
function borrarCarritoCompleto(&$errores){
    $sql = "DELETE FROM carrito where ID_comprador = :idCom";
    $comprador=$_SESSION["datosUsuario"]["id"] ;
    $res=false;
    try {
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data = ['idCom' => $comprador];
        if ($stmt->execute($data)) {
            $res = $stmt->rowCount();
            if ($res != 0) {
                $res=true;
            } 
            else{
                $res=false;
                $errores->errorBBDD[] = "Ya has comentado en este producto.";
            }
        }else{
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        //Usarlo si es necesario.
           // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
            //($_SESSION["ErrorDepuracion"]);
    };

    return $res;
}
/**
 * Esta función confirma si exise en el carrito.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [Boolean] con resultado de la operación
 */
function existeEnCarrito(&$errores){
    $sql = "SELECT * FROM carrito where ID_Producto = :idPro and ID_comprador = :idCom";
    $producto= $_SESSION["datos"]["id"];
    $comprador=$_SESSION["datosUsuario"]["id"] ;
    $res=false;
    try {
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data = ['idPro' => $producto , 'idCom' => $comprador];
        if ($stmt->execute($data)) {
            $res = $stmt->rowCount();
            if ($res == 0) {
                $res=true;
            } 
            else{
                $res=false;
                $errores->errorBBDD[] = "Ya has comentado en este producto.";
            }
        }else{
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        //Usarlo si es necesario.
           // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
            //($_SESSION["ErrorDepuracion"]);
    };

    return $res;
}
    
/**
 * Esta función agrega producto al carrito.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @see existeComentario() confirma si existe en el carrito.
 * @return [Boolean] con resultado de la operación
 */
 function agregarComentario(&$errores){
   
    //Comprobar que no tiene ya comentario en este producto
   
    $NoDuplicado = existeComentario($errores);
    $respuesta=false;
    if ($NoDuplicado) {
        $ret = false;
        $sql = "INSERT INTO `comentario` (`Mensaje`, `valoracion`,`fecha`, `ID_comprador`,`ID_Producto`) 
        VALUES (:comentario, :valoracion,DATE(now()),:comprador,:producto);";
        
        try {
            $pdo = conectar();
            $stmt = $pdo->prepare($sql);
            
            $data = [
                'comentario' =>  $_SESSION["datos"]["comentarioTexto"],
                'valoracion' =>  $_SESSION["datos"]["estrellasEscogidas"],
                'comprador' =>  $_SESSION["datosUsuario"]["id"],
                'producto' =>   $_SESSION["datos"]["IDproducto"]
            ];

            if ($stmt->execute($data)) {
                $ret = $stmt->rowCount();
                if ($ret == 1) {
                    

                    $respuesta = true;
                    //Añadimos datos que nos faltan para el usuario dentro del servidor.
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
            $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
            echo json_encode($_SESSION["ErrorDepuracion"]);
        };
    }
    return $respuesta;
}

/**
 * Esta función agrega producto al carrito.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @see existeCarrito() confirma si existe en el carrito.
 * @see modificarCarrito Si existe en el carrito esta función añadirá la cantidad.
 * @return [Boolean] con resultado de la operación
 */
function agregarCarrito(&$errores){
   
    //Comprobar que no existe, si existe se cambia directamente en la otra
    
    $NoDuplicado = existeEnCarrito($errores);
    $respuesta=false;
    if ($NoDuplicado) {
        $ret = false;
        $sql = "INSERT INTO `carrito` (`cantidad`, `ID_comprador`,`ID_Producto`) 
        VALUES (:cantidad,:comprador,:producto);";
        
        try {
            $pdo = conectar();
            $stmt = $pdo->prepare($sql);
          
            
            $data = [
                'cantidad' =>  $_SESSION["datos"]["cantidad"],
                'comprador' =>  $_SESSION["datosUsuario"]["id"],
                'producto' =>   $_SESSION["datos"]["id"]
            ];

            if ($stmt->execute($data)) {
                $ret = $stmt->rowCount();
                
                if ($ret == 1) {
                    
                    
                    $respuesta = true;
                    //Añadimos datos que nos faltan para el usuario dentro del servidor.
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
            $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
            var_dump($_SESSION["ErrorDepuracion"]);
        };
    }else{
        //modificamos los datos del carrito del usuario
        modificarCarrito($errores);
    }
    return $respuesta;
}
/**
 * Esta función buscará si hay comentarios realizados en el productos.
 * @param [<String>] $id id del producto.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @param [<Object>] $session se insertarán los productos del carrito.
 * @see conectar() conexión a la base de datos.
 * @return [Boolean] con resultado de la operación
 */
function recuperarCarrito(&$errores,&$session){
    $sql = "SELECT * FROM carrito where  ID_comprador = :idCom";
    $array=[];
    $comprador=$_SESSION["datosUsuario"]["id"] ;
    $res=false;
    try {
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data = ['idCom' => $comprador];
        if ($stmt->execute($data)) {
            $res = $stmt->fetchAll();
            if ($res != null) {
                
                for ($x = 0; $x < count($res); $x++) {
                    $clase = new stdClass();
                    $clase->cantidad = $res[$x][0];
                    $clase->comprador = $res[$x][1];
                    $clase->producto = $res[$x][2];
                    
                    $array[] = $clase;
                }
                $session->carrito=$array;
                $res=true;
            } 
            else{
                $res=false;
                $errores->errorBBDD[] = "No hay productos en el carrito";
            }
        }else{
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        //Usarlo si es necesario.
           // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
            //($_SESSION["ErrorDepuracion"]);
    };

    return $res;
}
/**
 * Esta función modificará la tabla carrito de nuestra BBDD.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [Boolean] con resultado de la operación
 */
function modificarCarrito(&$errores){
   
    //Comprobar que no existe, si existe se cambia directamente en la otra
    
        $ret = false;
        $sql = "Update `carrito` set cantidad = cantidad + :cantidadNueva where ID_comprador = :comprador and ID_Producto = :producto";
        
        try {
            $pdo = conectar();
            $stmt = $pdo->prepare($sql);
          
            
            $data = [
                'cantidadNueva' =>  $_SESSION["datos"]["cantidad"],
                'comprador' =>  $_SESSION["datosUsuario"]["id"],
                'producto' =>   $_SESSION["datos"]["id"]
            ];

            if ($stmt->execute($data)) {
                $ret = $stmt->rowCount();
                
                if ($ret == 1) {
                    
                    
                    $respuesta = true;
                    //Añadimos datos que nos faltan para el usuario dentro del servidor.
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
            $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
            var_dump($_SESSION["ErrorDepuracion"]);
        };
    
    return $respuesta;
}
 /**
 * Esta función recupera de la BBDD los roles.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [<Array>]  con resultado de la operación
 */
function recuperarRoles(&$errores){
   
    $array=[];
     //Sentencia sql para conseguir los datos del usuario que deseamos usar.
     $sql = "select * from rol";
     try {
         //Conectamos la base de datos
         $pdo = conectar();
         
         //Hacemos la sentencia preparada
         $stmt = $pdo->prepare($sql);
         if ($stmt->execute()) {
             $res = $stmt->fetchAll();
             //Si es correcta insertamos datos
             if ($res != null) {
                for ($x = 0; $x < count($res); $x++) {
                    $clase = new stdClass();
                    $clase->ID = $res[$x]["ID_Rol"];
                    $clase->Rol = $res[$x]["Tipo"];
                    $array []= $clase;
                }
                 
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
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
     };
 
     return $array;
     /*Por si se borrara el localstorage manualmente y entraras de nuevo realmente la sesión la tienes ya abierta comprobaremoso
         que coinciden con los de la sesión iniciada*/
}
/**
 * Esta función recupera de la BBDD todos los usuarios.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [<Array>]  con resultado de la operación.
 */
function recuperarUsuariosGlobal(&$errores){
   
    $array=[];
     $usuario= $_SESSION["datosUsuario"]["usuario"];
     //Sentencia sql para conseguir los datos del usuario que deseamos usar.
     $sql = "select * from usuario";
     try {
         //Conectamos la base de datos
         $pdo = conectar();
         
         //Hacemos la sentencia preparada
         $stmt = $pdo->prepare($sql);
         if ($stmt->execute()) {
             $res = $stmt->fetchAll();
             //Si es correcta insertamos datos
             if ($res != null) {
                for ($x = 0; $x < count($res); $x++) {
                    $clase = new stdClass();
                    $clase->nombre = $res[$x]["Nombre"];
                    $clase->apellido = $res[$x]["Apellido"];
                    $clase->nickname = $res[$x]["nickname"];
                    $clase->email = $res[$x]["email"];
                    $clase->direccion = $res[$x]["dirección"];
                    $clase->ciudad = $res[$x]["ciudad"];
                    $clase->provincia = $res[$x]["provincia"];
                    $clase->cpostal = $res[$x]["Codigo_Postal"];
                    $clase->dni = $res[$x]["DNI"];
                    $clase->rol = $res[$x]["Id_Rol"];
                    $clase->usuario = $res[$x]["ID_Usuario"];
                    $array []= $clase;
                }
                 
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
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
     };
 
     return $array;
     /*Por si se borrara el localstorage manualmente y entraras de nuevo realmente la sesión la tienes ya abierta comprobaremoso
         que coinciden con los de la sesión iniciada*/
}
/**
 * Esta función recupera de la BBDD los comentarios.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [<Array>]  con resultado de la operación
 */
function recuperarComentariosGlobal(&$errores){
    $sql = "SELECT * FROM comentario";
    $array = [];
    try {
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute()) {
            $res = $stmt->fetchAll();
            if ($res != null) {
                
                for ($x = 0; $x < count($res); $x++) {
                    $clase = new stdClass();
                    $clase->mensaje = $res[$x][0];
                    $clase->valoracion = $res[$x][1];
                    $clase->nombreComprador = $res[$x][3];
                    $clase->fecha = $res[$x][2];
                    $clase->ID_Producto = $res[$x][4];
                    $array []= $clase;
                }
            } else {
                $errores->errorBBDD[] = "No hay comentarios";
            }
        }
        else{}
        
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        //echo $ex->getMessage();
    };

    return $array;
}
/**
 * Esta función recupera de la BBDD los comentarios de un usuario en concreto.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [<Array>]  con resultado de la operación
 */
function recuperarComentariosUsuario(&$errores)
{

    $sql = "SELECT C.Mensaje, C.valoracion , C.fecha, P.Nombre_Producto, P.imagen, C.ID_Producto FROM comentario C,producto P where C.ID_Producto=P.ID_Producto and C.ID_comprador = :id";
    $array = [];
    try {
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data = ['id' => $_SESSION["datosUsuario"]["id"]];
        if ($stmt->execute($data)) {
            $res = $stmt->fetchAll();
            if ($res != null) {
                for ($x = 0; $x < count($res); $x++) {
                    $clase = new stdClass();
                    $clase->mensaje = $res[$x][0];
                    $clase->valoracion = $res[$x][1];
                    $clase->fecha = $res[$x][2];
                    $clase->nombreProducto = $res[$x][3];
                    $clase->imagen = base64_encode($res[$x][4]);
                    $clase->IDProducto = $res[$x][5];
                    $array []= $clase;
                }
            } else {
                $errores->errorBBDD[] = "No hay comentarios";
            }
        }
        else{
            $errores->errorBBDD[] = "Hubo algún problema, intenteló más tarde";
        }
        
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        echo $ex->getMessage();
    };

    return $array;
}
/**
 * Esta función buscará si hay comentarios realizados en el productos.
 * @param [<String>] $id id del producto.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [Array]  con todos los comentarios si los hubiera.
 */
function recuperarComentarios($id,&$errores)
{

    $sql = "SELECT C.mensaje,c.valoracion,c.fecha, U.nickname,c.ID_Producto FROM comentario C  ,usuario U where ID_Producto = :id and C.ID_comprador=U.ID_Usuario" ;
    $array = [];
    try {
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data = ['id' => $id];
        if ($stmt->execute($data)) {
            $res = $stmt->fetchAll();
            if ($res != null) {
                
                for ($x = 0; $x < count($res); $x++) {
                    $clase = new stdClass();
                    $clase->mensaje = $res[$x][0];
                    $clase->valoracion = $res[$x][1];
                    $clase->fecha = $res[$x][2];
                    $clase->nombre_comprador = $res[$x][3];
                    $clase->ID_Producto = $res[$x][4];
                    $array []= $clase;
                }
            } else {
                $errores->errorBBDD[] = "No hay comentarios";
            }
        }
        
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        echo "Error en la base de datos";
    };

    return $array;
}
/**
 * Esta función buscará todos los productos dentro de nuestra base de datos.
 * 
 * 
 * Esta función buscará si hay algún comprador con el id que llega por parametro.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [Boolean] que devuelve si se ha podido o no realizar la acción
 */
function recuperarProductos(&$errores)
{
    $array = [];
    $sql = "select * from producto";
    $ret = false;

    try {

        $pdo = conectar();
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            $ret = $stmt->fetchAll();

            if ($ret != false) {
                /**Hacer for númerico con $ret */
                
                for ($x = 0; $x < count($ret); $x++) {
                    $clase = new stdClass();
                    $clase->id = $ret[$x][0];
                    $clase->nombre_producto = $ret[$x][1];
                    $clase->descripcion = $ret[$x][2];
                    $clase->stock = $ret[$x][3];
                    $clase->precio = $ret[$x][4];
                    /**Leemos la imagen para que pueda verse correctamente en la aplicación web*/
                    $clase->imagen = base64_encode($ret[$x][5]);
                    $clase->valoracion_total = $ret[$x][6];
                    $clase->comentarios_totales = $ret[$x][7];
                    $clase->descuento = $ret[$x][8];
                    //He decidido no introducir el id del vendedor por privacidad.
                    /* $clase->Id_Vendedor = $ret[$x][8];*/

                    $array[] = $clase;
                }
            }
            else{
                $errores->errorBBDD[] = "No hay productos";
            }
        }
        else{
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        $_SESSION["error"]["BBDD"] = "BBDD";
        $_SESSION["errorDesc"]["BBDD"] = $ex->getMessage();
        $_SESSION["depuración"]["BBDD"] = [$ex->getMessage(), $ex->getFile(), $ex->getTraceAsString()];
    }

    return $array;
}
/**
 * Esta función buscará todos los productos dentro de nuestra base de datos.
 * 
 * 
 * Esta función buscará si hay algún comprador con el id que llega por parametro.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [Boolean] que devuelve si se ha podido o no realizar la acción
 */
function recuperarProductosAgricultores(&$errores)
{
    $array = [];
    $sql = "select * from producto";
    $ret = false;

    try {

        $pdo = conectar();
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            $ret = $stmt->fetchAll();

            if ($ret != false) {
                /**Hacer for númerico con $ret */
                
                for ($x = 0; $x < count($ret); $x++) {
                    $clase = new stdClass();
                    $clase->id = $ret[$x][0];
                    $clase->nombre_producto = $ret[$x][1];
                    $clase->descripcion = $ret[$x][2];
                    $clase->stock = $ret[$x][3];
                    $clase->precio = $ret[$x][4];
                    /**Leemos la imagen para que pueda verse correctamente en la aplicación web*/
                    $clase->imagen = base64_encode($ret[$x][5]);
                    $clase->valoracion_total = $ret[$x][6];
                    $clase->comentarios_totales = $ret[$x][7];
                    $clase->descuento = $ret[$x][8];
                    //He decidido no introducir el id del vendedor por privacidad.
                     $clase->Id_Vendedor = $ret[$x][9];

                    $array[] = $clase;
                }
            }
            else{
                $errores->errorBBDD[] = "No hay productos";
            }
        }
        else{
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        $_SESSION["error"]["BBDD"] = "BBDD";
        $_SESSION["errorDesc"]["BBDD"] = $ex->getMessage();
        $_SESSION["depuración"]["BBDD"] = [$ex->getMessage(), $ex->getFile(), $ex->getTraceAsString()];
    }

    return $array;
}
/**
 * Esta función recupera de la BBDD los productos de un agricultor en concreto.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [<Array>]  con resultado de la operación
 */
function productosAgricultor(&$errores)
{
    $array = [];
    $sql = "select * from producto where ID_vendedor= :id";
    $ret = false;

    try {

        $pdo = conectar();
        $stmt = $pdo->prepare($sql);
        $data=["id" => $_SESSION["datosUsuario"]["id"]];
        if ($stmt->execute($data)) {
            $ret = $stmt->fetchAll();

            if ($ret != false) {
                /**Hacer for númerico con $ret */
                
                for ($x = 0; $x < count($ret); $x++) {
                    $clase = new stdClass();
                    $clase->id = $ret[$x][0];
                    $clase->nombre_producto = $ret[$x][1];
                    $clase->descripcion = $ret[$x][2];
                    $clase->stock = $ret[$x][3];
                    $clase->precio = $ret[$x][4];
                    /**Leemos la imagen para que pueda verse correctamente en la aplicación web*/
                    $clase->imagen = base64_encode($ret[$x][5]);
                    $clase->valoracion_total = $ret[$x][6];
                    $clase->comentarios_totales = $ret[$x][7];
                    $clase->descuento = $ret[$x][8];
                    //He decidido no introducir el id del vendedor por privacidad.

                    $array[] = $clase;
                }
            }
            else{
                $errores->errorBBDD[] = "No hay productos";
            }
        }
        else{
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        $_SESSION["error"]["BBDD"] = "BBDD";
        $_SESSION["errorDesc"]["BBDD"] = $ex->getMessage();
        $_SESSION["depuración"]["BBDD"] = [$ex->getMessage(), $ex->getFile(), $ex->getTraceAsString()];
    }

    return $array;
}
/**
 * Esta función recupera los pedidos realizados por un usuario en concreto.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [<Array>]  con resultado de la operación
 */
function recuperarPedidosUsuario(&$errores){
    $array = [];
    $sql = "SELECT * from pedido Where ID_comprador= :id";
     $ret = false;

    try {

        $pdo = conectar();
        $stmt = $pdo->prepare($sql);
        $data=["id" => $_SESSION["datosUsuario"]["id"]];
        if ($stmt->execute($data)) {
            $ret = $stmt->fetchAll();

            if ($ret != false) {
                /**Hacer for númerico con $ret */
                
                for ($x = 0; $x < count($ret); $x++) {
                    $clase = new stdClass();
                    $clase->idPedido = $ret[$x][0];
                    $clase->estado = $ret[$x][1];
                    $clase->fechaRealizado = $ret[$x][2];
                    $clase->total = $ret[$x][3];
                    //Teniendo el id permiso puedo conseguir los roles
                    $array[] = $clase;
                }
            }
            else{
                $errores->errorBBDD[] = "No hay Permisos";
            }
        }
        else{
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        $_SESSION["error"]["BBDD"] = "BBDD";
        $_SESSION["errorDesc"]["BBDD"] = $ex->getMessage();
        $_SESSION["depuración"]["BBDD"] = [$ex->getMessage(), $ex->getFile(), $ex->getTraceAsString()];
    }

    return $array;
}
/**
 * Esta función recupera de la BBDD los productos que ha comprado un usuario.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [<Array>]  con resultado de la operación
 */
function historial(&$errores)
{
    $array = [];
    $sql = "SELECT H.cantidad ,Pro.Nombre_Producto, H.ID_Pedido, Pro.precio , TRUNCATE(Pro.precio*H.cantidad,2) as Total,H.fecha_Envio , H.fecha_entregado   
    FROM historial H , Producto Pro, Pedido P where P.ID_Pedido= H.ID_Pedido and Pro.ID_Producto= H.ID_Producto and P.ID_comprador= :id";
    $ret = false;

    try {

        $pdo = conectar();
        $stmt = $pdo->prepare($sql);
        $data=["id" => $_SESSION["datosUsuario"]["id"]];
        if ($stmt->execute($data)) {
            $ret = $stmt->fetchAll();

            if ($ret != false) {
                /**Hacer for númerico con $ret */
                
                for ($x = 0; $x < count($ret); $x++) {
                    $clase = new stdClass();
                    $clase->cantidad = $ret[$x][0];
                    $clase->nombre = $ret[$x][1];
                    $clase->pedido = $ret[$x][2];
                    $clase->precio = $ret[$x][3];
                    $clase->total = $ret[$x][4];
                    $clase->fechaEnvio = $ret[$x][5];
                    $clase->fechaLlegada = $ret[$x][6];
                    $array[] = $clase;
                }
            }
            else{
                $errores->errorBBDD[] = "No hay compras en el historial";
            }
        }
        else{
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        echo $ex->getMessage();
    }

    return $array;
}
/**
 * Esta función recupera de la BBDD productos que han sido comprados al agricultor y debe de enviar.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [<Array>]  con resultado de la operación
 */
function enviosAgricultor(&$errores) {
    $array = [];
    $sql = "SELECT Pro.Nombre_Producto,H.cantidad,H.estado,H.fecha_Envio,H.fecha_Entregado,CONCAT(U.Nombre , ' ',U.Apellido) 
    AS Nombre ,CONCAT( U.dirección, ', ', U.ciudad, ' (', U.provincia,') ,', U.Codigo_Postal)As direccion,H.ID_Pedido, H.ID_Producto
    from historial H, Producto Pro, Pedido P, Usuario U where H.ID_Producto=Pro.ID_Producto and H.ID_Pedido=P.ID_Pedido and  
    P.ID_Comprador= U.ID_Usuario and Pro.ID_vendedor= :id";
     $ret = false;

    try {

        $pdo = conectar();
        $stmt = $pdo->prepare($sql);
        $data=["id" => $_SESSION["datosUsuario"]["id"]];
        if ($stmt->execute($data)) {
            $ret = $stmt->fetchAll();

            if ($ret != false) {
                /**Hacer for númerico con $ret */
                
                for ($x = 0; $x < count($ret); $x++) {
                    $clase = new stdClass();
                    $clase->nombreProducto = $ret[$x][0];
                    $clase->cantidad = $ret[$x][1];
                    $clase->estado = $ret[$x][2];
                    $clase->fechaEnvio = $ret[$x][3];
                    $clase->fechaLlegada = $ret[$x][4];
                    $clase->nombreComprador = $ret[$x][5];
                    $clase->direccionComprador= $ret[$x][6];
                    $clase->IDPedido = $ret[$x][7];
                    $clase->IDProducto = $ret[$x][8];
                    $array[] = $clase;
                }
            }
            else{
                $errores->errorBBDD[] = "No hay Permisos";
            }
        }
        else{
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        $_SESSION["error"]["BBDD"] = "BBDD";
        $_SESSION["errorDesc"]["BBDD"] = $ex->getMessage();
        $_SESSION["depuración"]["BBDD"] = [$ex->getMessage(), $ex->getFile(), $ex->getTraceAsString()];
    }

    return $array;
}
/**
 * Esta función recupera de la BBDD productos que han sido comprados a todos los  agricultores y deben de enviar.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [<Array>]  con resultado de la operación
 */
function enviosGlobal(&$errores) {
    $array = [];
    $sql = "SELECT Pro.Nombre_Producto,H.cantidad,H.estado,H.fecha_Envio,H.fecha_Entregado,CONCAT(U.Nombre , ' ',U.Apellido) 
    AS Nombre ,CONCAT( U.dirección, ', ', U.ciudad, ' (', U.provincia,') ,', U.Codigo_Postal)As direccion,H.ID_Pedido, H.ID_Producto
    from historial H, Producto Pro, Pedido P, Usuario U where H.ID_Producto=Pro.ID_Producto and H.ID_Pedido=P.ID_Pedido and  
    P.ID_Comprador= U.ID_Usuario";
     $ret = false;

    try {

        $pdo = conectar();
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            $ret = $stmt->fetchAll();

            if ($ret != false) {
                /**Hacer for númerico con $ret */
                
                for ($x = 0; $x < count($ret); $x++) {
                    $clase = new stdClass();
                    $clase->nombreProducto = $ret[$x][0];
                    $clase->cantidad = $ret[$x][1];
                    $clase->estado = $ret[$x][2];
                    $clase->fechaEnvio = $ret[$x][3];
                    $clase->fechaLlegada = $ret[$x][4];
                    $clase->nombreComprador = $ret[$x][5];
                    $clase->direccionComprador= $ret[$x][6];
                    $clase->IDPedido = $ret[$x][7];
                    $clase->IDProducto = $ret[$x][8];
                    $array[] = $clase;
                }
            }
            else{
                $errores->errorBBDD[] = "No hay Permisos";
            }
        }
        else{
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        $_SESSION["error"]["BBDD"] = "BBDD";
        $_SESSION["errorDesc"]["BBDD"] = $ex->getMessage();
        $_SESSION["depuración"]["BBDD"] = [$ex->getMessage(), $ex->getFile(), $ex->getTraceAsString()];
    }

    return $array;
}
/**
 * Esta función recupera el ID rol del usuario mediante el nickname del usuario y lo mete dentro de
 * la session para poder usarlo en el futuro.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [<Array>]  con resultado de la operación
 */
function comprobarRol(&$errores){
    $sql = "SELECT ID_rol FROM .usuario where nickname= :usuario";
     $ret = false;

    try {

        $pdo = conectar();
        $stmt = $pdo->prepare($sql);
        $data = [
            'usuario' =>  $_SESSION["datosUsuario"]["usuario"]
        ];
        if ($stmt->execute($data)) {
            $ret = $stmt->fetch();

            if ($ret != false) {
                /**Hacer for númerico con $ret */
                $_SESSION["datosUsuario"]["rol"]=$ret["ID_rol"];
                
            }
            else{
                $errores->errorBBDD[] = "No hay Permisos";
            }
        }
        else{
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        $_SESSION["error"]["BBDD"] = "BBDD";
        $_SESSION["errorDesc"]["BBDD"] = $ex->getMessage();
        $_SESSION["depuración"]["BBDD"] = [$ex->getMessage(), $ex->getFile(), $ex->getTraceAsString()];
    }

  
}
/**
 * Esta función recupera de la BBDD todos los pedidos realizados.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [<Array>]  con resultado de la operación
 */
function recuperarPedidos(&$errores)
{
    $array = [];
    $sql = "SELECT * from pedido";
     $ret = false;

    try {

        $pdo = conectar();
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            $ret = $stmt->fetchAll();

            if ($ret != false) {
                /**Hacer for númerico con $ret */
                
                for ($x = 0; $x < count($ret); $x++) {
                    $clase = new stdClass();
                    $clase->idPedido = $ret[$x][0];
                    $clase->estado = $ret[$x][1];
                    $clase->fechaRealizado = $ret[$x][2];
                    $clase->total= $ret[$x][3];
                    $clase->IDComprador = $ret[$x][4];
                    //Teniendo el id permiso puedo conseguir los roles
                    $array[] = $clase;
                }
            }
            else{
                $errores->errorBBDD[] = "No hay Permisos";
            }
        }
        else{
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        $_SESSION["error"]["BBDD"] = "BBDD";
        $_SESSION["errorDesc"]["BBDD"] = $ex->getMessage();
        $_SESSION["depuración"]["BBDD"] = [$ex->getMessage(), $ex->getFile(), $ex->getTraceAsString()];
    }

    return $array;
}
/**
 * Esta función recupera de la BBDD todos los permisos  y que rol puede realizarlos.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [<Array>]  con resultado de la operación
 */
function recuperarPermisos(&$errores)
{
    $array = [];
    $sql = "SELECT P.ID_Permiso,P.nombre,P.descripcion,P.codigo,P.accion , R.tipo, R.ID_Rol FROM rol R,obtencion O,permiso P where O.ID_Rol=R.ID_Rol and P.ID_Permiso=O.ID_Permiso ORDER BY P.ID_Permiso";
    $ret = false;

    try {

        $pdo = conectar();
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            $ret = $stmt->fetchAll();

            if ($ret != false) {
                /**Hacer for númerico con $ret */
                
                for ($x = 0; $x < count($ret); $x++) {
                    $clase = new stdClass();
                    $clase->id_permiso = $ret[$x][0];
                    $clase->nombre = $ret[$x][1];
                    $clase->descripcion = $ret[$x][2];
                    $clase->codigo = $ret[$x][3];
                    $clase->accion = $ret[$x][4];
                    $clase->roles= $ret[$x][5];
                    $clase->idRol= $ret[$x][6];
                    //Teniendo el id permiso puedo conseguir los roles
                    $array[] = $clase;
                }
            }
            else{
                $errores->errorBBDD[] = "No hay Permisos";
            }
        }
        else{
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        $_SESSION["error"]["BBDD"] = "BBDD";
        $_SESSION["errorDesc"]["BBDD"] = $ex->getMessage();
        $_SESSION["depuración"]["BBDD"] = [$ex->getMessage(), $ex->getFile(), $ex->getTraceAsString()];
    }

    return $array;
}
/**
 * Esta función confirmara si ya existe alguno de los parametros unicos en nuestra BBDD.
 * 
 *
 * Esta función buscará si hay algún comprador con el id que llega por parametro.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [Boolean] que devuelve si se ha podido o no realizar la acción
 */
function datosDuplicados(&$errores)
{
    $res = false;
    $sql = "select nickname,email,DNI from usuario where nickname=:usuario || email=:email  || DNI=:DNI;";

    try {

        $pdo = conectar();
        $stmt = $pdo->prepare($sql);
        $data = [
            'usuario' =>  $_SESSION["datos"]["usuarioNuevo"],
            'email' =>  $_SESSION["datos"]["email"],
            'DNI' =>  $_SESSION["datos"]["DNI"]
        ];

        if ($stmt->execute($data)) {

            $ret = $stmt->fetchAll();
            if ($ret != null) {

                foreach ($ret as $valor) {
                    if (in_array($_SESSION["datos"]["usuarioNuevo"], $valor)) {
                        $errores->errorBBDD[] = "Ya existe usuario con ese nombre";
                    }
                    if (in_array($_SESSION["datos"]["email"], $valor)) {

                        $errores->errorBBDD[] = "Ya existe usuario con ese email";
                    }
                    if (in_array($_SESSION["datos"]["DNI"], $valor)) {
                        $errores->errorBBDD[] = "Ya existe usuario con ese DNI";
                    }
                }
            } else {
                
                $res = true;
            }
        } else {
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }

    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        $ret = false;
        
        echo $ex->getMessage();
        //Usarlo si es necesario.
        //$_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];

    };

    return $res;
}
/**
 * Esta función registrará un nuevo usuario a la BBDD
 * 
 * 
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see datosDuplicados comprobará si ya existe este usuario antes de poder registrarlo.
 * @see conectar() conexión a la base de datos.
 * @return [Boolean] que devuelve si se ha podido o no realizar la acción
 */
function registro(&$errores,&$session)
{
    //crear un select y evitar hacer insert si hay duplicaciones
    //donde no debe haberlas.
    $NoDuplicado = datosDuplicados($errores);
    $respuesta = false;
    if ($NoDuplicado) {
        $ret = false;
        
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
                    //Añadimos datos que nos faltan para el usuario dentro del servidor.
                    $_SESSION["datosUsuario"]["id"]= $pdo->lastInsertId();
                    $_SESSION["datosUsuario"]["usuario"]= $_SESSION["datos"]["usuarioNuevo"];
                    $_SESSION["datosUsuario"]["rol"]= $_SESSION["datos"]["rol"];
                    $_SESSION["datosUsuario"]["pass"]= $_SESSION["datos"]["pass"];
                     //conseguir acciones que puede realizar
                     $session->acciones=accionesARealizar($errores,$_SESSION["datosUsuario"]["rol"]);
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
/**
 * Esta función recupera de la BBDD todas las acciones que puede realizar.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [<Array>]  con resultado de la operación
 */
function accionesARealizar(&$errores,$rol){
    $ret = false;
    $arrayAcciones=[];    
        $sql = "SELECT P.nombre FROM permiso P ,rol R, obtencion O where P.ID_Permiso=O.ID_Permiso and O.ID_Rol= :rol group by P.nombre
        order by P.nombre;";

        try {
            $pdo = conectar();
            $stmt = $pdo->prepare($sql);
            
            $data = [
                'rol' =>  $rol
            ];

            if ($stmt->execute($data)) {
                $ret = $stmt->fetchAll();
                if ($ret !=false) {
                    foreach ($ret as $key => $value) {
                        array_push($arrayAcciones,$value[0]);
                    }
                    
                } else {


                    $errores->errorBBDD[] = "Error al leer permisos correctamente";
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
        };
    
    return $arrayAcciones;

}
/**
 * Esta función confirmara que el usuario y la contraseña proporcionadas existen en la BBDD y coinciden entre ellas.
 * Además añadirá a la sesion datosUsuario para controlar al usuario durante la sesion.
 * 
 * Esta función buscará si hay algún comprador con el id que llega por parametro.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [Boolean] que devuelve si se ha podido o no realizar la acción
 */
 
function usuario(&$errores,&$session)
{   
    
    $ret = false;
    //Por comodidad y ya que no son muchas variables usaremos una para usuario y otra para la contraseña
    $usuario= $_SESSION["datos"]["usuario"];
    $pass=$_SESSION["datos"]["pass"];
    //Sentencia sql para conseguir los datos del usuario que deseamos usar.
    $sql = "select * from usuario where nickname = :usuario and pass = :password ";
    try {
        //Conectamos la base de datos
        $ret = false;
        $pdo = conectar();
        
        //Hacemos la sentencia preparada
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":usuario",$usuario,PDO::PARAM_STR);
        $stmt->bindParam(":password",$pass,PDO::PARAM_STR);
        if ($stmt->execute()) {
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            //Si es correcta insertamos datos
            if ($res != 0) {
                $ret = true;
                
                //Insertamos o cambios los datos de la sesión si todo es correcto
                    $_SESSION["datosUsuario"]["id"] = $res["ID_Usuario"];
                    $_SESSION["datosUsuario"]["usuario"]= $res["nickname"];
                    $_SESSION["datosUsuario"]["rol"]= $res["Id_Rol"];
                    $_SESSION["datosUsuario"]["pass"]= $_SESSION["datos"]["pass"];
                    $session->acciones=accionesARealizar($errores,$_SESSION["datosUsuario"]["rol"]);
                
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
        // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
        //($_SESSION["ErrorDepuracion"]);
    };

    return $ret;
    /*Por si se borrara el localstorage manualmente y entraras de nuevo realmente la sesión la tienes ya abierta comprobaremoso
        que coinciden con los de la sesión iniciada*/
}
/**
 * Esta función nos permitirá modificar de la BBDD cualquier comentario .
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [<Array>]  con resultado de la operación
 */
function modificarComentariosGlobal(&$errores){
    $ret = false;
    //Por comodidad y ya que no son muchas variables usaremos una para usuario y otra para la contraseña
    
    //Sentencia sql para conseguir los datos del usuario que deseamos usar.
    $sql = " UPDATE `comentario` SET `Mensaje` = :mensaje, `valoracion` = :valoracion, `fecha` = :fecha  WHERE (`ID_comprador` = :idComprador) and (`ID_Producto` = :idProducto)";
    try {
        //Conectamos la base de datos
        $ret = false;
        $pdo = conectar();
        
        //Hacemos la sentencia preparada
        $stmt = $pdo->prepare($sql);
        $data=["idComprador" => $_SESSION["datos"]["comprador"], "idProducto" => $_SESSION["datos"]["id"],  
        "mensaje"=> $_SESSION["datos"]["mensaje"], "valoracion" =>$_SESSION["datos"]["valoracion"], "fecha"=> $_SESSION["datos"]["fecha"]];
        if ($stmt->execute($data)) {
            $res = $stmt->rowCount();
            //Si es correcta insertamos datos
            if ($res != 0) {
                $ret = true;
                
            }
            else{
                $errores->errorBBDD[] = "No se pudo hacer modificaciones";
            }
            
        }else{
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }

       
    }

    //Else por si hay algún error
    catch (PDOException $ex) {
        //echo $ex->getMessage();
        $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        /**En caso de haber excepción será atrapada por el catch*/
        // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
        //($_SESSION["ErrorDepuracion"]);
    };

    return $ret;

}
/**
 * Esta función modifica de la BBDD comentarios realizado por un usuario en concreto.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [<Array>]  con resultado de la operación
 */
function modificarComentariosPropio(&$errores){
    $ret = false;
    //Por comodidad y ya que no son muchas variables usaremos una para usuario y otra para la contraseña
    
    //Sentencia sql para conseguir los datos del usuario que deseamos usar.
    $sql = " UPDATE `comentario` SET `Mensaje` = :mensaje, `valoracion` = :valoracion, `fecha` = CURRENT_DATE  WHERE (`ID_comprador` = :idComprador) and (`ID_Producto` = :id)";
    try {
        //Conectamos la base de datos
        $ret = false;
        $pdo = conectar();
        
        //Hacemos la sentencia preparada
        $stmt = $pdo->prepare($sql);
        $data=["idComprador" =>  $_SESSION["datosUsuario"]["id"],  
        "mensaje"=> $_SESSION["datos"]["mensaje"], "valoracion" =>$_SESSION["datos"]["valoracion"], "id" =>$_SESSION["datos"]["id"]];
        if ($stmt->execute($data)) {
            $res = $stmt->rowCount();
            //Si es correcta insertamos datos
            if ($res != 0) {
                $ret = true;
                
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
        // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
        //($_SESSION["ErrorDepuracion"]);
        var_dump($ex->getMessage());
    };

    return $ret;

}
/**
 * Esta función comprueba que una accion en concreto exista y pueda realizarse.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [<Array>]  con resultado de la operación
 */
function existeAccion(&$errores)
{   
    $ret = false;
    //Por comodidad y ya que no son muchas variables usaremos una para usuario y otra para la contraseña
    $opcion= $_SESSION["datos"]["opcion"];
    $accion=$_SESSION["datos"]["accion"];
    $rol=$_SESSION["datosUsuario"]["rol"];
    //Sentencia sql para conseguir los datos del usuario que deseamos usar.
    $sql = "SELECT count(*) FROM permiso P ,rol R, obtencion O where P.ID_Permiso=O.ID_Permiso and O.ID_Rol=R.ID_Rol AND O.ID_Rol= :rol
    and P.nombre= :opcion and P.accion= :accion";
    try {
        $pdo = conectar();
        
        //Hacemos la sentencia preparada
        $stmt = $pdo->prepare($sql);
        $data = [
            'opcion' =>  $opcion,
            'accion' =>  $accion,
            'rol' => $rol
        ];
        if ($stmt->execute($data)) {
            $res = $stmt->fetch();
            //Si es correcta insertamos datos
            
            if ($res[0] != 0) {
                $ret=true;
            }
            else{
               
                $errores->errorBBDD[] = "No existe el permiso";
            }
            
        }else{
            
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }

       
    }

    //Else por si hay algún error
    catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
        //($_SESSION["ErrorDepuracion"]);
    };

    return $ret;
    /*Por si se borrara el localstorage manualmente y entraras de nuevo realmente la sesión la tienes ya abierta comprobaremoso
        que coinciden con los de la sesión iniciada*/
}
/**
 * Esta función obtendrá todos los datos del usuario
 * 
 * Esta función buscará si hay algún comprador con el id que llega por parametro.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [Boolean] que devuelve si se ha podido o no realizar la acción
 */
 
 function recuperarUsuario(&$errores,&$session)
 {   
     
     $ret = false;
     $usuario= $_SESSION["datosUsuario"]["usuario"];
     //Sentencia sql para conseguir los datos del usuario que deseamos usar.
     $sql = "select * from usuario where nickname = :usuario";
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
                 $ret = true;
                 $clase = new stdClass();
                    $clase->nombre = $res["Nombre"];
                    $clase->apellido = $res["Apellido"];
                    $clase->nickname = $res["nickname"];
                    $clase->email = $res["email"];
                    $clase->direccion = $res["dirección"];
                    $clase->ciudad = $res["ciudad"];
                    $clase->provincia = $res["provincia"];
                    $clase->cpostal = $res["Codigo_Postal"];
                    $clase->dni = $res["DNI"];
                    $session= $clase;
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
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
     };
 
     return $ret;
     /*Por si se borrara el localstorage manualmente y entraras de nuevo realmente la sesión la tienes ya abierta comprobaremoso
         que coinciden con los de la sesión iniciada*/
 }
/**
 * Esta función cambia la contraseña del usuario
 * @param [<Object>] $errores se insertarán los posible errores.
 * @param [<Object>] $session se insertarán los posible session.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
 function cambiarPass(&$errores,&$session)
 {   
     
     $ret = false;
     $pass= $_SESSION["datos"]["pass"];
     $usuario= $_SESSION["datosUsuario"]["usuario"];
     //Sentencia sql para conseguir los datos del usuario que deseamos usar.
     $sql = "UPDATE  usuario set `pass` = :pass  where `nickname` = :usuario";
     try {
         //Conectamos la base de datos
         $ret = false;
         $pdo = conectar();
         
         //Hacemos la sentencia preparada
         $stmt = $pdo->prepare($sql);
         $data=["pass"=> $pass, "usuario" => $usuario];
         if ($stmt->execute($data)) {
             $res = $stmt->rowCount();
             //Si es correcta insertamos datos
             if ($res != 0) {
                 $ret = true;
                 $_SESSION["datosUsuario"]["pass"]=$pass;
                 $session->exito="Conseguido";
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
         // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
         //($_SESSION["ErrorDepuracion"]);
     };
 
     return $ret;
     /*Por si se borrara el localstorage manualmente y entraras de nuevo realmente la sesión la tienes ya abierta comprobaremoso
         que coinciden con los de la sesión iniciada*/
 }
/**
 * Esta función recupera de la BBDD todas las noticias.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @param [<Object>] $session se insertarán los posible session.
 * @see conectar() conexión a la base de datos.
 * @return [<Array>]  con resultado de la operación
 */
 function noticia(&$errores){
    $sql = "SELECT * FROM noticia";
    $array = [];
    try {
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            $res = $stmt->fetchAll();
            
            if ($res != null) {
                for ($x = 0; $x < count($res); $x++) {
                    $clase = new stdClass();
                    $clase->IDNoticia = $res[$x][0];
                    $clase->titulo = $res[$x][1];
                    $clase->subtitulo = $res[$x][2];
                    $clase->imagen = base64_encode($res[$x][3]);
                    $clase->fecha = $res[$x][4];
                    $clase->cuerpo = $res[$x][5];
                    $array []= $clase;
                }
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
         $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
    };

    return $array;
}





   