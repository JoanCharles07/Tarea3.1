<?php 

function controladorLista($datos,&$errores,&$session){
    
    $respuesta=existeAccion($errores);
    if($respuesta){
        
        if($datos->opcion=="Comentarios"){
            $session->comentariosPropio=recuperarComentariosUsuario($errores);
            
        }
        else if($datos->opcion=="Lista comentarios" && $_SESSION["datosUsuario"]["rol"]==3){
            $session->comentariosGlobal=recuperarComentariosGlobal($errores);
        }
        else if($datos->opcion=="Lista usuarios" && $_SESSION["datosUsuario"]["rol"]==3){
            $session->usuarios=recuperarUsuariosGlobal($errores);
        }
        else if($datos->opcion=="Lista roles" && $_SESSION["datosUsuario"]["rol"]==3){
            $session->roles=recuperarRoles($errores);
        }
        else if($datos->opcion=="Lista productos" && $_SESSION["datosUsuario"]["rol"]==3){
            $session->productosGlobal=recuperarProductosAgricultores($errores);
        }
        else if($datos->opcion=="Lista permisos" && $_SESSION["datosUsuario"]["rol"]==3){
            $session->permisos=recuperarPermisos($errores);
        }
        else if($datos->opcion=="Lista pedidos" && $_SESSION["datosUsuario"]["rol"]==3){
            $session->listaPedidos=recuperarPedidos($errores);
        }
        else if($datos->opcion=="Lista Noticias" && $_SESSION["datosUsuario"]["rol"]==3){
            $session->noticias=noticia($errores);
        }
        else if($datos->opcion=="Productos" && ($_SESSION["datosUsuario"]["rol"]==3 || $_SESSION["datosUsuario"]["rol"]==2)){
            $session->productosPropio=productosAgricultor($errores);
        }
        else if($datos->opcion=="Envios" && ($_SESSION["datosUsuario"]["rol"]==3 || $_SESSION["datosUsuario"]["rol"]==2)){
            $session->envios=enviosAgricultor($errores);
        }
        else if($datos->opcion=="Historial"){
            $session->historial=historial($errores);
        }
        else if($datos->opcion=="Pedidos"){
            $session->listaPedidosUsuario=recuperarPedidosUsuario($errores);
        }
    }
    else{
        unset($_SESSION["datosUsuario"]);
        $session->errores="No existe esa acción";
    }
    //DIVIDIMOS EN IF ENTRA EN ESA OPCION Y LE DAMOS LA INFORMACIÓN QUE QUIERE.
    //Llega la accion que será CRUD y a lo que queremos pedir permiso por ejemplo accion ver, permiso Lista Productos.
    //Dentro de la base de datos primero comprobamos que id tiene el permiso buscando la palabra
}

