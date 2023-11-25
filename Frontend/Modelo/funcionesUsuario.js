/**
 * @file Este script se encargará de las funciones relacionadas con usuarios
 * @description Este script realizará distintas funciones como pueden ser funciones de login o registros de usuarios.
 * @author Juan Carlos Rodríguez Miranda.
 * @version 1.0.0
*/
/**
 * Esta función recibe los datos del Usuario y devolverá un array con los resultados.
 * devolverá una promesa que entregará el array y así seguir con el código.
 * 
 * returns promesa con los datos JSON recibidos por comprobarDatosRegex.
 */
export function recepcionDeDatosUsuario() {
    return new Promise((resolve, reject) => {
       
            
            let datosform = new FormData(document.getElementById("formulario"));
            import("../Modelo/comprobaciones.js").then((funciones) => {
                const datos = funciones.comprobarDatosRegex(datosform);
                if(datos!=null){
                    resolve(datos);
               }
               else{
                    reject("Hubo un error Recepción de Datos Usuario");
               }
            })
        })

    
}

/**
 * Esta función llama a la función validarPass que devolverá el resultado.
 * 
 * @return Promise con el resultado de la función validarPass
 */
export function passIguales() {
    return new Promise((resolve, reject) => {

        import("../Modelo/comprobaciones.js").then((funciones) => {

            let pass = funciones.validarPass();
           if(pass!=null){
                resolve(pass);
           }
           else{
                reject("Hubo un error en PassIguales");
           }
            
        });
    })


};
