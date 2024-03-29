<?php 
include_once '../Modelo/funcionesBBDDmodificar.php';
include_once '../Modelo/funcionesBBDDeliminar.php';
/**
 * Esta función maneja la dirección de los datos y determina a que funciones de la BBDD
 * debe llamarse en cada momento.
 * @param [<Object>] $datos compone los datos recibidos por el usuario.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @param [<Object>] $session se insertará los resultados en caso afirmativo .
 * @see existeAccion siempre se comprueba en primer lugar si la accion en concreto existe para el rol con el
 * que esta registrado el usuario.
 * @return [BOOLEAN]  con resultado de la operación
 */
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
       
        else if($datos->opcion=="Lista Envios" && $_SESSION["datosUsuario"]["id"]==1){
            $session->enviosGlobal=enviosGlobal($errores);
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
/**
 * Esta función maneja la dirección de los datos y determina a que funciones de la BBDD
 * debe llamarse en cada momento para modificarla.
 * @param [<Object>] $datos compone los datos recibidos por el usuario.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @param [<Object>] $session se insertará los resultados en caso afirmativo .
 * @see existeAccion siempre se comprueba en primer lugar si la accion en concreto existe para el rol con el
 * que esta registrado el usuario.
 * @return [BOOLEAN]  con resultado de la operación
 */
function controladorModificaciones($datos,&$errores,&$session){
    $respuesta=existeAccion($errores);
    if($respuesta){
        
    if($datos->opcion=="Lista comentarios" && $_SESSION["datosUsuario"]["rol"]==3){
            modificarComentariosGlobal($errores);
        }
        else if($datos->opcion=="Comentarios"){
           modificarComentariosPropio($errores);
        }
        else if($datos->opcion=="Lista Noticias" && $_SESSION["datosUsuario"]["rol"]==3){
           
           modificarNoticia($errores);
        }
        else if($datos->opcion=="Lista pedidos" && $_SESSION["datosUsuario"]["rol"]==3){
            if($_SESSION["datos"]["estado"]=="Realizado"){
                modificarEstadoPedidoRealizadoAdmin($errores);
            }else if($_SESSION["datos"]["estado"]=="Entregado"){
               modificarEstadoPedidoEntregadoAdmin($errores);
            }
        }
        else if($datos->opcion=="Lista permisos" && $_SESSION["datosUsuario"]["rol"]==3){
            modificarPermiso($errores);
        }
        else if($datos->opcion=="Lista usuarios" && $_SESSION["datosUsuario"]["rol"]==3){
           modificarUsuariosGlobal($errores);
        }
        else if($datos->opcion=="Lista roles" && $_SESSION["datosUsuario"]["rol"]==3){
            $session->usuarios=modificarRol($errores);
        }
        else if($datos->opcion=="Lista productos" && ($_SESSION["datosUsuario"]["rol"]==3 )){
           modificarProductoGlobal($errores);
        }
        else if($datos->opcion=="Productos" && ($_SESSION["datosUsuario"]["rol"]==3 || $_SESSION["datosUsuario"]["rol"]==2)){
            modificarProductosPropio($errores);
        }
        else if($datos->opcion=="Envios" && ($_SESSION["datosUsuario"]["rol"]==3 || $_SESSION["datosUsuario"]["rol"]==2)){
            if($_SESSION["datos"]["estado"]=="Tramitando"){
                modificarEstadoPedidoTramitando($errores);
            }else if($_SESSION["datos"]["estado"]=="Enviado"){
                modificarEstadoPedidoEnviado($errores);
            }else if($_SESSION["datos"]["estado"]=="Finalizado"){
                modificarEstadoPedidoFinalizado($errores);
             }
        }
        else if($datos->opcion=="Lista Envios" && ($_SESSION["datosUsuario"]["rol"]==3)){
            if($_SESSION["datos"]["estado"]=="Tramitando"){
                modificarEstadoPedidoTramitandoAdmin($errores);
            }else if($_SESSION["datos"]["estado"]=="Enviado"){
                modificarEstadoPedidoEnviadoAdmin($errores);
            }else if($_SESSION["datos"]["estado"]=="Finalizado"){
                modificarEstadoPedidoFinalizadoAdmin($errores);
             }
        }
        else if($datos->opcion=="Perfil"){
            modificarUsuariosPropio($errores);
            
        }
    }
    else{
        $session->errores="No existe esa acción";
    }
    //DIVIDIMOS EN IF ENTRA EN ESA OPCION Y LE DAMOS LA INFORMACIÓN QUE QUIERE.
    //Llega la accion que será CRUD y a lo que queremos pedir permiso por ejemplo accion ver, permiso Lista Productos.
    //Dentro de la base de datos primero comprobamos que id tiene el permiso buscando la palabra
}
/**
 * Esta función maneja la dirección de los datos y determina a que funciones de la BBDD
 * debe llamarse en cada momento para eliminarlos.
 * @param [<Object>] $datos compone los datos recibidos por el usuario.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @param [<Object>] $session se insertará los resultados en caso afirmativo .
 * @see existeAccion siempre se comprueba en primer lugar si la accion en concreto existe para el rol con el
 * que esta registrado el usuario.
 * @return [BOOLEAN]  con resultado de la operación
 */
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
        else if(($datos->opcion=="Envios" || $datos->opcion=="Envios")&& ($_SESSION["datosUsuario"]["rol"]==3 || $_SESSION["datosUsuario"]["rol"]==2)){
           eliminarEnvio($errores);
        }else if($datos->opcion=="Lista Envios"&& $_SESSION["datosUsuario"]["rol"]==3 ){
            eliminarEnvio($errores);
        } else if($datos->opcion=="Perfil"){
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
/**
 * Esta función maneja la dirección de los datos y determina a que funciones de la BBDD
 * debe llamarse en cada momento para agregarlos.
 * @param [<Object>] $datos compone los datos recibidos por el usuario.
 * @param [<Object>] $errores se insertarán los posible errores.
 * @param [<Object>] $session se insertará los resultados en caso afirmativo .
 * @see existeAccion siempre se comprueba en primer lugar si la accion en concreto existe para el rol con el
 * que esta registrado el usuario.
 * @return [BOOLEAN]  con resultado de la operación
 */
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