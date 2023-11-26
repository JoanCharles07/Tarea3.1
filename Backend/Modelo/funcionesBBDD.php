<?php

/**
 * Este script contendrá todas las funciones que conectan con la base de datos.
 * 
 * @author Juan Carlos Rodríguez Miranda
 * @version 1.0.0
 */

/**
 * Esta función recuperará todos los productos de la base de datos.
 * 
 * @author Juan Carlos Rodríguez Miranda
 * @version 1.0.0
 */
function recuperarProductos()
{
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
        $_SESSION["errorDesc"]["BBDD"] = $ex->getMessage();
        $_SESSION["depuración"]["BBDD"] = [$ex->getMessage(), $ex->getFile(), $ex->getTraceAsString()];
    }

    return $array;
}
/**
 * Esta función comprobará si ya existe este usuario en la base de datos.
 * 
 * @author Juan Carlos Rodríguez Miranda
 * @version 1.0.0
 */

function datosDuplicados(&$errores)
{
    $res = false;
    $sql = "select nickname,email,DNI from usuario where nickname=:usuario || email=:email  || DNI=:DNI;";

    try {

        $pdo = conectar();
        $stmt = $pdo->prepare($sql);
        $data = [
            'usuario' =>  $_SESSION["datos"]["usuario"],
            'email' =>  $_SESSION["datos"]["email"],
            'DNI' =>  $_SESSION["datos"]["DNI"]
        ];

        if ($stmt->execute($data)) {

            $ret = $stmt->fetchAll();

            if ($ret != null) {


                foreach ($ret as $valor) {
                    if (in_array($_SESSION["datos"]["usuario"], $valor)) {
                        $errores->errorBBDD[] = "Ya existe usuario con ese nombre";
                    }
                    if (in_array($_SESSION["datos"]["email"], $valor)) {

                        $errores->errorBBDD[] = "Ya existe usuario con ese email";
                    }
                    if (in_array($_SESSION["datos"]["DNI"], $valor)) {
                        $errores->errorBBDD[] = "Ya existe usuario con ese DNI";
                    }
                }
            } else {
                
                $res = true;
            }
        } else {
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }

    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        $ret = false;
        //Usarlo si es necesario.
        //$_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];

    };

    return $res;
}
/**
 * Esta función registrará un nuevo usuario en la base de datos.
 * 
 * @author Juan Carlos Rodríguez Miranda
 * @version 1.0.0
 */
function registro(&$errores)
{
    //crear un select y evitar hacer insert si hay duplicaciones
    //donde no debe haberlas.
    $NoDuplicado = datosDuplicados($errores);
    $respuesta = false;
    if ($NoDuplicado) {
        $ret = false;
        
        $sql = "INSERT INTO `usuario` (`Nombre`, `Apellido`, `nickname`,`email`, `dirección`, `ciudad`, `provincia`, `Codigo_Postal`, `DNI`, `pass`, `Id_Rol`) 
        VALUES (:nombre, :apellido,:usuario,:email, :direccion, :ciudad, :provincia, :codigopostal, :DNI, :pass, :rol);";

        try {
            $pdo = conectar();
            $stmt = $pdo->prepare($sql);
            
            $data = [
                'usuario' =>  $_SESSION["datos"]["usuario"],
                'pass' =>  $_SESSION["datos"]["pass"],
                'nombre' =>  $_SESSION["datos"]["nombre"],
                'apellido' =>   $_SESSION["datos"]["apellidos"],
                'direccion' => $_SESSION["datos"]["direccion"],
                'provincia' =>  $_SESSION["datos"]["provincia"],
                'ciudad' =>  $_SESSION["datos"]["ciudad"],
                'codigopostal' =>  $_SESSION["datos"]["cpostal"],
                'email' =>  $_SESSION["datos"]["email"],
                'DNI' =>  $_SESSION["datos"]["DNI"],
                'rol' =>  $_SESSION["datos"]["rol"]
            ];

            if ($stmt->execute($data)) {
                $ret = $stmt->rowCount();
                if ($ret == 1) {
                    

                    $respuesta = true;
                    //Añadimos datos que nos faltan para el usuario dentro del servidor.
                    $_SESSION["datosUsuario"]["id"] = $pdo->lastInsertId();
                    $_SESSION["datosUsuario"]["usuario"]= $_SESSION["datos"]["usuario"];
                    $_SESSION["datosUsuario"]["rol"]= $_SESSION["datos"]["rol"];
                } else {


                    $errores->errorBBDD[] = "No se ha registrado correctamente";
                }
            } else {

                $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
            }
        }

        //Else por si hay algún error
        catch (PDOException $ex) {
            /**En caso de haber excepción será atrapada por el catch*/
            
            //Usarlo si es necesario.
            $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
            var_dump($_SESSION["ErrorDepuracion"]);
        };
    }
    return $respuesta;
}
