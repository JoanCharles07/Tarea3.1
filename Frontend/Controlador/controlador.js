/**
 * @file Este script controlará las interacciones entre usuario y aplicación.
 * @description Este script controla la interaccion de datos tanto entre la vista y el modelo
 * como entre distintos controladores, haciendo este su punto de unión.
 * @author Juan Carlos Rodríguez Miranda.
 * @version 1.0.0
*/


//Importaciones necesarias para el funcionamiento de controlador.js
import { imprimirCabezera, mostrarUsuario, acciones, redireccionesConectado, mostrarCantidadCarrito } from "../Vistas/plantillaGeneral.js";
import { comprobarProductos } from "./controladorInicial.js";
import { passIguales, recepcionDeDatosUsuario } from "./controladorUsuario.js";
import { cantidadDetalle, imprimirComentarios, imprimirFiltradoEstrellas, imprimirImagenesAzar, imprimirDetalleProducto, imprimirIgualdadPass, imprimirTodosResultados, imprimirProductos, mostrarResultadoBusqueda, mostrarResultadoAside, imprimirConectadoRegistro, imprimirConectadoLogin } from "../Vistas/plantillasEspecificas.js";
import { comprobarCarrito, objetoCarrito, datosLupa, datosFiltroLateral, recepcionDeDatosProducto, recepcionDeComentarios, recepcionDeFiltro, envioDeComentarios } from "./controladorProductos.js";



/**
 * Esta función nos aseguraremos con la promesa que se ejecute antes que cualquier otra cosa.
 * Crearemos las promesas necesarias de todas las funciones que queremos que se ejecuten antes de empezar.
 * @returns Devuelve el resultado de la promesa
 */
function requerimientosComunes() {
  return new Promise((resolve, reject) => {
    try {
      //En estas dos promesosas nos aeguraremos de imprimir la cabezera de nuestra página(header/nav)
      const Promesa1 = imprimirCabezera();
      //Comprobue que tengamos en sessionStorage los productos
      const Promesa2 = comprobarProductos();
      //Antes de hacer nada más debemos completar las promesas anteriores.
      Promise.all([Promesa1, Promesa2]).then(respuestas => {
        //Tras tener nuestra plantilla y los datos que necesitamos comprobamos si esta conectado el usuario
        if (sessionStorage.getItem("usuario") && !sessionStorage.getItem("conectado")) {
          //Si no esta conectado quiere decir que es la primera vez y comprobaremos el carrito del usuario en la BBDD
          comprobarCarrito().then(respuesta => {
            //Mostramos cantidad en el carrito
            mostrarCantidadCarrito();

          });
        }
        //si estan las dos quiere decir que ya sea conectado y haremos el resto de las acciones
        if (sessionStorage.getItem("usuario") && sessionStorage.getItem("conectado")) {

          //Mensaje de bienvenida
          mostrarUsuario();
          //En las listas saldrán las distintas opciones según el rol que tengas.
          acciones();
          //Mostraremos cantidad en el carrito.
          mostrarCantidadCarrito();
          //Cambiaremos los distintos elementos del DOM una vez que ya hay un usuario
          redireccionesConectado();
        }
        //Si no esta el usuario solo mostraremos cantidad carrito del usuario anonimo.
        else {
          mostrarCantidadCarrito();
        }

        //FALTAN CLICK EN LAS DISTINTAS ACCIONES//

        //una vez concluido resolveremos la promesa.
        resolve();

      })
    } catch (error) {
      reject(error);
    }
  });

}
/**
 * Esta función se encargará de activar las distintas funciones según la vista en la que este.
 * Pero primero realizará una promesa para que se ejecuten todas las acciones comunes.
 *  
 * @throws(error)Saltará si alguna de las promesas no puede llevar a cabo su función.
 */
