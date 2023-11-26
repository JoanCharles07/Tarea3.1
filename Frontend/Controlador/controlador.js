/**
 * @file Este script controlará las interacciones entre usuario y aplicación.
 * @description Este script controla la interaccion de datos tanto entre la vista y el modelo
 * como entre distintos modelos, haciendo este su punto de unión. Además cuenta con una función donde
 * se llama a todas las funciones comunes a todas ls vistas.
 * @author Juan Carlos Rodríguez Miranda.
 * @version 1.0.0
*/


//Importaciones necesarias para el funcionamiento de controlador.js
import { imprimirCabezera,mostrarUsuario,acciones } from "../Vistas/plantillaGeneral.js";
import { comprobarProductos } from "./controladorInicial.js";
import { passIguales, recepcionDeDatosUsuario } from "./controladorUsuario.js";
import { imprimirIgualdadPass, imprimirTodosResultados,imprimirProductos } from "../Vistas/plantillasEspecificas.js";

/**
 * Esta función nos aseguraremos con la promesa que se ejecute antes que cualquier otra cosa.
 * Crearemos las promesas necesarias de todas las funciones que queremos que se ejecuten antes de empezar.
 * @returns Devuelve el resultado de la promesa
 */
function requerimientosComunes() {
  return new Promise((resolve, reject) => {
    try {

      const Promesa1 = imprimirCabezera();
      const Promesa2 = comprobarProductos();
     
      Promise.all([Promesa1, Promesa2]).then(respuestas => {

           if(sessionStorage.getItem("usuario")){
                //pondremos lo siguiente.
            
                mostrarUsuario();
                acciones();
                comprobarCarrito();
                redireccionesConectado();
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
async function interaccionesControlador() {
  requerimientosComunes()
    .then(() => {
      console.log("Entro otro bloque");
      if (window.location.pathname.includes("tienda.html")) {

        imprimirProductos();

      }
      else if (window.location.pathname.includes("registro.html")) {
        try {
          document.getElementById("pass").addEventListener("blur", async function () {
              let pass = await passIguales();
              imprimirIgualdadPass(pass);
          });

          document.getElementById("pass2").addEventListener("blur", async function () {
              let pass = await passIguales();
              imprimirIgualdadPass(pass);
          });
          //Si hay un submit  comprobaremos las pass primero y luego el resto de inputs enviamos al controladorUsuario
          //para que conecte con las distintas funciones del modelo y de tener errores llamaremos a funciones de la Vista.
          document.getElementById("formulario").addEventListener("submit", async function (e) {
              e.preventDefault();
              let pass = await passIguales();
              if(pass){
                const objetoComprobaciones = await recepcionDeDatosUsuario();
                if(objetoComprobaciones!=null){
                  imprimirTodosResultados(objetoComprobaciones);
                }
                else{
                  location.href="./tienda.html";
                }
              }
              else{
                imprimirIgualdadPass(pass);
              }
             
          });
        }catch (error) {
          //Por aquí veremos el error para depurar
          //console.log(error);
        }


      }
      //comprobar que hay submit y si lo hay ver que recibimos y hacer todas las comparaciones.

    })
}
interaccionesControlador();
