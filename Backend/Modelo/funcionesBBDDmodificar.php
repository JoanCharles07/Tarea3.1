<?php

/**
 * Esta función modifica el estado del envío del producto a Tramitando.
 * Tiene en cuenta que ambos campos de fecha(envio y recibido)sean null.
 * 
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
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
                
                $errores->errorBBDD[] = "No se ha podido modificar pedidos";
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
}/**
 * Esta función modifica el estado del envío del producto a Enviado y la fecha de envio.Además tiene en cuenta que recibido sea null.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
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
                
                $errores->errorBBDD[] = "No se ha podido modificar pedidos";
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
 * Esta función modifica el estado del envío del producto a Finalizado y modifica la fecha de entregado a la fecha actual.
 * Tiene en cuenta  fecha de envio no sea null.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
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
                //comprobamos si es el ultimo
                
            } else {
                
                $errores->errorBBDD[] = "No se ha podido modificar pedidos";
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
 * Esta función modifica el estado del envío del producto a Tramitando por parte del Admin.Puede cambiar el pedido a tramitando aunque este en cualquier otro estado
 * Esta función se usará en caso de que haya habido algún error al marcarlo como  enviado o finalizado.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
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
                
                $errores->errorBBDD[] = "No se ha podido modificar pedidos";
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
 * Esta función modifica el estado del envío del producto a Enviado por parte del Admin.Puede cambiar el pedido a tramitando aunque este en cualquier otro estado
 * Esta función se usará en caso de que haya habido algún error al marcarlo como  tramitado o finalizado.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
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
                
                $errores->errorBBDD[] = "No se ha podido modificar pedido";
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
 * Esta función modifica el estado del envío del producto a Finalizado por parte del Admin.Puede cambiar el pedido a tramitando aunque este en cualquier otro estado
 * Esta función se usará en caso de que haya habido algún error al marcarlo como  tramitado o finalizado.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
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
                comprobarTotalProductosFinalizado($errores);
                //Buscar si se han finalizado todos

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
function comprobarTotalProductosPedido(&$errores){
    $sql = "SELECT count(*) FROM historial where ID_Pedido=:pedido" ;
   
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["pedido"=> $_SESSION["datos"]["pedido"]];
        if ($stmt->execute($data)) {
            $res = $stmt->fetch();
            
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
    
    return $res;
}

function comprobarTotalProductosFinalizado(&$errores){
    $sql = "SELECT count(*) FROM historial where ID_Pedido=:pedido and  estado = 'Finalizado'" ;
    $res = comprobarTotalProductosPedido($errores);
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["pedido"=> $_SESSION["datos"]["pedido"]];
        if ($stmt->execute($data)) {
            $ret = $stmt->fetch();
            if($ret==$res){
                modificarEstadoPedidoEntregadoAdmin($errores);
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

    return $res;
}
/**
 * Esta función modifica el estado del pedido a Entregado.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
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
                
                $errores->errorBBDD[] = "No se ha podido modificar pedidos";
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
 * Esta función modifica el estado del pedido a Realizado.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
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
                
                $errores->errorBBDD[] = "No se ha podido modificar pedidos";
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
 * Esta función modifica la noticia.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
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
                
                $errores->errorBBDD[] = "No se ha podido modificar noticias";
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
 * Esta función devuelve la contraseña actual del usuario.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
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
                
                $errores->errorBBDD[] = "No se han podido comprobar contraseñas";
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
 * Esta función modifica datos del usuario por parte del administrador.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
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
                
                $errores->errorBBDD[] = "No se han podido modificar datos usuario";
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
 * Esta función modifica datos del usuario modificados por el propio usuario.Además modífica la sesión para que
 * ya tenga los nuevos datos actualizados de nickname si fuera necesario
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
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
                $errores->errorBBDD[] = "No se han podido modificar datos usuario";
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
 * Esta recupera todos los tipos de Rol de la BBDD
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
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
                
                $errores->errorBBDD[] = "No se han podido conseguir tipos de roles";
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
/**
 * Esta función agrega un nuevo tipo a nuesto enum de Tipos.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @param [<Array>] contiene los tipos de rol(Usuario,Agricultor,...).
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
function agregamosENUMTipos(&$errores,$existentes){
    $sql = "ALTER table rol MODIFY Tipo ENUM('".implode("','",$existentes)."',:nuevo)";
    $ret = false;
       
    try {
        
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data=["nuevo" =>  $_SESSION["datos"]["nombreRol"]];
        if ($stmt->execute($data)) {
           
           $ret=true;
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
 * Esta función modificar unrol ya existente.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @param [<Array>] contiene los tipos de rol(Usuario,Agricultor,...).
 * @see conectar() conexión a la base de datos.
 * @see todosTiposRol() tipos de rol que ya existen en nuestra BBDD.
 * @see agregamosENUMTipos() Agrega el Tipo de enum a tipos para poder modificar el actual.
 * @return [BOOLEAN]  con resultado de la operación
 */
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
/**
 * Esta función comprueba si ese permiso lo puede realizar ese tipo de rol
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
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
                
                $errores->errorBBDD[] = "No existe el permiso para ese rol";
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
 * Esta función modifica el rol que puede realizar un determinado permiso.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
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
                
                $errores->errorBBDD[] = "No se han podido modificar rol del permiso";
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
 * Esta función modifica un permiso en concreto.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @see existeObtencion() comproba os primero que no exista ese nuevo permiso.
 * @see recuperarIDRol() comprueba que el rol sea nuevo y si lo cambia en modificarRolPermiso.
 * @see modificarRolPermiso() Modifica el rol que puede realizar  un permiso.
 * @return [BOOLEAN]  con resultado de la operación
 */
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
                
                $errores->errorBBDD[] = "No se han podido modificar permiso";
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
 * Esta función recupera el ID del rol mediante el tipo .
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
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
                 
                 $errores->errorBBDD[] = "No se han podido conseguir rol";
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
 * Esta función modifica un producto por parte del administrador
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
 function modificarProductoGlobal(&$errores){
    $ret = false;
    if($_SESSION["datos"]["imagen"]=="valido"){
        $sql ="UPDATE `producto` SET `Nombre_Producto` = :nombre, `descripcion`= :descripcion, `stock` = :stock, `descuento` = :descuento ,`precio` = :precio WHERE (`ID_Producto` = :id)";
        $data=["nombre" =>  $_SESSION["datos"]["nombre"],"descripcion" =>  $_SESSION["datos"]["descripcion"],"stock" =>  $_SESSION["datos"]["stock"],
         "descuento" =>  $_SESSION["datos"]["descuento"],"precio" =>  $_SESSION["datos"]["precio"],"id" => $_SESSION["datos"]["id"]];
    }else{
        $sql ="UPDATE `producto` SET `Nombre_Producto` = :nombre, `descripcion`= :descripcion,`imagen`= :imagen, `stock` = :stock, `descuento` = :descuento ,`precio` = :precio WHERE (`ID_Producto` = :id)";
        
        $data=["nombre" =>  $_SESSION["datos"]["nombre"],"descripcion" =>  $_SESSION["datos"]["descripcion"],"stock" =>  $_SESSION["datos"]["stock"],
        "descuento" =>  $_SESSION["datos"]["descuento"],"precio" =>  $_SESSION["datos"]["precio"],"imagen" => $_SESSION["datos"]["imagen"],"id" => $_SESSION["datos"]["id"]];
    }
     
     
     try {
         
         $pdo=conectar();
         $stmt = $pdo->prepare($sql);
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
/**
 * Esta función modifica un producto por parte del agricultor
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
function modificarProductosPropio(&$errores){
    $ret = false;
    try {
        
     if($_SESSION["datos"]["imagen"]=="valido"){
        
     $sql ="UPDATE `producto` SET `Nombre_Producto` = :nombre, `descripcion`= :descripcion, `stock` = :stock, `descuento` = :descuento ,`precio` = :precio WHERE (`ID_Producto` = :producto) and `ID_vendedor` = :vendedor";
     $data=["nombre" =>  $_SESSION["datos"]["nombre"],"descripcion" =>  $_SESSION["datos"]["descripcion"],"stock" =>  $_SESSION["datos"]["stock"],
         "descuento" =>  $_SESSION["datos"]["descuento"],"precio" =>  $_SESSION["datos"]["precio"], "producto" => $_SESSION["datos"]["id"],"vendedor" => $_SESSION["datosUsuario"]["id"]];   
    }else{
        
     $sql ="UPDATE `producto` SET `Nombre_Producto` = :nombre, `descripcion`= :descripcion,`imagen`= :imagen, `stock` = :stock, `descuento` = :descuento ,`precio` = :precio WHERE (`ID_Producto` = :producto) and `ID_vendedor` = :vendedor";
     $data=["nombre" =>  $_SESSION["datos"]["nombre"],"descripcion" =>  $_SESSION["datos"]["descripcion"],"stock" =>  $_SESSION["datos"]["stock"],
     "descuento" =>  $_SESSION["datos"]["descuento"],"precio" =>  $_SESSION["datos"]["precio"],"imagen" => $_SESSION["datos"]["imagen"], 
     "producto" => $_SESSION["datos"]["id"],"vendedor" => $_SESSION["datosUsuario"]["id"]];  
    }
         
         $pdo=conectar();
         $stmt = $pdo->prepare($sql);
         
         if ($stmt->execute($data)) {
            
             $res=$stmt->rowCount();
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