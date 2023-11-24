/**
 * @file Este script se encargará de las funciones de comprobaciones.
 * @description Este script realizará distintas funciones donde se comprobará que lo datos son correctos unos con otros.
 * @author Juan Carlos Rodríguez Miranda.
 * @version 1.0.0
*/

/**
 * determina si el parametro valor cumple la expresión regular, si la cumple la respuesta será falsa si no 
 * devolverá true.
 * @param {*} valor es el parámetro que compararemos en la expresión regular 
 *  
 * @returns Boolean con resultado de la expresión regular.
 */
function comprobarRegex(valor) {
    let respuesta = false;
    //Con esta expresión regular podemos confirmar var
  
    let regex = new RegExp(/(?!.*delete)(?!.*select)(?!.*insert)(?!.*update)(?!.*undefined)(?!.*[*=$&|()])(^.{4,25}$)/);
    respuesta = !(regex.test(valor));
  
    return respuesta;
  }


  function comprobarDatosRegex(datos) {
    let respuesta = false;
    //Con esta expresión regular podemos confirmar var
  
    let regex = new RegExp(/(?!.*delete)(?!.*select)(?!.*insert)(?!.*update)(?!.*undefined)(?!.*[*=$&|()])(^.{4,25}$)/);
    respuesta = !(regex.test(valor));
  
    return respuesta;
  }
 