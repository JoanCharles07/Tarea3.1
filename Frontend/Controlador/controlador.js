/**
 * @file Este script controlará las interacciones entre usuario y aplicación.
 * @description Este script controla la interaccion de datos tanto entre la vista y el modelo
 * como entre distintos modelos, haciendo este su punto de unión. Además cuenta con una función donde
 * se llama a todas las funciones comunes a todas ls vistas.
 * @author Juan Carlos Rodríguez Miranda.
 * @version 1.0.0
*/


//Importaciones necesarias para el funcionamiento de controlador.js
import { imprimirCabezera} from "../Vistas/plantillaGeneral.js";
import { comprobarProductos} from "../Modelo/funcionesGenerales.js";
/**
 * Esta función nos aseguraremos con la promesa que se ejecute antes que cualquier otra cosa.
 * Crearemos las promesas necesarias de todas las funciones que queremos que se ejecuten antes de empezar.
 * @returns Devuelve el resultado de la promesa
 */
function requerimientosComunes(){
  return new Promise((resolve, reject) => {
    try {

        const Promesa1= imprimirCabezera();
        const Promesa2=comprobarProductos();
        Promise.all([Promesa1,Promesa2]).then(respuestas =>{
          
          for(let respuesta of respuestas){
            console.log(respuesta);
          }
          resolve();
          
        })
    } catch (error) {
        reject(error);
    }
});
    
    //Lo primero es la cabezera y la barra de navegación
    
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
        console.log("respuesta");
    })
    .then(()=>{
        
    if(window.location.pathname.includes("tienda.html")){
      import("../Vistas/plantillasEspecificas.js").then( (plantilla)=> {
         plantilla.imprimirProductos();
      })
    }
    else if(window.location.pathname.includes("registro.html")){
        console.log("Adios");
    }
    });
    

}
interaccionesControlador();
