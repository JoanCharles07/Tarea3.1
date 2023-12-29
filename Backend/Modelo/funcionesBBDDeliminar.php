<?php 
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
?>