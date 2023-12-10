<?php 

function controladorLista($datos,&$errores){
    $respuesta=existeAccion($errores);
    if($respuesta){

        if($datos->opcion=="Comentarios"){
            return recuperarComentariosUsuario($errores);
        }
    }
    //DIVIDIMOS EN IF ENTRA EN ESA OPCION Y LE DAMOS LA INFORMACIÓN QUE QUIERE.
    //Llega la accion que será CRUD y a lo que queremos pedir permiso por ejemplo accion ver, permiso Lista Productos.
    //Dentro de la base de datos primero comprobamos que id tiene el permiso buscando la palabra
}

?>