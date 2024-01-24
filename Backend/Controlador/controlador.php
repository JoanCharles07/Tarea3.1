<?php

/**
 * Este script controlará el flujo de la información y a que funciones del modelo se debe llamar.
 * 
 * @author Juan Carlos Rodríguez Miranda
 * @version 1.0.0
 */
include '../Conf/conn.php';
include_once './controladorListas.php';
include_once '../Modelo/funciones.php';
include_once '../Modelo/comprobaciones.php';
include_once '../Modelo/funcionesBBDD.php';
include_once '../Modelo/funcionesBBDDagregar.php';
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
        /*****************************************************************************/
        /****************************PRODUCTOS****************************************/
        /*****************************************************************************/
        if ($direccion->llamada == "Productos") {
            $respuesta = recuperarProductos($errores);
           
            //$respuesta=encriptarTodasPalabras($respuesta);
            echo json_encode($respuesta);
        /*****************************************************************************/
        /****************************REGISTRO*****************************************/
        /*****************************************************************************/
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
        }  
        /*****************************************************************************/
        /****************************USUARIO*****************************************/
        /*****************************************************************************/ 
        else if ($direccion->llamada == "Usuario") {
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
        /*****************************************************************************/
        /****************************COMENTARIOS*****************************************/
        /*****************************************************************************/
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
             /*****************************************************************************/
        /****************************AGREGAR COMENTARIOS***********************************/
        /*****************************************************************************/
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
        /*****************************************************************************/
        /****************************AGREGAR CARRITO*****************************************/
        /*****************************************************************************/
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
                errores($errores);
            }
         /*****************************************************************************/
        /****************************BORRAR CARRITO*************************************/
        /*****************************************************************************/
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
        /*****************************************************************************/
        /****************************RECUPERAR CARRITO*****************************************/
        /*****************************************************************************/
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
        /*****************************************************************************/
        /****************************RECUPERAR USUARIO*****************************************/
        /*****************************************************************************/
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
             /*****************************************************************************/
        /****************************FINALIZAR COMPRA*****************************************/
        /*****************************************************************************/
        } else if ($direccion->llamada == "finalizarCompra" && isset($_SESSION["datosUsuario"])) {
            // comprobar el direccion objeto
            // SANEAMIENTO pasar por todos si alguno es false cortamos y devolvemos el error
            
            for ($i=0; $i < count($direccion->objeto) ; $i++) { 
                foreach ($direccion->objeto[$i] as $key => $value) {

                    
                    if($key == 0 || $key==2){
                        $validado= filter_var($value, FILTER_VALIDATE_INT, ["options" => ["min_range" => 0]]);
                    }else{
                        $validado= filter_var($value, FILTER_VALIDATE_FLOAT, ["options" => ["min_range" => 0]]);
                    }
                    //segun $key comprobar float o comprobar int
                    if($validado){
                       
                        $arraySaneado[$i][$key]=$value;
                       
                    }else{
                        $errores->invalido="Algún valor es incorrecto";
                    }
                }
            }
            
            $correcto=comprobacionCompra($direccion->objeto,$errores);
            
            if (empty((array) $errores) && $correcto) {
                //introducimos en base de datos primero el pedido y luego cada uno de los productos
                agregarPedido($errores,$arraySaneado);
                //si no hay errores introducimos en el historial los productos
                for($j=0;$j<count( $arraySaneado);++$j){
                    agregarEnvio($errores,$arraySaneado[$j]);
                }

                //borrar datos Carrito
                borrarCarritoCompleto($errores);
                
                if (empty((array) $errores)) {
                    unset($_SESSION["datos"]);
                    echo json_encode("exito");
                }
                else{
                    errores($errores);    
                }
              
            } else {
                errores($errores);
            }
         /*****************************************************************************/
        /****************************NOTICIAS*****************************************/
        /*****************************************************************************/
        }else if ($direccion->llamada == "noticias") {


            $session = noticia($errores);

            if (empty((array) $errores)) {
                unset($_SESSION["datos"]);
                echo json_encode($session);
            } else {
                errores($errores);
            }
         /*****************************************************************************/
        /****************************LISTAS CRUD LEER*****************************************/
        /*****************************************************************************/
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
        /*****************************************************************************/
        /****************************LISTAS CRUD MODIFICAR*****************************************/
        /*****************************************************************************/
        } else if ($direccion->llamada == "modificar" && isset($_SESSION["datosUsuario"])) {
            
             
            inicioComprobaciones($direccion->datosIntroducidos, $errores);
            
            coincideUsuario($errores);
            if (empty((array) $errores)) {
                
                comprobarRol($errores);
                controladorModificaciones($direccion->datosIntroducidos, $errores, $session);
                
                if (!empty((array) $errores)) {
                    errores($errores);
                }else if(isset($session->usuario)){
                    exitoUsuario($session);
                    
                }else{
                    unset($_SESSION["datos"]);
                    echo json_encode($session);
                }
            } else {
                unset($_SESSION["datos"]);
                errores($errores);
            }
            /** Hago esto porque si yo cambio rol en BBDD hasta que no se reinicie la sesión no surtirían efecto los cambios
             * y en las listas puede haber información delicada.*/

            //Controlar errores
               /*****************************************************************************/
        /****************************LISTAS CRUD AGREGAR*****************************************/
        /*****************************************************************************/
        } else if ($direccion->llamada == "agregar" && isset($_SESSION["datosUsuario"])) {
            
             
            inicioComprobaciones($direccion->datosIntroducidos, $errores);
            coincideUsuario($errores);
            if (empty((array) $errores)) {
                
                comprobarRol($errores);
                controladorAgregar($direccion->datosIntroducidos, $errores, $session);
                if (!empty((array) $errores)) {
                    errores($errores);
                } else if(isset($session->usuario)){
                    
                    exitoUsuario($session);
                    
                }else{
                    unset($_SESSION["datos"]);
                    echo json_encode($session);
                }
            } else {
                unset($_SESSION["datos"]);
                errores($errores);
            }
            /** Hago esto porque si yo cambio rol en BBDD hasta que no se reinicie la sesión no surtirían efecto los cambios
             * y en las listas puede haber información delicada.*/

            //Controlar errores

        } 
           /*****************************************************************************/
        /****************************LISTAS CRUD ELIMINAR*****************************************/
        /*****************************************************************************/
        else if ($direccion->llamada == "eliminar" && isset($_SESSION["datosUsuario"])) {
            
             
            inicioComprobaciones($direccion->datosIntroducidos, $errores);
            
            coincideUsuario($errores);
            if (empty((array) $errores)) {
                
                comprobarRol($errores);
                controladorEliminacion($direccion->datosIntroducidos, $errores, $session);
                
                if (!empty((array) $errores)) {
                   
                    errores($errores);
                } else {
                    unset($_SESSION["datos"]);
                    echo json_encode($session);
                }
            } else {
                unset($_SESSION["datos"]);
                errores($errores);
            }
            /** Hago esto porque si yo cambio rol en BBDD hasta que no se reinicie la sesión no surtirían efecto los cambios
             * y en las listas puede haber información delicada.*/

            //Controlar errores
        /*****************************************************************************/
        /****************************CAMBIAR PASS*****************************************/
        /*****************************************************************************/
        }else if ($direccion->llamada == "cambiarPass" && isset($_SESSION["datosUsuario"])) {
            
             
            inicioComprobaciones($direccion->datosIntroducidos, $errores);
            coincideUsuario($errores);
            coincidePass($errores);

            if (empty((array) $errores)) {
                //comprobar la pass y encriptar la nueva

                $resultado = cambiarPass($errores, $session);
                
                if ($resultado == false) {
                   
                    errores($errores);
                } else {
                    unset($_SESSION["datos"]);
                    echo json_encode($session);
                }
            } else {
                unset($_SESSION["datos"]);
                errores($errores);
            }
            /** Hago esto porque si yo cambio rol en BBDD hasta que no se reinicie la sesión no surtirían efecto los cambios
             * y en las listas puede haber información delicada.*/

            //Controlar errores
           /*****************************************************************************/
        /****************************CERRAR SESIÓN*****************************************/
        /*****************************************************************************/
        }else if ($direccion->llamada == "cerrarSesion" && isset($_SESSION["datosUsuario"])) {
            
            session_destroy();
            echo json_encode(true);
        }
           /*****************************************************************************/
        /****************************COMPROBAR STOCK*****************************************/
        /*****************************************************************************/
        else if ($direccion->llamada == "comprobarStock") {
            inicioComprobaciones($direccion->datosIntroducidos, $errores);
            if (empty((array) $errores)) {
                $session->resultado=comprobarStock($errores);
                if($session->resultado==true){
                    
                    unset($_SESSION["datos"]);
                    echo json_encode($session);
                }else{
                    errores($errores);
                }
            } else {
                errores($errores);
            }
        }
           /*****************************************************************************/
        /****************************MENSAJES*****************************************/
        /*****************************************************************************/
        else if ($direccion->llamada == "enviarMensaje" ) {
            
            inicioComprobaciones($direccion->datosIntroducidos,$errores);
            if (empty((array) $errores)) {
                

                if (!empty((array) $errores)) {
                   
                    errores($errores);
                } else {
                    unset($_SESSION["datos"]);
                    echo json_encode($session);
                }
            } else {
                unset($_SESSION["datos"]);
                errores($errores);
            }

        }else {
            echo json_encode("No hay llamada");
        }
    } else {
        echo json_encode("borraste Sesion");
    }
} catch (\Throwable $th) {
    throw $th;
}
