<?php

/**
 * Esta función llama a las funciones para comprobaciones generales que deben pasar todos lo que inserta el usuario.
 * @param [<Object>] $datosIntroducidos datos que vamos a comprobar.
 * @param [<Object>] $errores donde se guardaran los posibles errores.
 */
function inicioComprobaciones($datosIntroducidos, &$errores)
{

    saneamientoArray($datosIntroducidos);
    //Comprobamos que no haya palabras no validas
    RegexRespuesta($errores);
}

/**
 * Saneamiento de la cadena recibidos por el fetch.
 *
 * Esta función sanea cualquier palabra que le llegue para evitar código malicioso.
 *  @param String cadena sin sanear
 * @return String cadena saneada.
 */
function saneamientoDatos($cadena)
{   
    
    $cadenaSaneado = filter_var($cadena, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //quitamos las tildes que lleguen por html estilo &accudate 
    $cadenaSinHTML = html_entity_decode($cadenaSaneado, ENT_QUOTES | ENT_HTML5, "UTF-8");

    return $cadenaSinHTML;
}

/**
 * Saneamiento de los datos recibidos por el fetch.
 *
 * Esta función sanea todas las palabras que le llegan llamando mediante un bucle for a saneamientoDatos y los mete dentro de la sesión.
 * @see saneamiendoDatos.
 * @param Array  sin sanear.
 */

function saneamientoArray($array)
{
    foreach ($array as $name => $value) {

        if ($name == "email") {
            $_SESSION["datos"][$name] = filter_var($value, FILTER_SANITIZE_EMAIL);
            $_SESSION["datos"][$name] = filter_var($_SESSION["datos"][$name], FILTER_VALIDATE_EMAIL);
        } else {

            $_SESSION["datos"][$name] = saneamientoDatos($value);
        }
    }
}
/**
 * Validamos que sea un entero.
 * @param {*} $dato dato que queremos comparar.
 * @return [Boolean] devuelve el resultado de la comprobación
 */
function validateInteger($dato)
{
    return filter_var($dato, FILTER_VALIDATE_INT);
}
/**
 * Validamos que sea un float "decimal".
 * @param {*} $dato dato que queremos comparar.
 * @return [Boolean] devuelve el resultado de la comprobación
 */
function validateFloat($dato)
{
    return filter_var($dato, FILTER_VALIDATE_FLOAT);
}
/**
 * Validamos que se cumpla la expresión seguridad.
 * @param {*} $dato dato que queremos comparar.
 * @return [Boolean] devuelve el resultado de la comprobación
 */
function regexEstrellas($dato)
{
    $expresionRegular = "/^[1-5]$/";
    $resultado = true;
    if (preg_match($expresionRegular, $dato)) {
        $resultado = false;
    }
    return $resultado;
}



/** Desde esta función se llama a las funciones de expresiones regulares y se comparan contraseñas en caso de no coincidir
 * la REGEX o no coincir las contraseñas añadirá el error al stdClass $errores.
 * @see RegexCodigoPostal, RegexDNI
 * @param Object stdClass para errores.
 */
function otrasComprobaciones(&$errores)
{

    //veremos si el codigo postal es correcto
    if (!RegexCodigoPostal($_SESSION["datos"]["cpostal"])) {
        $errores->cpostal = true;
    }
    //veremos si el DNI es correcto
    if (!RegexDNI($_SESSION["datos"]["DNI"])) {
        $errores->DNI = true;
    }
    //Veremos si la contraseña coinciden
    if ($_SESSION["datos"]["pass"] !=  $_SESSION["datos"]["pass2"]) {
        $errores->pass = true;
        $errores->pass2 = true;
    }
}

/** Expresión regular que impedira que se introduzcan valores de sql importantes y algunos caracteres especiales
 * usados en programación.
 * @param Any cadena de texto a comprobar.
 * @return boolean
 */
function RegexBoolean($dato, $name)
{
    $expresionRegular = "/(?!.*delete)(?!.*select)(?!.*insert)(?!.*update)(?!.*undefined)(?!.*script)(?!.*drop)(?!.*[*=$|()])(^.{4,25}$)/";
    $resultado = false;
    $dato = str_replace("\n", '', $dato);
    //comparamos con la expresión regular
    switch ($name) {
        case 'estrellasEscogidas':
        case 'valoracion':
            $resultado = regexEstrellas($dato);
            break;
        case 'IDproducto':
        case 'id':
        case 'rol':
        case 'IDrol':
        case 'comprador':
        case 'pedido':
        case 'producto':
            $resultado = !validateInteger($dato);
            break;
        case "descuento":
            if (validateInteger($dato) === false) {
                $resultado = true;
            } else if ($dato < 0 || $dato > 100) {
                $resultado = true;
            }
            break;
        case "stock":
        case "cantidad":
        case "producto":

            if (validateInteger($dato) === false) {

                $resultado = true;
            } else if ($dato < 0) {
                $resultado = true;
            }
            break;
        case 'precioInicial':
        case 'precioTotal':
        case 'precio':
            if (validateFloat($dato) === false) {
                $resultado = true;
            } else if ($dato < 0) {
                $resultado = true;
            }
            break;
        case "imagen":
            if($_SESSION["datos"]["imagen"]!="valido"){
                $imagen = base64_decode(explode(",", $_SESSION["datos"]["imagen"])[1]);

            if (strlen($imagen) < (1024 * 1024) && strlen($imagen) > 0) {
                $formato = getimagesizefromstring($imagen)["mime"];
                if (strlen($imagen) < (1024 * 1024) && ($formato == "image/png" || $formato == "image/jpg" || $formato == "image/webp" || $formato == "image/jpeg")) {
                    $_SESSION["datos"]["imagen"] = $imagen;
                } else {
                    $resultado = true;
                }
            } else {
                $resultado = true;
            }
            }
            

            break;
        case "fecha":
            $comprobar = explode("-", $dato);
            $resultado = !checkdate($comprobar[1], $comprobar[2], $comprobar[0]);
            break;

        case 'mensaje':
        case 'titulo':
        case 'subtitulo':
        case 'direccion':
        case 'comentarioTexto':
            $expresionRegular2 = "/(?!.*delete)(?!.*select)(?!.*insert)(?!.*update)(?!.*undefined)(?!.*script)(?!.*drop)(?!.*[*=$|()])(^.{4,250}$)/";
            $resultado = false;
            if (!preg_match($expresionRegular2, $dato)) {
                $resultado = true;
            }
            break;
        case "cuerpo": //ponemos s al final para que nos deje añadir saltos de linea
            $expresionRegular2 = "/(?!.*delete)(?!.*select)(?!.*insert)(?!.*update)(?!.*undefined)(?!.*script)(?!.*drop)(?!.*[*=$|()])(^.{4,1000}$)/s";
            $resultado = false;
            if (!preg_match($expresionRegular2, $dato)) {
                $resultado = true;
            }
            break;
        default:
            if (!preg_match($expresionRegular, $dato)) {
                $resultado = true;
            }
            break;
    }

    return $resultado;
}

/** Desde esta función se llama a la funcion de expresion regular y se comparan contraseñas en caso de no coincidir
 * la REGEX añadiremos a errores ese dato.
 * @see RegexBoolean
 * @param Object stdClass para errores.
 */
function RegexRespuesta(&$errores)
{

    foreach ($_SESSION["datos"] as $name => $value) {
        //nos aseguramos que name sea asociatibo y que regexboolean sea verdadero.
        $valor = transformarPalabra($value);
        if (RegexBoolean($valor, $name) && is_string($name)) {

            $errores->$name = true;
        }
    }
}
//Dos arrays el primero con tildes el segundo como quiero que se quede y el tercero la cadena  luego lo paso a minuscula
/** con str_replace cambiamos todas las tildes si las hubiera y luego lo devolvemos en minúsculas para hacer las 
 * comparaciones
 * @param Any cadena de texto a comprobar.
 * @return Any modificado 
 */
function transformarPalabra($dato)
{
    $cadena = str_replace(array("Á", "á", "É", "é", "Í", "í", "Ó", "ó", "Ú", "ú", " "), array("a", "a", "e", "e", "i", "i", "o", "o", "u", "u", ""), $dato);
    //devolvemos cadena en minusculas para el filtro no lo tenga en cuenta
    return strtolower($cadena);
}
/** Expresión regular que impedira que se introduzca un DNI no válido.
 * @param Any cadena de texto a comprobar.
 * @return boolean
 */
function RegexDNI($dato)
{
    $expresionRegular = "/^[0-9]{8}[A-Za-z]$/";
    $resultado = false;
    if (preg_match($expresionRegular, $dato)) {
        $resultado = true;
    }
    return $resultado;
}
/** Expresión regular que impedira que se introduzca un cóidgo postal no válido.
 * @param Any cadena de texto a comprobar.
 * @return boolean
 */
function RegexCodigoPostal($dato)
{
    $expresionRegular = "/^[0-9]{3,5}$/";
    $resultado = false;
    if (preg_match($expresionRegular, $dato)) {
        $resultado = true;
    }
    return $resultado;
}

function comprobacionCompra($productos,&$errores)
{   
  
    $correcto = true;
    $respuesta = recuperarProductos($errores);
    for ($i = 0; $i < count($respuesta); $i++) {
        for ($j = 0; $j < count($productos); ++$j) {
            if ($respuesta[$i]->id == $productos[$j][0]) {
                //se calcula si hay descuento y luego se multiplica la cantidad
                $precioBBDD = number_format($respuesta[$i]->precio * $productos[$j][2], 2);
                if (($precioBBDD != $productos[$j][3])) {
                    $errores->error = "No coinciden importes";
                    $correcto = false;
                    break;
                    //podemos meter los dos arrays o uno con los datos que necesito del pedido.
                }else if($respuesta[$i]->stock < $productos[$j][2]){
                    $errores->error = "No hay stock suficiente de ".$respuesta[$i]->nombre_producto;
                    $correcto = false;
                    break;
                }
            }
        }
        if (!$correcto) {
            break;
        }
    }

    return $correcto;
}
