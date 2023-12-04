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
   if ($_SESSION["datos"]["rol"] == "usuario") {
      $_SESSION["datos"]["rol"] = 1;
   } elseif ($_SESSION["datos"]["rol"] == "agricultor") {
      $_SESSION["datos"]["rol"] = 2;
   }
}

function errores($errores)
{
   unset($_SESSION["datos"]);
   echo json_encode($errores);
}

function exitoUsuario(&$session)
{
   unset($_SESSION["datos"]);
   $session->datosUsuario = [$_SESSION["datosUsuario"]["usuario"], $_SESSION["datosUsuario"]["rol"]];
   echo json_encode($session);
}

function exitoComentarios(&$session, $respuesta)
{
   unset($_SESSION["datos"]);
   $session->datosComentarios = $respuesta;
   echo json_encode($session);
}

function exitoAgregarComentario(&$session)
{
   unset($_SESSION["datos"]);
   $session->comentario = "exito";
   echo json_encode($session);
}
