<?php
/**
 * Este script contendrá todas las funciones que conectan con la base de datos.
 * 
 * @author Juan Carlos Rodríguez Miranda
 * @version 1.0.0
 */
function recuperarProductos(){
    
    
    $array = [];
    $sql = "select * from producto";
    $ret = false;
    
    try {
       
        $pdo = conectar();
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            $ret = $stmt->fetchAll();
          
            if ($ret != false) {
                /**Hacer for númerico con $ret */
               
                for ($x = 0; $x < count($ret); $x++) {
                    $clase = new stdClass();
                    $clase->id = $ret[$x][0];
                    $clase->Nombre_Producto = $ret[$x][1];
                    $clase->Stock = $ret[$x][2];
                    $clase->precio = $ret[$x][3];
                    /**Leemos la imagen para que pueda verse correctamente en la aplicación web*/ 
                    $clase->imagen = base64_encode($ret[$x][4]);
                    $clase->valoacion_total = $ret[$x][5];
                    $clase->comentarios_totales = $ret[$x][6];
                    $clase->descuento = $ret[$x][7];
                    //He decidido no introducir el id del vendedor por privacidad.
                   /* $clase->Id_Vendedor = $ret[$x][8];*/

                    $array[] = $clase;
                }
            }
        }
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        $_SESSION["error"]["BBDD"] = "BBDD";
        $_SESSION["errorDesc"]["BBDD"]=$ex->getMessage();
        $_SESSION["depuración"]["BBDD"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
    }
    
   return $array;
}