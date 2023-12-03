<?php
/**
 * Este script controlará el flujo de la información y a que funciones del modelo se debe llamar.
 * 
 * @author Juan Carlos Rodríguez Miranda
 * @version 1.0.0
 */
require_once '../Conf/conn.php';
include_once '../Modelo/funciones.php';
include_once '../Modelo/funcionesBBDD.php';
header('Content-Type: application/json');
session_start();

$errores=new stdClass;
$session=new stdClass;
/**En primer lugar comprobaremos si existe POST de existir entraremos en nuestro controlador
 * que según la propiedad llamada entrará en un if u otro.
 */
if(isset($_POST)){
    $direccion=json_decode(file_get_contents('php://input'));
    
    if($direccion->llamada=="Productos"){
        $respuesta=recuperarProductos();
        $respuesta=encriptarTodasPalabras($respuesta);
        echo json_encode($respuesta);
    }
    else if($direccion->llamada=="Registro"){
        //Saneamos
        saneamientoArray($direccion->datosIntroducidos);
       
         //Comprobamos que no haya palabras no validas
        RegexRespuesta($errores);
        //Hacemos otras comprobaciones
        otrasComprobaciones($errores);
        //transformamos el dato de Rol para la BBDD.
        IDrol();
        //Si hay errores nno es necesario seguir y evitamos que entre a las funciones de la BBDD
        if(empty((array) $errores)){
            $_SESSION["datos"]["pass"]=encriptarPalabra($_SESSION["datos"]["pass"]);
            $respuesta=registro($errores);
            //Segunda Ronda de errores dentro de BBDD
            if($respuesta){
                unset($_SESSION["datos"]);
                $session->datosUsuario=[$_SESSION["datosUsuario"]["usuario"],$_SESSION["datosUsuario"]["rol"]];
                echo json_encode($session);
            }
            else{
                unset($_SESSION["datos"]);
                $session=$errores;
                echo json_encode($session);
            }
        }
        else{
            //El valor sesion que devolverremos lo convertimos en los errores
            session_destroy();
            echo json_encode($session);
        }
    }else if($direccion->llamada=="Usuario"){
        
        saneamientoArray($direccion->datosIntroducidos);
         //Comprobamos que no haya palabras no validas
        RegexRespuesta($errores);
        if(empty((array) $errores)){
            $_SESSION["datos"]["pass"]=encriptarPalabra($_SESSION["datos"]["pass"]);
            $respuesta=usuario($errores);
            if($respuesta){
                unset($_SESSION["datos"]);
                $session->datosUsuario=[$_SESSION["datosUsuario"]["usuario"],$_SESSION["datosUsuario"]["rol"]];
                echo json_encode($session);
            }
            else{
                unset($_SESSION["datos"]);
                $session=$errores;
                echo json_encode($session);
            }
        }
        else{
            $session=$errores;
            echo json_encode($session);
        }
        

    }else if($direccion->llamada=="Comentarios"){
        $_SESSION["datos"]['id']=saneamientoDatos($direccion->id);
        $incorrecto=RegexBoolean($_SESSION["datos"]['id']);
        if($incorrecto){
            $respuesta=recuperarComentarios($_SESSION["datos"]['id']);
            if(!empty($respuesta)){
                unset($_SESSION["datos"]);
                $session->datosComentarios=$respuesta;
                echo json_encode($session);
            }
            else{
                echo "vacio";
            }
        }
        else{
            $session=$errores;
            echo json_encode($session);
        }
    }
    else if($direccion->llamada=="agregarComentario" && isset($_SESSION["datosUsuario"])){
        
        saneamientoArray($direccion->datosIntroducidos);
         //Comprobamos que no haya palabras no validas
         RegexRespuesta($errores);
         echo "entro aqui";
        if(empty((array) $errores)){
            
            $respuesta=agregarComentario($errores);
            unset($_SESSION["datos"]);
            if($respuesta){
                $session->comentario="exito";
                echo json_encode($session);
            }
            else{
                $session=$errores;
                echo json_encode($session);
            }
        }
        else{
            $errores->comentarioTexto="No es correcto";
            $errores->estrellasEscogidas="No es correcto";
            unset($_SESSION["datos"]);
            $session=$errores;
            echo json_encode($session);
           
        }
    }
    else if($direccion->llamada=="agregarCarrito" && isset($_SESSION["datosUsuario"])){
        echo json_encode("Entro aqui 2");
        saneamientoArray($direccion->datosIntroducidos);
         //Comprobamos que no haya palabras no validas
         RegexRespuesta($errores);
         
         
        if(empty((array) $errores)){
            
            $respuesta=agregarCarrito($errores);
            unset($_SESSION["datos"]);
            if($respuesta){
                $session->comentario="exito";
                echo json_encode($session);
            }
            else{
                $session=$errores;
                echo json_encode($session);
            }
        }
        else{
            $errores->comentarioTexto="No es correcto";
            $errores->estrellasEscogidas="No es correcto";
            unset($_SESSION["datos"]);
            $session=$errores;
            echo json_encode($session);
           
        }
    }
    else{
        echo json_encode("No hay llamada");
    }
}
else{
    echo json_encode("borraste Sesion");
}



?>