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
export function comprobarRegex(nombre,valor) {
  let respuesta = false;
  //Con esta expresión regular podemos confirmar var
  console.log(valor);
  switch (nombre) {
    case "mensaje":
      respuesta = comprobarRegexComentarios(valor);
      console.log("entro");
      break;
    case "id":
    case "comprador":
    case "stock":
        respuesta = !validarNumero(valor);
        break;
    case "valoracion":
              respuesta = comprobarRegexEstrellas(valor);
              
              break;
          
    default:
      let regex = new RegExp(/(?!.*delete)(?!.*select)(?!.*insert)(?!.*update)(?!.*undefined)(?!.*[*=$&|()])(^.{4,40}$)/);
      respuesta = !(regex.test(valor));
  }
  

  return respuesta;
}

/**
 * determina si el parametro valor cumple la expresión regular, si la cumple la respuesta será falsa si no 
 * devolverá true.
 * @param {*} valor es el parámetro que compararemos en la expresión regular 
 *  
 * @returns Boolean con resultado de la expresión regular.
 */
export function comprobarRegexComentarios(valor) {
  let respuesta = false;
  //Con esta expresión regular podemos confirmar var

  let regex = new RegExp(/(?!.*delete)(?!.*select)(?!.*insert)(?!.*update)(?!.*undefined)(?!.*[*=$&|()])(^.{4,250}$)/);
  respuesta = !(regex.test(valor));

  return respuesta;
}

export function comprobarRegexEstrellas(valor) {
  let respuesta = false;
  //Con esta expresión regular podemos confirmar var

  let regex = new RegExp(/[1-5]{1}/);
  respuesta = !(regex.test(valor));

  return respuesta;
}
/**
* Valora todos los datos del FORMDATA y entrega JSON con respuestas false o true
* @param {*} datos es el FormData con los datos del formulario
*  
* @returns JSON con los resultados.
*/
export function comprobarDatosFormDataRegex(datos) {
  let objeto = new Object();
  //Con esta expresión regular podemos confirmar var
  for (const dato of datos.entries()) {
    objeto[dato[0]] = comprobarRegex(dato[0],dato[1]);
   
  }
  console.log(objeto);

  return objeto;
}


/**
* Valora todos los datos del FORMDATA y entrega JSON con respuestas false o true
* @param {*} datos es el FormData con los datos del formulario
*  
* @returns JSON con los resultados.
*/
export function comprobarDatosRegex(datos) {
  let objeto = new Object();
  //Con esta expresión regular podemos confirmar var
  
  for (const dato of Object.entries(datos)) {
    objeto[dato[0]] = comprobarRegex(dato[0],dato[1]);
   
  }
  console.log(objeto);

  return objeto;
}



/**
* Verifica que los inputs de contraseña coincida o no 
*  
* @returns Boolean con el resultado.
*/
export function validarPass() {
  

    let pass2 = document.getElementById("pass2").value;
    let pass = document.getElementById("pass").value;
    if (pass != pass2) {

      return false;
    }
    else {
      return true;
    }
    
 
}
/**
 * Agrega a la session que el usuario esta conectado.
 */
export function usuarioConectado() {

  sessionStorage.setItem("conectado","En linea");
}


export function validarNumero(dato){

  return !isNaN(dato)
}


