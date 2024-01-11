<?php 
/**
 * Esta función elimina un comentario de un comprador .
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
function eliminarComentariosGlobal(&$errores){
    $ret = false;
     $sql ="DELETE FROM comentario where `ID_comprador`= :comprador AND `ID_Producto` = :producto";
     
     try {
         
         $pdo=conectar();
         $stmt = $pdo->prepare($sql);
         $data=["comprador" =>  $_SESSION["datos"]["comprador"],"producto" =>  $_SESSION["datos"]["id"]];
         
         if ($stmt->execute($data)) {
            
             $res=$stmt->rowCount();
             if ($res != 0) {
                 $ret=true;
             } else {
                 
                 $errores->errorBBDD[] =  "No se han podido borrar Comentario.";
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
 * Esta función elimina un Permiso de un comprador .
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @see recuperarIDRol() recuperamos el el ID del rol ya que lo que se recibe por datos es el nombre del tipo de rol
 * @return [BOOLEAN]  con resultado de la operación
 */
function eliminarPermiso(&$errores){
    $ret = false;
     $sql ="DELETE FROM obtencion where ID_Permiso= :permiso  and ID_Rol = :rol";
     
     try {
         
         $pdo=conectar();
         $stmt = $pdo->prepare($sql);
         $data=["permiso" =>  $_SESSION["datos"]["id"] , "rol" => recuperarIDRol($errores)];
         
         if ($stmt->execute($data)) {
            
             $res=$stmt->rowCount();
             if ($res != 0) {
                 $ret=true;
             } else {
                 
                 $errores->errorBBDD[] =  "No se han podido borrar permisos.";
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
 * Esta función elimina un comentario propio del usuario .
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
function eliminarComentariosPropio(&$errores){
    $ret = false;
     $sql ="DELETE FROM comentario where `ID_comprador`= :comprador AND `ID_Producto` = :producto";
     
     try {
         $pdo=conectar();
         $stmt = $pdo->prepare($sql);
         $data=["comprador" =>  $_SESSION["datosUsuario"]["id"],"producto" =>  $_SESSION["datos"]["id"]];
         
         if ($stmt->execute($data)) {
            
             $res=$stmt->rowCount();
             if ($res != 0) {
                 $ret=true;
             } else {
                 
                 $errores->errorBBDD[] =  "No se han podido borrar comentarios.";
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
 * Esta función elimina un Pedido de la BBDD .
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
function eliminarPedido(&$errores){
    $ret = false;
     $sql ="DELETE FROM pedido where ID_Pedido= :pedido";
     
     try {
         
         $pdo=conectar();
         $stmt = $pdo->prepare($sql);
         $data=["pedido" =>  $_SESSION["datos"]["id"]];
         
         if ($stmt->execute($data)) {
            
             $res=$stmt->rowCount();
             if ($res != 0) {
                 $ret=true;
             } else {
                 
                 $errores->errorBBDD[] =  "No se han podido borrar Pedido.";
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
 * Esta función elimina una Notcia de la BBDD .
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
function eliminarNoticia(&$errores){
    $ret = false;
     $sql ="DELETE FROM Noticia where Id_Noticia= :noticia";
     
     try {
         
         $pdo=conectar();
         $stmt = $pdo->prepare($sql);
         $data=["noticia" =>  $_SESSION["datos"]["id"]];
         
         if ($stmt->execute($data)) {
            
             $res=$stmt->rowCount();
             if ($res != 0) {
                 $ret=true;
             } else {
                 
                 $errores->errorBBDD[] =  "No se han podido borrar Noticias.";
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
 * Esta función elimina un usuario de la BBDD .
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
function eliminarUsuariosGlobal(&$errores){
    $ret = false;
     $sql ="DELETE FROM usuario where ID_Usuario= :usuario";
     
     try {
         
         $pdo=conectar();
         $stmt = $pdo->prepare($sql);
         $data=["usuario" =>  $_SESSION["datos"]["id"]];
         
         if ($stmt->execute($data)) {
            
             $res=$stmt->rowCount();
             if ($res != 0) {
                 $ret=true;
             } else {
                 
                 $errores->errorBBDD[] =  "No se ha podido borrar Usuario.";
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
 * Esta función elimina un Usuario dandose de baja asi mismo .
 * @param [<Object>] $errores se insertarán los posible errores.
 * @param [<Object>] $session inserta exito dentro del objeto si se ha podido borrar para tras ello destruir
 * la sesión.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
function eliminarUsuarioPropio(&$errores,&$session){
    $ret = false;
     $sql ="DELETE FROM usuario where ID_Usuario= :usuario";
     
     try {
         
         $pdo=conectar();
         $stmt = $pdo->prepare($sql);
         $data=["usuario" =>  $_SESSION["datosUsuario"]["id"]];
         
         if ($stmt->execute($data)) {
            
             $res=$stmt->rowCount();
             if ($res != 0) {
                 $ret=true;
                 $session->borradoUsuario="exito";
                 session_destroy();
             } else {
                 
                 $errores->errorBBDD[] =  "No se han podido borrar Usuario.";
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
 * Esta función elimina un Rol de la BBDD.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
function eliminarRol(&$errores){
    $ret = false;
     $sql ="DELETE FROM rol where ID_Rol= :rol";
     
     try {
         
         $pdo=conectar();
         $stmt = $pdo->prepare($sql);
         $data=["rol" =>  $_SESSION["datos"]["id"]];
         
         if ($stmt->execute($data)) {
            
             $res=$stmt->rowCount();
             if ($res != 0) {
                 $ret=true;
             } else {
                 
                 $errores->errorBBDD[] =  "No se han podido borrar Rol.";
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
 * Esta función elimina un Producto de la BBDD  .
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
function eliminarProductoGlobal(&$errores){
    $ret = false;
     $sql ="DELETE FROM producto where ID_Producto= :producto";
     
     try {
         
         $pdo=conectar();
         $stmt = $pdo->prepare($sql);
         $data=["producto" =>  $_SESSION["datos"]["id"]];
         
         if ($stmt->execute($data)) {
            
             $res=$stmt->rowCount();
             if ($res != 0) {
                 $ret=true;
             } else {
                 
                 $errores->errorBBDD[] =  "No se han podido borrar Producto.";
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
 * Esta función elimina un producto del agricultor .
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
function eliminarProductoPropio(&$errores){
    $ret = false;
     $sql ="DELETE FROM producto where ID_Producto= :producto  and ID_vendedor =:vendedor";
     
     try {
         
         $pdo=conectar();
         $stmt = $pdo->prepare($sql);
         $data=["producto" =>  $_SESSION["datos"]["id"] , "vendedor" => $_SESSION["datosUsuario"]["id"]];
         
         if ($stmt->execute($data)) {
            
             $res=$stmt->rowCount();
             if ($res != 0) {
                 $ret=true;
             } else {
                 
                 $errores->errorBBDD[] =  "No se han podido borrar Producto.";
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
 * Esta función elimina slguno de los productos que se envia en el pedido .
 * @param [<Object>] $errores se insertarán los posible errores.
 * @see conectar() conexión a la base de datos.
 * @return [BOOLEAN]  con resultado de la operación
 */
function eliminarEnvio(&$errores){
    $ret = false;
     $sql ="DELETE FROM Historial where ID_Pedido= :pedido  and ID_Producto =:producto";
     
     try {
         
         $pdo=conectar();
         $stmt = $pdo->prepare($sql);
         $data=["producto" =>  $_SESSION["datos"]["producto"] , "pedido" => $_SESSION["datos"]["pedido"]];
         
         if ($stmt->execute($data)) {
            
             $res=$stmt->rowCount();
             if ($res != 0) {
                 $ret=true;
             } else {
                 
                 $errores->errorBBDD[] =  "No se han podido borrar Envio.";
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