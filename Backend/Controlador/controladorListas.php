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
            $session->productos=recuperarProductosAgricultores($errores);
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
            $session->productos=productosAgricultor($errores);
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
        else if($datos->opcion=="Comentarios" && $_SESSION["datosUsuario"]["rol"]==3){
            $session->comentarios=modificarComentariosPropio($errores);
        }
        else if($datos->opcion=="Lista roles" && $_SESSION["datosUsuario"]["rol"]==3){
            $session->roles=recuperarRoles($errores);
        }
        else if($datos->opcion=="Lista productos" && $_SESSION["datosUsuario"]["rol"]==3){
            $session->productos=recuperarProductosAgricultores($errores);
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
            $session->productos=productosAgricultor($errores);
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
        $session->errores="No existe esa acción";
    }
    //DIVIDIMOS EN IF ENTRA EN ESA OPCION Y LE DAMOS LA INFORMACIÓN QUE QUIERE.
    //Llega la accion que será CRUD y a lo que queremos pedir permiso por ejemplo accion ver, permiso Lista Productos.
    //Dentro de la base de datos primero comprobamos que id tiene el permiso buscando la palabra
}

?>