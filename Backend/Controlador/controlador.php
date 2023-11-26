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
    
    if($direccion->llamada=="productos"){
        $respuesta=recuperarProductos();
        $respuesta=encriptarTodasPalabras($respuesta);
        echo json_encode($respuesta);
    }
    else if($direccion->llamada=="registro"){
        //Saneamos
        saneamientoArray($direccion->datosRegistro);
        //Comprobamos que no haya palabras no validas
        
        RegexRespuesta($errores);
        //Hacemos otras comprobaciones
        otrasComprobaciones($errores);
        //Si hay errores nno es necesario seguir y evitamos que entre a las funciones de la BBDD
        if(empty((array) $errores)){
            
            $respuesta=registro($errores);
            //Segunda Ronda de errores dentro de BBDD
            if($respuesta){
                $session->registrado=true;
                echo json_encode($session);
            }
            else{
                $session=$errores;
                echo json_encode($session);
            }
        }
        else{
            //El valor sesion que devolverremos lo convertimos en los errores
            
            $session=$errores;
            echo json_encode($session);
        }
    }
}
else{
    echo "Hola a Todos";
}



?>