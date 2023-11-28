/**
 * @file Este script controlará las interacciones entre usuario y aplicación.
 * @description Este script controla la interaccion de datos tanto entre la vista y el modelo
 * como entre distintos controladores, haciendo este su punto de unión.
 * @author Juan Carlos Rodríguez Miranda.
 * @version 1.0.0
*/


//Importaciones necesarias para el funcionamiento de controlador.js
import { imprimirCabezera, mostrarUsuario, acciones, redireccionesConectado } from "../Vistas/plantillaGeneral.js";
import { comprobarProductos } from "./controladorInicial.js";
import { passIguales, recepcionDeDatosUsuario } from "./controladorUsuario.js";
import { imprimirDetalleProducto,imprimirIgualdadPass, imprimirTodosResultados, imprimirProductos, mostrarResultadoBusqueda, mostrarResultadoAside, imprimirConectadoRegistro, imprimirConectadoLogin } from "../Vistas/plantillasEspecificas.js";
import { datosLupa, datosFiltroLateral, recepcionDeDatosProducto } from "./controladorProductos.js";

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
        if (sessionStorage.getItem("usuario")) {
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

      if (window.location.pathname.includes("tienda.html")) {
        //Implementación busqueda dentro de tienda.html
        //comprobar si hay una busqueda. Y usamos controlador productos para enviar las distintas respuestas
        imprimirProductos();
        //Si existe es que alguien ha iniciado una busqueda
        //NO PODEMOS INICIAR BUSQUEDA SI ALGUIEN HA BORRADO PRODUCTOS

        if (sessionStorage.getItem("busqueda")) {
          let palabraBuscador = sessionStorage.getItem("busqueda");
          sessionStorage.removeItem("busqueda");
          datosLupa(palabraBuscador).then(respuesta => {
            mostrarResultadoBusqueda(respuesta);
          });


        }
        document.getElementById("lupa").addEventListener("click", async function () {
          let palabraBuscador = document.getElementById("buscador").value
          console.log(palabraBuscador);
          const resultado = await datosLupa(palabraBuscador);
          mostrarResultadoBusqueda(resultado);
        });

        document.querySelector("aside").addEventListener("click", async function () {
          const resultado = await datosFiltroLateral();
          mostrarResultadoAside(resultado.array, resultado.contador);
        });

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
            let usuario = false;
            let pass = await passIguales();
            if (sessionStorage.getItem("usuario")) {
              imprimirConectadoRegistro();
            }
            else if (pass) {
              const objetoComprobaciones = await recepcionDeDatosUsuario("Registro");
              if (objetoComprobaciones != null) {
                imprimirTodosResultados(objetoComprobaciones);
              }
              else {
                location.href = "./tienda.html";
              }
            }
            else {
              imprimirIgualdadPass(pass);
            }

          });
        } catch (error) {
          //Por aquí veremos el error para depurar
          console.log(error);
        }


      }
      else if (window.location.pathname.includes("login.html")) {
        try {


          document.getElementById("formulario").addEventListener("submit", async function (e) {
            e.preventDefault();
            if (sessionStorage.getItem("usuario")) {
              imprimirConectadoLogin();
            }
            else {
              const objetoComprobaciones = await recepcionDeDatosUsuario("Usuario");
              if (objetoComprobaciones != null) {
                imprimirTodosResultados(objetoComprobaciones);
              }
              else {
                location.href = "./tienda.html";
              }
            }
          });
        } catch (error) {
          //Por aquí veremos el error para depurar
          //console.log(error);
        }


      }

      else if(window.location.pathname.includes("detalleProducto.html")){
        //Antes de continuar nos aseguramos que productoSeleccionado esta en nuestra sessionStorage.
        if (sessionStorage.getItem("productoSeleccionado")) {
              recepcionDeDatosProducto().then(resultado => {
                  console.log(resultado);
                  imprimirDetalleProducto(resultado);
              });
        }
        else{
            location.href="tienda.html";
        }
      }
     

    })
}
interaccionesControlador();