function controladorModificaciones($datos,&$errores,&$session){
    $respuesta=existeAccion($errores);
    if($respuesta){
        
    if($datos->opcion=="Lista comentarios" && $_SESSION["datosUsuario"]["rol"]==3){
            $session->comentarios=modificarComentariosGlobal($errores);
        }
        else if($datos->opcion=="Comentarios"){
            $session->comentarios=modificarComentariosPropio($errores);
        }
        else if($datos->opcion=="Lista Noticias" && $_SESSION["datosUsuario"]["rol"]==3){
           
            $session->noticias=modificarNoticia($errores);
        }
        else if($datos->opcion=="Lista pedidos" && $_SESSION["datosUsuario"]["rol"]==3){
            if($_SESSION["datos"]["estado"]=="Tramitando"){
                $session->pedido=modificarEstadoPedidoTramitandoAdmin($errores);
            }else if($_SESSION["datos"]["estado"]=="Enviado"){
                $session->pedido=modificarEstadoPedidoEnviandoAdmin($errores);
            }else if($_SESSION["datos"]["estado"]=="Recibido"){
                $session->pedido=modificarEstadoPedidoRecibido($errores);
            }
        }
        else if($datos->opcion=="Lista permisos" && $_SESSION["datosUsuario"]["rol"]==3){
            $session->permisos=modificarPermiso($errores);
        }
        else if($datos->opcion=="Lista usuarios" && $_SESSION["datosUsuario"]["rol"]==3){
            $session->usuarios=modificarUsuariosGlobal($errores);
        }
        else if($datos->opcion=="Lista roles" && $_SESSION["datosUsuario"]["rol"]==3){
            $session->usuarios=modificarRol($errores);
        }
        else if($datos->opcion=="Lista productos" && ($_SESSION["datosUsuario"]["rol"]==3 )){
            $session->productosGlobal=modificarProductoGlobal($errores);
        }
        else if($datos->opcion=="Productos" && ($_SESSION["datosUsuario"]["rol"]==3 || $_SESSION["datosUsuario"]["rol"]==2)){
            $session->productosPropio= modificarProductosPropio($errores);
        }
        else if($datos->opcion=="Envios" && ($_SESSION["datosUsuario"]["rol"]==3 || $_SESSION["datosUsuario"]["rol"]==2)){
            if($_SESSION["datos"]["estado"]=="Tramitando"){
                $session->envios=modificarEstadoPedidoTramitando($errores);
            }else if($_SESSION["datos"]["estado"]=="Enviado"){
                $session->envios=modificarEstadoPedidoEnviando($errores);
            }else if($_SESSION["datos"]["estado"]=="Recibido"){
                $session->envios=modificarEstadoPedidoRecibido($errores);
            }
        }
        else if($datos->opcion=="Perfil"){
            $session->usuario=modificarUsuariosPropio($errores);
            
        }
    }
    else{
        $session->errores="No existe esa acción";
    }
    //DIVIDIMOS EN IF ENTRA EN ESA OPCION Y LE DAMOS LA INFORMACIÓN QUE QUIERE.
    //Llega la accion que será CRUD y a lo que queremos pedir permiso por ejemplo accion ver, permiso Lista Productos.
    //Dentro de la base de datos primero comprobamos que id tiene el permiso buscando la palabra
}
function controladorEliminacion($datos,&$errores,&$session){
    $respuesta=existeAccion($errores);
    if($respuesta){
        
        if($datos->opcion=="Lista comentarios" && $_SESSION["datosUsuario"]["rol"]==3){
            $session->comentarios=eliminarComentariosGlobal($errores);
        }
        else if($datos->opcion=="Comentarios"){
            $session->comentarios=eliminarComentariosPropio($errores);
           
        }
        else if($datos->opcion=="Lista Noticias" && $_SESSION["datosUsuario"]["rol"]==3){
           
            $session->noticias=eliminarNoticia($errores);
        }
        else if($datos->opcion=="Lista pedidos" && $_SESSION["datosUsuario"]["rol"]==3){
            $session->pedido=eliminarPedido($errores);
        }
        else if($datos->opcion=="Lista permisos" && $_SESSION["datosUsuario"]["rol"]==3){
            $session->permisos=eliminarPermiso($errores);
        }
        else if($datos->opcion=="Lista usuarios" && $_SESSION["datosUsuario"]["rol"]==3){
            $session->usuarios=eliminarUsuariosGlobal($errores);
        }
        else if($datos->opcion=="Lista roles" && $_SESSION["datosUsuario"]["rol"]==3){
            $session->usuarios=eliminarRol($errores);
        }
        else if($datos->opcion=="Lista productos" && ($_SESSION["datosUsuario"]["rol"]==3 )){
            $session->productosGlobal=eliminarProductoGlobal($errores);
        }
        else if($datos->opcion=="Productos" && ($_SESSION["datosUsuario"]["rol"]==3 || $_SESSION["datosUsuario"]["rol"]==2)){
            
            $session->productosPropio= eliminarProductoPropio($errores);
        }
        else if($datos->opcion=="Envios" && ($_SESSION["datosUsuario"]["rol"]==3 || $_SESSION["datosUsuario"]["rol"]==2)){
            $session->productosPropio= eliminarEnvio($errores);
        }else if($datos->opcion=="Perfil"){
            eliminarUsuarioPropio($errores,$session);
        }
    }
    else{
        $session->errores="No existe esa acción";
    }
    //DIVIDIMOS EN IF ENTRA EN ESA OPCION Y LE DAMOS LA INFORMACIÓN QUE QUIERE.
    //Llega la accion que será CRUD y a lo que queremos pedir permiso por ejemplo accion ver, permiso Lista Productos.
    //Dentro de la base de datos primero comprobamos que id tiene el permiso buscando la palabra
}

?>