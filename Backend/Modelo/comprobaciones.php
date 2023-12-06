<?php 

function inicioComprobaciones($datosIntroducidos,&$errores){
    
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
 
 function validateInteger($dato){
    return filter_var($dato,FILTER_VALIDATE_INT);
 }
 
 function validateFloat($dato){
    return filter_var($dato,FILTER_VALIDATE_FLOAT);
 }
 
 function regexEstrellas($dato){
 
     $expresionRegular = "/^[1-5]$/";
     $resultado = false;
     if (preg_match($expresionRegular, $dato)) {
         $resultado = true;
     }
     return $resultado;
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
 function RegexBoolean($dato,$name)
 {
     $expresionRegular = "/(?!.*delete)(?!.*select)(?!.*insert)(?!.*update)(?!.*undefined)(?!.*[*=$&|()])(^.{4,25}$)/";
     $resultado = false;
     //comparamos con la expresión regular
     if (!preg_match($expresionRegular, $dato)) {
         $resultado = true;
        
     }

     //tenemos en cuenta otros casos como cantidad o precio que darían true pero no deberían serlo
     if ($name=="estrellasEscogidas" && regexEstrellas($dato) ) {
       
       $resultado = false;
    }
    else if(($name=="IDproducto"|| $name=="id" || $name=="cantidad" || $name=="rol") && validateInteger($dato)){
      
       $resultado = false;
    }
    else if(($name=="precioInicial"|| $name=="precioTotal") && validateFloat($dato)){
      
        $resultado = false;
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
    
   foreach($_SESSION["datos"] as $name => $value){
     //nos aseguramos que name sea asociatibo y que regexboolean sea verdadero.
      if (RegexBoolean($value,$name) && is_string($name)) {
          
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
 

?>