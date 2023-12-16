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
export function comprobarRegex(nombre, valor) {
  let respuesta = false;
  //Con esta expresión regular podemos confirmar var
  switch (nombre) {
    case "mensaje":
    
      respuesta = comprobarRegexComentarios(valor);
     
      break;
    case "id":
    case "comprador":
    case "stock":
      respuesta = !validarNumero(valor);
      break;
    case "valoracion":
      respuesta = comprobarRegexEstrellas(valor);

      break;
      case "cuerpo":
      
      respuesta = comprobarRegexNoticia(valor);
      break;
      case "imagen":
        if(valor==false){
          respuesta=true;
        }
        
        break;
    default:
      let regex = new RegExp(/(?!.*delete)(?!.*select)(?!.*insert)(?!.*update)(?!.*undefined)(?!.*script)(?!.*[*=$&|()])(^.{4,40}$)/);
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

  let regex = new RegExp(/(?!.*delete)(?!.*select)(?!.*insert)(?!.*update)(?!.*undefined)(?!.*script)(?!.*[*=$&|()])(^.{4,250}$)/);
  respuesta = !(regex.test(valor));

  return respuesta;
}

export function comprobarRegexNoticia(valor) {
  let respuesta = false;
  //Con esta expresión regular podemos confirmar var
 console.log(valor);
  let regex = new RegExp(/^(?!.*delete)(?!.*select)(?!.*insert)(?!.*update)(?!.*undefined)(?!.*script)[A-Za-z0-9\s\S]{4,2500}$/);
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
    objeto[dato[0]] = comprobarRegex(dato[0], dato[1]);

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
    objeto[dato[0]] = comprobarRegex(dato[0], dato[1]);

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

  sessionStorage.setItem("conectado", "En linea");
}


export function validarNumero(dato) {

  return !isNaN(dato)
}

export function comprobacionREAD() {
  if (sessionStorage.getItem("usuario")) {
    //DATOS NECESARIOS PARA EL SERVIDOR
    const datosUrl = new URLSearchParams(window.location.search);
    const usuario = JSON.parse(atob(sessionStorage.getItem("usuario")));
    const datosIntroducidos = {
      opcion: datosUrl.get('eleccion'),
      accion: "leer",
      usuario: usuario[0]
    }

    let datos = comprobarDatosRegex(datosIntroducidos);
    const control = Object.values(datos).filter(elemento => elemento == true);

    if (control.length == 0) {
      return datosIntroducidos;
    } else {
      return datos;
    }

  }
}
//TIENE EN CUENTA QUE LAS IMAGENES SE TRANSFORMAN PARA NO CAMBIAR PETICION
export async function comprobacionUPDATE() {
  if (sessionStorage.getItem("usuario")) {
    //DATOS NECESARIOS PARA EL SERVIDOR
    const datosModificados = new FormData(document.getElementById("formulario"));
    const usuario = JSON.parse(atob(sessionStorage.getItem("usuario")));
    let datosIntroducidos = {};
    for (const dato of datosModificados.entries()) {
      
      if(dato[0]!="imagen"){
        datosIntroducidos[dato[0]] = dato[1];
      }else{
        // Esperar a que se complete la carga de la imagen
        datosIntroducidos[dato[0]] = await procesarImagen(dato);
        
      }
    }

    datosIntroducidos["usuario"] = usuario[0];
    datosIntroducidos["accion"] = "Modificar";
    let datos = comprobarDatosRegex(datosIntroducidos);
    
    const control = Object.values(datos).filter(elemento => elemento == true);
    if (control.length == 0) {
      return datosIntroducidos;
    } else {
      return datos;
    }

  }
}
async function procesarImagen(dato) {
  return new Promise((resolve) => {
      console.log(dato[1]);
      if(dato[1].size < (1024*1024)){
        let nuevaImagen = new FileReader();
      
        nuevaImagen.readAsDataURL(dato[1]);
        nuevaImagen.onload = () => {
        resolve(nuevaImagen.result);}
      }else{
        resolve(false);
      }
     
      
  });
}
