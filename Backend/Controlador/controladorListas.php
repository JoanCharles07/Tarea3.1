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
        }//Solo el administrador que es el 1 puede verlos
        else if($datos->opcion=="Mensajes" && $_SESSION["datosUsuario"]["id"]==1){
            $session->listaMensajes=leerMensajesPrivados($errores);
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
            eliminarComentariosGlobal($errores);
        }
        else if($datos->opcion=="Comentarios"){
           eliminarComentariosPropio($errores);
           
        }
        else if($datos->opcion=="Lista Noticias" && $_SESSION["datosUsuario"]["rol"]==3){
           
            eliminarNoticia($errores);
        }
        else if($datos->opcion=="Lista pedidos" && $_SESSION["datosUsuario"]["rol"]==3){
           eliminarPedido($errores);
        }
        else if($datos->opcion=="Lista permisos" && $_SESSION["datosUsuario"]["rol"]==3){
            eliminarPermiso($errores);
        }
        else if($datos->opcion=="Lista usuarios" && $_SESSION["datosUsuario"]["rol"]==3){
            eliminarUsuariosGlobal($errores);
        }
        else if($datos->opcion=="Lista roles" && $_SESSION["datosUsuario"]["rol"]==3){
            eliminarRol($errores);
        }
        else if($datos->opcion=="Lista productos" && ($_SESSION["datosUsuario"]["rol"]==3 )){
            eliminarProductoGlobal($errores);
        }
        else if($datos->opcion=="Productos" && ($_SESSION["datosUsuario"]["rol"]==3 || $_SESSION["datosUsuario"]["rol"]==2)){
            
            eliminarProductoPropio($errores);
        }
        else if($datos->opcion=="Envios" && ($_SESSION["datosUsuario"]["rol"]==3 || $_SESSION["datosUsuario"]["rol"]==2)){
           eliminarEnvio($errores);
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

function controladorAgregar($datos,&$errores,&$session){
    $respuesta=existeAccion($errores);
    
    if($respuesta){
        
        
        if($datos->opcion=="Lista noticias" && $_SESSION["datosUsuario"]["rol"]==3){
           
            agregarNoticia($errores);
        }
        else if($datos->opcion=="Lista permisos" && $_SESSION["datosUsuario"]["rol"]==3){
            agregarPermiso($errores);
        }
        else if($datos->opcion=="Lista usuarios" && $_SESSION["datosUsuario"]["rol"]==3){
            agregarUsuariosGlobal($errores);
        }
        else if($datos->opcion=="Lista roles" && $_SESSION["datosUsuario"]["rol"]==3){
            agregarRol($errores);
        }
        else if($datos->opcion=="Lista productos" && ($_SESSION["datosUsuario"]["rol"]==3 )){
            agregarProductoGlobal($errores);
        }
        else if($datos->opcion=="Productos" && ($_SESSION["datosUsuario"]["rol"]==3 || $_SESSION["datosUsuario"]["rol"]==2)){
            
           agregarProductoPropio($errores);
        }else if($datos->opcion=="Mensajes" && $_SESSION["datosUsuario"]["id"]==1){
            //Cambiar a mensaje a contestar y enviar email.
            contestadoMensaje($errores);
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