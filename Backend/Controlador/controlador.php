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
       
        $respuesta="recuperarProductos();";
        echo json_encode($respuesta);
    }
}
else{
    echo "Hola a Todos";
}



?>