async function interaccionesControlador() {
  //llamada a la primera función y si se completa seguiremos con el resto.
  requerimientosComunes()
    .then(() => {
      /*********************************************************************************************************************************/
      /************************  ZONA TIENDA ******************************************************************************************/
      /******************************************************************************************************************************* */
      //Manejo dentro de la url tienda.html
      if (window.location.pathname.includes("tienda.html")) {
        //Implementación busqueda dentro de tienda.html
        //comprobar si hay una busqueda. Y usamos controlador productos para enviar las distintas respuestas
        imprimirProductos();

        //Comprobamos si existe busqueda,de existir quiere decir que alguien ha iniciado busqueda desde otra vista.
        if (sessionStorage.getItem("busqueda")) {

          datosLupa().then(respuesta => {
            mostrarResultadoBusqueda(respuesta);
          });
        }
        //Si se hace click en lupa tambien iniciaremos la busqueda.
        document.getElementById("lupa").addEventListener("click", async function () {

          const resultado = await datosLupa();
          mostrarResultadoBusqueda(resultado);
        });
        //Filtrado lateral.
        document.querySelector("aside").addEventListener("click", async function () {
          const resultado = await datosFiltroLateral();
          mostrarResultadoAside(resultado.array, resultado.contador);
        });

      }
      /*********************************************************************************************************************************/
      /************************  ZONA REGISTRO ******************************************************************************************/
      /******************************************************************************************************************************* */
      else if (window.location.pathname.includes("registro.html")) {

        try {
          //Comprobamos que coincidan las contraseñas para dar información visual al usuario de que son iguales
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
            //Si esta conectado no dejaremos que se registre de nuevo salvo que cierre sesión.
            if (sessionStorage.getItem("usuario")) {
              imprimirConectadoRegistro();
            }
            // Si pass es correcto encontes enviaremos los datos proporcionados para iniciar registrp
            else if (pass) {
              const objetoComprobaciones = await recepcionDeDatosUsuario("Registro");
              //Si hay algun error el metodo imprimirTodosResultados los mostrará al usuario
              if (objetoComprobaciones != null) {
                imprimirTodosResultados(objetoComprobaciones);
              }
              //Si ha sido un exito rediccionaremos a tienda.html.
              else {
                location.href = "./tienda.html";
              }
            }
            //En caso de que no coincidan las contraseñas lo mostrará por pantalla.
            else {
              imprimirIgualdadPass(pass);
            }

          });
        } catch (error) {
          //Por aquí veremos el error para depurar
          //console.log(error);
        }


      }
      /*********************************************************************************************************************************/
      /************************  ZONA LOGIN ******************************************************************************************/
      /******************************************************************************************************************************* */
      else if (window.location.pathname.includes("login.html")) {
        try {


          document.getElementById("formulario").addEventListener("submit", async function (e) {
            e.preventDefault();
            //Si esta conectado no permitiremos que se vuelva a logear salvo que cierre sesión
            if (sessionStorage.getItem("usuario")) {
              imprimirConectadoLogin();
            }
            //Comprobaremos que no haya errores si hay los mostraremos por pantalla y si todo es correcto redireccion a tienda.html
            else {
              const objetoComprobaciones = await recepcionDeDatosUsuario("Usuario");
              console.log(objetoComprobaciones);
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
      /*********************************************************************************************************************************/
      /************************  ZONA DETALLE PRODUCTO ******************************************************************************************/
      /******************************************************************************************************************************* */
      else if (window.location.pathname.includes("detalleProducto.html")) {
        //Antes de continuar nos aseguramos que productoSeleccionado esta en nuestra sessionStorage.
        if (sessionStorage.getItem("productoSeleccionado")) {
          //Conseguimos los datos del productoSelccionado
          recepcionDeDatosProducto().then((resultado) => {
            //Lo imprimimos
            imprimirDetalleProducto(resultado);
            //Cambiamos datos del total si se utiliza el input de cantidad
            document.getElementById("cantidad").addEventListener("input", function () {
              cantidadDetalle();
            });
            //Si damos a comprar añadiremos el producto al carrito y mostraremos el nuevo producto en
            //nuestro carrito
            document.getElementById("validar").addEventListener("click", function () {
              objetoCarrito().then(respuesta => {

                mostrarCantidadCarrito();
              })

            });
          });
          //Esta función nos motrará las imagenes al azar para dar otras opciones a los usuarios.
          imprimirImagenesAzar();

          //Comprobamos los comentarios y mostramos el resultado
          recepcionDeComentarios().then(resultado => {

            imprimirComentarios(resultado);
            //Manejo del filtro de valoración que nos mostrará los comentarios según las estrellas que escojamos
            document.getElementById("filtroValoracion").addEventListener("click", function (e) {
              recepcionDeFiltro(e.target.id).then(filtro => {
                if (filtro != "") {
                  imprimirFiltradoEstrellas(filtro);
                }
              })
            })

          })


          //Envio del comentario y valoración del producto tendrá en cuenta si el usuario esta conectado o no
          document.getElementById("formEnvioComentario").addEventListener("submit", function (e) {
            e.preventDefault();
            if (sessionStorage.getItem("usuario")) {
              envioDeComentarios().then(respuesta => {
                //Si todo es correcto habrá respuesta.comentario
                if (respuesta.comentario) {
                  recepcionDeComentarios().then(respuesta => {
                    imprimirComentarios(respuesta.datosComentarios);
                  })
                } 
                //En caso contrario mostraremos los errores.
                else {
                  
                  imprimirTodosResultados(respuesta);
                }
              });
            }
            else {
              console.log("Debes conectarte para comentar");
            }
          });
          //Si no existe productoSeleccionado redireccionamos a tienda.html para que pueda conseguirlo
        } else {
          location.href = "tienda.html";
        }

      }

    });
}
interaccionesControlador();