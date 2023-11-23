<?php
/**
 * Este script controlará el flujo de la información y a que funciones del modelo se debe llamar.
 * 
 * @author Juan Carlos Rodríguez Miranda
 * @version 1.0.0
 */
require_once '../Conf/conn.php';
//include_once '../Modelo/funciones.php';
include_once '../Modelo/funcionesBBDD.php';
header('Content-Type: application/json');
session_start();
$datos=json_decode(file_get_contents('php://input'));
if($datos->llamada=="productos"){
    $respuesta=recuperarProductos();
    echo json_encode($respuesta);
}


?>