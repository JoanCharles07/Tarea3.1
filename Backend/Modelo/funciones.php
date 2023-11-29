<?php
/**
 * Este script contendrá todo tipo de funciones que no tienen que ver con la BBDD.
 * 
 * Entre otras tendremos la comprobaciones,encriptaciones y cualquier cosa necesaria para el funcionamiento de
 * nuestra aplicación web.
 * 
 * @author Juan Carlos Rodríguez Miranda
 * @version 1.0.0
 */

/**
 * Encripta cualquier String.
 *
 * Esta función encripta cualquier String que llegue como parametro usando hash con una palabra escogida por nosotros.
 *
 * @param String palabra que queremos encriptar
 * @return String palabra encriptada.
 */

 function encriptarPalabra($palabra){
    $WORD = "LaBellaVida8";
    $retorno=hash('sha512',$WORD.$palabra);
    return $retorno;
 }
 /**
 * Encripta cualquier String.
 *
 * Esta función encripta cualquier String que llegue como parametro usando hash con una palabra escogida por nosotros.
 *
 * @param String palabra que queremos encriptar
 * @return String palabra encriptada.
 */


 /**
 * Encripta cualquier Array.
 *
 * Esta función encripta cualquier Array mediante un bucle for que llama sucesivamente a la función encriptarPalabra.
 * @see encriptarPalabra
 * @param Array array que queremos encriptar
 * @return Array array encriptado.
 */
 function encriptarTodasPalabras($array){
    for($i=0; $i<count($array) ; $i++){
        
      $array[$i]->id=encriptarPalabra($array[$i]->id);
    }
    return $array;
 }

 /**
 * Saneamiento de la cadena recibidos por el fetch.
 *
 * Esta función sanea cualquier palabra que le llegue para evitar código malicioso.
 *  @param String cadena sin sanear
 * @return String cadena saneada.
 */
function saneamientoDatos($cadena){
   $cadenaSaneado=filter_var($cadena,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   
   return $cadenaSaneado;
}

 /**
 * Saneamiento de los datos recibidos por el fetch.
 *
 * Esta función sanea todas las palabras que le llegan llamando mediante un bucle for a saneamientoDatos y los mete dentro de la sesión.
 * @see saneamiendoDatos.
 * @param Array  sin sanear.
 */
function saneamientoArray($array){
   foreach($array as $name => $value){
      if($name == "email"){
         $_SESSION["datos"][$name]=filter_var($value,FILTER_SANITIZE_EMAIL);
         $_SESSION["datos"][$name]=filter_var($_SESSION["datos"][$name],FILTER_VALIDATE_EMAIL);
      }
      else{
         $_SESSION["datos"][$name]=saneamientoDatos($value);
      }
   }
   
}


/** Desde esta función se llama a las funciones de expresiones regulares y se comparan contraseñas en caso de no coincidir
 * la REGEX o no coincir las contraseñas añadirá el error al stdClass $errores.
 * @see RegexCodigoPostal, RegexDNI
 * @param Object stdClass para errores.
*/
function otrasComprobaciones(&$errores){
   
   //veremos si el codigo postal es correcto
   if(!RegexCodigoPostal( $_SESSION["datos"]["cpostal"])){
      $errores->cpostal = true; 
  }
   //veremos si el DNI es correcto
   if(!RegexDNI( $_SESSION["datos"]["DNI"])){
      $errores->DNI = true;
  }
   //Veremos si la contraseña coinciden
   if( $_SESSION["datos"]["pass"] !=  $_SESSION["datos"]["pass2"]){
      $errores->pass=true;
      $errores->pass2=true;
      
  }
}

/** Expresión regular que impedira que se introduzcan valores de sql importantes y algunos caracteres especiales
 * usados en programación.
 * @param Any cadena de texto a comprobar.
 * @return boolean
*/
function RegexBoolean($dato)
{
    $expresionRegular = "/(?!.*delete)(?!.*select)(?!.*insert)(?!.*update)(?!.*undefined)(?!.*[*=$&|()])(^.{4,25}$)/";
    $resultado = false;
    if (!preg_match($expresionRegular, $dato)) {
        $resultado = true;
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
   $session=$errores;
               
   foreach($_SESSION["datos"] as $name => $value){
      if (RegexBoolean($value)) {
         $errores->$name = true;
         
     }
   }
   
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

/** Función que se encarga de indicarnos el tipo de usuario que es agricultor o usuario.
 * No se añade el Administrador porque solo lo puede otorgar otro administrador y no
 * se realizará mediante registro.*/ 
function IDrol(){
   if($_SESSION["datos"]["rol"]=="usuario"){
       $_SESSION["datos"]["rol"]=1;
   }
   elseif($_SESSION["datos"]["rol"]=="agricultor"){
       $_SESSION["datos"]["rol"]=2;
   }

}