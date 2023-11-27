/**
 * @file Este script controlará las interacciones entre usuario y aplicación.
 * @description Este script controla la interaccion de datos tanto entre la vista y el modelo
 * como entre distintos controladores, haciendo este su punto de unión.
 * @author Juan Carlos Rodríguez Miranda.
 * @version 1.0.0
*/


//Importaciones necesarias para el funcionamiento de controlador.js
import { imprimirCabezera,mostrarUsuario,acciones,redireccionesConectado } from "../Vistas/plantillaGeneral.js";
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
            //Tras tener nuestra plantilla y los datos que necesitamos comprobamos si esta conectado el usuario
           if(sessionStorage.getItem("usuario")){
                //pondremos lo siguiente.
            
                mostrarUsuario();
                acciones();
               // comprobarCarrito();
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
      //
      if (window.location.pathname.includes("tienda.html")) {

        imprimirProductos();
        //Implementación busqueda

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
              let usuario=false;
              let pass = await passIguales();
              if(usuario){
                //Aviso de que ya esta con inicio de sesión que desconecte primero.
                
              }
              else if(pass){
                
                const objetoComprobaciones = await recepcionDeDatosUsuario("Registro");
                
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
          console.log(error);
        }


      }
      else if (window.location.pathname.includes("login.html")) {
        try {
          
          
          document.getElementById("formulario").addEventListener("submit", async function (e) {
              e.preventDefault();
              let usuario=false;
              if(usuario){

              }
              else{
                const objetoComprobaciones = await recepcionDeDatosUsuario("Usuario");
                if(objetoComprobaciones!=null){
                  imprimirTodosResultados(objetoComprobaciones);
                }
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
