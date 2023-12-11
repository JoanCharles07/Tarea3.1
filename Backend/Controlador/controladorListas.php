<?php 

function controladorLista($datos,&$errores,&$session){
    $respuesta=existeAccion($errores);
    if($respuesta){

        if($datos->opcion=="Comentarios"){
            $session->comentarios=recuperarComentariosUsuario($errores);
        }
        else if($datos->opcion=="Lista comentarios"){
            $session->comentarios=recuperarComentariosGlobal($errores);
        }
        else if($datos->opcion=="Lista usuarios"){
            $session->usuarios=recuperarUsuariosGlobal($errores);
        }
        else if($datos->opcion=="Lista roles"){
            $session->roles=recuperarRoles($errores);
        }
        else if($datos->opcion=="Lista productos"){
            $session->productos=recuperarProductosAgricultor($errores);
        }
        else if($datos->opcion=="Lista permisos"){
            $session->permisos=recuperarPermisos($errores);
        }
    }
    //DIVIDIMOS EN IF ENTRA EN ESA OPCION Y LE DAMOS LA INFORMACIÓN QUE QUIERE.
    //Llega la accion que será CRUD y a lo que queremos pedir permiso por ejemplo accion ver, permiso Lista Productos.
    //Dentro de la base de datos primero comprobamos que id tiene el permiso buscando la palabra
}

?>