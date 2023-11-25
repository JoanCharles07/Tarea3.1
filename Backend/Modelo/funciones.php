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
}

 /**
 * Saneamiento de los datos recibidos por el fetch.
 *
 * Esta función sanea todas las palabras que le llegan llamando mediante un bucle for a senamientoDatos.
 * @see saneamiendoDatos.
 * @param Array  sin sanear.
 * @return Array cadena saneada.
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