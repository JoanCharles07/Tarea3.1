/**
 * @file Este script controlará las interacciones entre usuario y aplicación.
 * @description Este script controla la interaccion de datos tanto entre la vista y el modelo
 * como entre distintos modelos, haciendo este su punto de unión. Además cuenta con una función donde
 * se llama a todas las funciones comunes a todas ls vistas.
 * @author Juan Carlos Rodríguez Miranda.
 * @version 1.0.0
*/


//Importaciones necesarias para el funcionamiento de controlador.js

/**
 * Esta función nos aseguraremos con la promesa que se ejecute antes que cualquier otra cosa.
 * Crearemos dos variables ya que haremos dos imports uno para las funciones de impresión en el DOM
 * y otra para funciones que darán funcionalidad que siempre debe estar presente.
 * @returns Devuelve el resultado de la promesa
 */
function requerimientosComunes(){
    let metodosPlantilla;
    let metodosGeneral;
    //Lo primero es la cabezera y la barra de navegación
    return import("../Vistas/plantillaGeneral.js")
    .then((moduloPlantilla) => {
        metodosPlantilla=moduloPlantilla
        return import("../Modelo/funcionesGenerales.js");
       
      }).then((moduloGeneral)=>{
        metodosGeneral=moduloGeneral;
        return metodosPlantilla.imprimirCabezera();
      }).then(()=>{
        return metodosGeneral.METODOQUESEA();
      })
    .catch(error => console.log(error));
}
/**
 * Esta función se encargará de activar las distintas funciones según la vista en la que este.
 * Pero primero realizará una promesa para que se ejecuten todas las acciones comunes.
 *  
 * @throws(error)Saltará si alguna de las promesas no puede llevar a cabo su función.
 */
function interaccionesControlador(){
    requerimientosComunes()
    .then((respuesta)=>{
        console.log(respuesta);
    })
    .then(()=>{
        
    if(window.location.pathname.includes("index.html")){

        console.log("Hola");
    }
    })
    

}
interaccionesControlador();
