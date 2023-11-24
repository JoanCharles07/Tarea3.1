/**
 * @file Este script se encargará de las funciones relacionadas con usuarios
 * @description Este script realizará distintas funciones como pueden ser funciones de login o registros de usuarios.
 * @author Juan Carlos Rodríguez Miranda.
 * @version 1.0.0
*/
/**
 * Esta función recibe los datos del Usuario y devolverá un array con los resultados.
 * devolverá una promesa que entregará el array y así seguir con el código.
 */
export function recepcionDeDatosUsuario() {
    return new Promise((resolve, reject) => {
        document.getElementById("formulario").addEventListener("submit", function (e) {
            e.preventDefault();
            let datosform = new FormData(document.getElementById("formulario"));
            import("../Modelo/comprobaciones.js").then( (funciones) => {
                console.log("entro4");
                const datos =  funciones.comprobarDatosRegex(datosform);
                resolve(datos);
            })
        })
    });
}