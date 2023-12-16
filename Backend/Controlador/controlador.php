<?php

/**
 * Este script controlará el flujo de la información y a que funciones del modelo se debe llamar.
 * 
 * @author Juan Carlos Rodríguez Miranda
 * @version 1.0.0
 */
require_once '../Conf/conn.php';
include_once './controladorListas.php';
include_once '../Modelo/funciones.php';
include_once '../Modelo/comprobaciones.php';
include_once '../Modelo/funcionesBBDD.php';
header('Content-Type: application/json');
session_start();

$errores = new stdClass;
$session = new stdClass;
/**En primer lugar comprobaremos si existe POST de existir entraremos en nuestro controlador
 * que según la propiedad llamada entrará en un if u otro.
 */

try {
    if (isset($_POST)) {
        $direccion = json_decode(file_get_contents('php://input'));
        
        if ($direccion->llamada == "Productos") {
            $respuesta = recuperarProductos($errores);
            //$respuesta=encriptarTodasPalabras($respuesta);
            echo json_encode($respuesta);
        } else if ($direccion->llamada == "Registro") {
            inicioComprobaciones($direccion->datosIntroducidos, $errores);
            //Hacemos otras comprobaciones
            otrasComprobaciones($errores);
            //transformamos el dato de Rol para la BBDD.
            IDrol();
            //Si hay errores nno es necesario seguir y evitamos que entre a las funciones de la BBDD
            if (empty((array) $errores)) {
                $_SESSION["datos"]["pass"] = encriptarPalabra($_SESSION["datos"]["pass"]);
                $respuesta = registro($errores, $session);
                //Segunda Ronda de errores dentro de BBDD
                if ($respuesta) {
                    exitoUsuario($session);
                } else {
                    errores($errores);
                }
            } else {
                //El valor sesion que devolverremos lo convertimos en los errores
                errores($errores);
            }
        } else if ($direccion->llamada == "Usuario") {
            inicioComprobaciones($direccion->datosIntroducidos, $errores);
            if (empty((array) $errores)) {
                $_SESSION["datos"]["pass"] = encriptarPalabra($_SESSION["datos"]["pass"]);
                $respuesta = usuario($errores, $session);
                if ($respuesta) {
                    exitoUsuario($session);
                } else {
                    errores($errores);
                }
            } else {
                errores($errores);
            }
        } else if ($direccion->llamada == "Comentarios") {

            inicioComprobaciones($direccion->datosIntroducidos, $errores);
            if (empty((array) $errores)) {
                $respuesta = recuperarComentarios($_SESSION["datos"]['id'], $errores);
                if (!empty($respuesta)) {
                    exitoComentarios($session, $respuesta);
                } else {
                    errores($errores);
                }
            } else {
                errores($errores);
            }
        } else if ($direccion->llamada == "agregarComentario" && isset($_SESSION["datosUsuario"])) {
            inicioComprobaciones($direccion->datosIntroducidos, $errores);

            if (empty((array) $errores)) {
                $respuesta = agregarComentario($errores);

                if ($respuesta) {
                    exitoAgregarComentario($session);
                } else {
                    errores($errores);
                }
            } else {
                errores($errores);
            }
        } else if ($direccion->llamada == "agregarCarritoBBDD" && isset($_SESSION["datosUsuario"])) {

            inicioComprobaciones($direccion->datosIntroducidos, $errores);
            if (empty((array) $errores)) {

                $respuesta = agregarCarrito($errores);

                if ($respuesta) {
                    unset($_SESSION["datos"]);
                    echo json_encode($session);
                } else {

                    errores($errores);
                }
            } else {
                echo "aqui";
                errores($errores);
            }
        } else if ($direccion->llamada == "borrarCarritoBBDD" && isset($_SESSION["datosUsuario"])) {

            inicioComprobaciones($direccion->datosIntroducidos, $errores);
            if (empty((array) $errores)) {

                $respuesta = borrarCarrito($errores);

                if ($respuesta) {
                    unset($_SESSION["datos"]);
                    echo json_encode($session);
                } else {

                    errores($errores);
                }
            } else {
                echo "aqui";
                errores($errores);
            }
        } else if ($direccion->llamada == "recuperarCarrito" && isset($_SESSION["datosUsuario"])) {

            inicioComprobaciones($direccion->datosIntroducidos, $errores);
            coincideUsuario($errores);

            if (empty((array) $errores)) {

                $respuesta = recuperarCarrito($errores, $session);
                if ($respuesta) {
                    unset($_SESSION["datos"]);
                    echo json_encode($session);
                } else {
                    errores($errores);
                }
            } else {
                errores($errores);
            }
        } else if ($direccion->llamada == "recuperarUsuario" && isset($_SESSION["datosUsuario"])) {

            inicioComprobaciones($direccion->datosIntroducidos, $errores);
            coincideUsuario($errores);


            if (empty((array) $errores)) {
                $respuesta = recuperarUsuario($errores, $session);
                if ($respuesta) {
                    unset($_SESSION["datos"]);
                    echo json_encode($session);
                } else {
                    errores($errores);
                }
            } else {
                errores($errores);
            }
        } else if ($direccion->llamada == "noticias") {


            $session = noticia($errores);

            if (empty((array) $errores)) {
                unset($_SESSION["datos"]);
                echo json_encode($session);
            } else {
                errores($errores);
            }
        } else if ($direccion->llamada == "listas" && isset($_SESSION["datosUsuario"])) {
            //llamar para comparar usuario y rol y ver si coinciden.Si no coinciden fuera directamente.
            //asegurarnos que tanto la palabra como la accion no se han adulterado y entramos al controlador de listas.
            //Transformar aqui al nombre del permiso para no tenerlo en el frontend.
            //var_dump($direccion->datosIntroducidos);
            //sanear
            inicioComprobaciones($direccion->datosIntroducidos, $errores);
            coincideUsuario($errores);

            /** Hago esto porque si yo cambio rol en BBDD hasta que no se reinicie la sesión no surtirían efecto los cambios
             * y en las listas puede haber información delicada.*/
            comprobarRol($errores);
            if (empty((array) $errores)) {
                controladorLista($direccion->datosIntroducidos, $errores, $session);
                unset($_SESSION["datos"]);
                //Controlar errores
                echo json_encode($session);
            } else {
                errores($errores);
            }
        } else if ($direccion->llamada == "modificar" && isset($_SESSION["datosUsuario"])) {
            
             
            inicioComprobaciones($direccion->datosIntroducidos, $errores);
            
            coincideUsuario($errores);
            if (empty((array) $errores)) {
                
                comprobarRol($errores);
                $resultado = controladorModificaciones($direccion->datosIntroducidos, $errores, $session);
                if ($resultado == false) {
                   
                    errores($errores);
                } else {
                    echo json_encode($session);
                }
            } else {
                errores($errores);
            }
            /** Hago esto porque si yo cambio rol en BBDD hasta que no se reinicie la sesión no surtirían efecto los cambios
             * y en las listas puede haber información delicada.*/

            //Controlar errores

        } else {
            echo json_encode("No hay llamada");
        }
    } else {
        echo json_encode("borraste Sesion");
    }
} catch (\Throwable $th) {
    throw $th;
}
