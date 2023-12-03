<?php

/**
 * Este script contendrá todas las funciones que conectan con la base de datos.
 * 
 * @author Juan Carlos Rodríguez Miranda
 * @version 1.0.0
 */
function existeComentario(&$errores){
    $sql = "SELECT * FROM comentario where ID_Producto = :idPro and ID_Comprador = :idCom";
    $producto= $_SESSION["datos"]["IDproducto"];
    $comprador=$_SESSION["datosUsuario"]["id"] ;
    $res=false;
    try {
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data = ['idPro' => $producto , 'idCom' => $comprador];
        if ($stmt->execute($data)) {
            $res = $stmt->rowCount();
            if ($res == 0) {
                $res=true;
            } 
            else{
                $errores->errorBBDD[] = "Ya has comentado en este producto.";
            }
        }else{
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        //Usarlo si es necesario.
           // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
            //($_SESSION["ErrorDepuracion"]);
    };

    return $res;
}
    



 function agregarComentario(&$errores){
   
    //Comprobar que no tiene ya comentario en este producto
   
    $NoDuplicado = existeComentario($errores);
    $respuesta=false;
    if ($NoDuplicado) {
        $ret = false;
        $sql = "INSERT INTO `comentario` (`Mensaje`, `valoracion`, `ID_comprador`,`ID_Producto`) 
        VALUES (:comentario, :valoracion,:comprador,:producto);";
        
        try {
            $pdo = conectar();
            $stmt = $pdo->prepare($sql);
            
            $data = [
                'comentario' =>  $_SESSION["datos"]["comentarioTexto"],
                'valoracion' =>  $_SESSION["datos"]["estrellasEscogidas"],
                'comprador' =>  $_SESSION["datosUsuario"]["id"],
                'producto' =>   $_SESSION["datos"]["IDproducto"]
            ];

            if ($stmt->execute($data)) {
                $ret = $stmt->rowCount();
                if ($ret == 1) {
                    

                    $respuesta = true;
                    //Añadimos datos que nos faltan para el usuario dentro del servidor.
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
           // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
            //($_SESSION["ErrorDepuracion"]);
        };
    }
    return $respuesta;
}

function agregarCarrito(&$errores){
   
    //Comprobar que no existe, si existe se cambia directamente en la otra
   
    $NoDuplicado = true;
    $respuesta=false;
    if ($NoDuplicado) {
        $ret = false;
        $sql = "INSERT INTO `carrito` (`cantidad`, `ID_comprador`,`ID_Producto`) 
        VALUES (:cantidad,:comprador,:producto);";
        
        try {
            $pdo = conectar();
            $stmt = $pdo->prepare($sql);
          
            
            $data = [
                'cantidad' =>  $_SESSION["datos"]["cantidad"],
                'comprador' =>  $_SESSION["datosUsuario"]["id"],
                'producto' =>   $_SESSION["datos"]["id"]
            ];

            if ($stmt->execute($data)) {
                $ret = $stmt->rowCount();
                
                if ($ret == 1) {
                    
                    
                    $respuesta = true;
                    //Añadimos datos que nos faltan para el usuario dentro del servidor.
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
            //($_SESSION["ErrorDepuracion"]);
        };
    }
    return $respuesta;
}
/**
 * Esta función recuperará todos los productos de la base de datos.
 * 
 * @author Juan Carlos Rodríguez Miranda
 * @version 1.0.0
 */
function recuperarComentarios($id)
{

    $sql = "SELECT * FROM comentario where ID_Producto = :id";
    $array = [];
    try {
        $pdo=conectar();
        $stmt = $pdo->prepare($sql);
        $data = ['id' => 13];
        if ($stmt->execute($data)) {
            $res = $stmt->fetchAll();
            if ($res != null) {
                
                for ($x = 0; $x < count($res); $x++) {
                    $clase = new stdClass();
                    $clase->mensaje = $res[$x][0];
                    $clase->valoracion = $res[$x][1];
                    $clase->nombre_comprador = nombre_comprador($res[$x][2]);
                    $clase->ID_Producto = $res[$x][3];
                    $array []= $clase;
                }
            } else {
                echo "entro 4";
            }
        }
        
    } catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        echo "Error en la base de datos";
    };

    return $array;
}
function nombre_comprador($id){
    $ret = "";
    //Sentencia sql para conseguir los datos del usuario que deseamos usar.
    $sql = "select nickname from usuario where id = :id";
    try {
        //Conectamos la base de datos
        $res=false;
        $pdo = conectar();
        //Hacemos la sentencia preparada
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id",$id,PDO::PARAM_INT);
        if ($stmt->execute()) {
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            //Si es correcta insertamos datos
            if ($res != null) {
                $ret = $res["nickname"];
            }
       
            else{
            $_SESSION["error"]["BBDD"] = "BBDD";
            $_SESSION["errorDesc"]["BBDD"]="No se ha encontrado usuario correctamente";
            }
            
        }else{
            $_SESSION["error"]["BBDD"] = "BBDD";
            $_SESSION["errorDesc"]["BBDD"]="Ha habido algún problema intenteló de nuevo";
        }
    
       
    }

    //Else por si hay algún error
    catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        
        $_SESSION["error"]["BBDD"] = "BBDD";
        $_SESSION["errorDesc"]["BBDD"]=$ex->getMessage();
        $_SESSION["depuración"]["BBDD"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
    };

    return $ret;
    /*Por si se borrara el localstorage manualmente y entraras de nuevo realmente la sesión la tienes ya abierta comprobaremoso
        que coinciden con los de la sesión iniciada*/
}


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
                    $clase->nombre_producto = $ret[$x][1];
                    $clase->stock = $ret[$x][2];
                    $clase->precio = $ret[$x][3];
                    /**Leemos la imagen para que pueda verse correctamente en la aplicación web*/
                    $clase->imagen = base64_encode($ret[$x][4]);
                    $clase->valoracion_total = $ret[$x][5];
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
           // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
            //($_SESSION["ErrorDepuracion"]);
        };
    }
    return $respuesta;
}
/**
 * Esta función confirmara que el usuario con la contraseña proporcionada existe en la BBDD.
 * 
 * @author Juan Carlos Rodríguez Miranda
 * @version 1.0.0
 */
function usuario(&$errores)
{   
    $ret = false;
    //Por comodidad y ya que no son muchas variables usaremos una para usuario y otra para la contraseña
    $usuario= $_SESSION["datos"]["usuario"];
    $pass=$_SESSION["datos"]["pass"];
    //Sentencia sql para conseguir los datos del usuario que deseamos usar.
    $sql = "select * from usuario where nickname = :usuario and pass = :password ";
    try {
        //Conectamos la base de datos
        $ret = false;
        $pdo = conectar();
        
        //Hacemos la sentencia preparada
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":usuario",$usuario,PDO::PARAM_STR);
        $stmt->bindParam(":password",$pass,PDO::PARAM_STR);
        if ($stmt->execute()) {
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            //Si es correcta insertamos datos
            if ($res != null) {
                $ret = true;
                
                //Insertamos o cambios los datos de la sesión si todo es correcto
                    $_SESSION["datosUsuario"]["id"] = $res["ID"];
                    $_SESSION["datosUsuario"]["usuario"]= $res["nickname"];
                    $_SESSION["datosUsuario"]["rol"]= $res["Id_Rol"];
                
            }
            else{
                $errores->errorBBDD[] = "Usuario o contraseña incorrectos";
            }
            
        }else{
            
            $errores->errorBBDD[] = "Ha habido algún problema intenteló de nuevo";
        }

       
    }

    //Else por si hay algún error
    catch (PDOException $ex) {
        /**En caso de haber excepción será atrapada por el catch*/
        // $_SESSION["ErrorDepuracion"]=[$ex->getMessage(),$ex->getFile(),$ex->getTraceAsString()];
        //($_SESSION["ErrorDepuracion"]);
    };

    return $ret;
    /*Por si se borrara el localstorage manualmente y entraras de nuevo realmente la sesión la tienes ya abierta comprobaremoso
        que coinciden con los de la sesión iniciada*/
}
