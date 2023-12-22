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

function encriptarPalabra($palabra)
{
   $WORD = "LaBellaVida8";
   $retorno = hash('sha512', $WORD . $palabra);
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
function encriptarTodasPalabras($array)
{
   for ($i = 0; $i < count($array); $i++) {

      $array[$i]->id = encriptarPalabra($array[$i]->id);
   }
   return $array;
}


/** Función que se encarga de indicarnos el tipo de usuario que es agricultor o usuario.
 * No se añade el Administrador porque solo lo puede otorgar otro administrador y no
 * se realizará mediante registro.*/
function IDrol()
{
   if ($_SESSION["datos"]["nombreRol"] == "usuario") {
      $_SESSION["datos"]["rol"] = 1;
   } elseif ($_SESSION["datos"]["nombreRol"] == "agricultor") {
      $_SESSION["datos"]["rol"] = 2;
   }
}

/**
 * Esta función borra los datos que han llegado por parte del frontend y devuelve los errores.
 * @param [<Object>] $errores se insertarán los posible errores.
 */
 
function errores($errores)
{
   unset($_SESSION["datos"]);
   echo json_encode($errores);
}
/**
 * Esta función borra los datos que han llegado por parte del frontend y devuelve usuario y rol.
 * @param [<Object>] $session se insertarán datos que devolveremos al usuario.
 */
function exitoUsuario(&$session)
{  
   unset($_SESSION["datos"]);
   $session->datosUsuario = [$_SESSION["datosUsuario"]["usuario"], $_SESSION["datosUsuario"]["rol"]];
   echo json_encode($session);
}

/**
 * Esta función devuelve los comentarios del producto al frontend.
 * @param [<Object>] $session se insertarán la respuesta.
 * @param  $respuesta contendrá  la respuesta de la BBDD si ha sido exitoso al recoger los comentarios.
 */
function exitoComentarios(&$session, $respuesta)
{
   unset($_SESSION["datos"]);
   $session->datosComentarios = $respuesta;
   echo json_encode($session);
}
/**
 * Esta función devuelve el exito a la hora de comentar el producto.
 * @param [<Object>] $session se insertará la respuesta al frontend.
 */
function exitoAgregarComentario(&$session)
{
   unset($_SESSION["datos"]);
   $session->comentario = "exito";
   echo json_encode($session);
}
/**
 * Esta función comprueba si coinciden los datos de usuario que llegan desde el frontend y los que tenemos dentro de nuestra session en el backend.
 * @param [<Object>] $errores añadirá el error si no coinciden.
 */
function coincideUsuario(&$errores){
   if($_SESSION["datosUsuario"]["usuario"]!=$_SESSION["datos"]["usuario"]){
       $errores->errorBBDD[]="No coinciden credenciales, vuelva a iniciar sesión";
   }
}
function coincidePass(&$errores){
   $passAntigua=encriptarPalabra($_SESSION["datos"]["antiguaPass"]);
   if($_SESSION["datosUsuario"]["pass"]!=$passAntigua){
      $errores->errorBBDD[]="No coinciden credenciales, vuelva a iniciar sesión";
   }
   else{
      $_SESSION["datos"]["pass"]=encriptarPalabra($_SESSION["datos"]["pass"]);
   }
}
