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
import { passIguales, recepcionDeDatosUsuario, datosUsuario,comprobarAccion, comprobarAccionModificacion, comprobarAccionEliminacion, cambiarPass, cerrarSesion  } from "./controladorUsuario.js";
import {
  activarZonaUsuario, funcionalidadModificarDatos, funcionalidadCompra, recorrerTotalProducto, funcionalidadTienda, imprimirCarrito, imprimirCarritoVacio,
  imprimirDatosUsuarioCarrito, funcionalidadInicioSesion, imprimirIniciarSesion, cantidadDetalle, imprimirComentarios, imprimirFiltradoEstrellas,
  imprimirImagenesAzar, imprimirDetalleProducto, imprimirIgualdadPass, imprimirTodosResultados, imprimirProductos, mostrarResultadoBusqueda,
  mostrarResultadoAside, imprimirConectadoRegistro, imprimirConectadoLogin, borrarDelCarrito, cantidadDetalleClase, imprimirNoticias, imprimirDatosUsuarioPerfil, exitoCambioPass
} from "../Vistas/plantillasEspecificas.js";
import { datosBorrarProducto, comprobarCarrito, objetoCarrito, datosLupa, datosFiltroLateral, recepcionDeDatosProducto, recepcionDeComentarios, recepcionDeFiltro, envioDeComentarios } from "./controladorProductos.js";
import { eliminacion, lista, modificaciones, noticia } from "./controladorListasNoticias.js";
import { redireccionLista } from "../Vistas/plantillaListas.js";
import { accesoListadosModificado } from "../Modelo/peticiones.js";
import { modificacionCorrecta } from "../Vistas/plantillaModificaciones.js";
import { eliminacionCorrecta } from "../Vistas/plantillaBorrar.js";




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
            //Mensaje de bienvenida
            mostrarUsuario();
            //En las listas saldrán las distintas opciones según el rol que tengas.
            acciones();
            document.getElementById("lista").addEventListener("click", function (e) {
            
              redireccionLista(e.target.id);
              
            });
            //Mostraremos cantidad en el carrito.
            mostrarCantidadCarrito();
            //Cambiaremos los distintos elementos del DOM una vez que ya hay un usuario
            redireccionesConectado();

          });
        }
        //si estan las dos quiere decir que ya sea conectado y haremos el resto de las acciones
        if (sessionStorage.getItem("usuario") && sessionStorage.getItem("conectado")) {

          //Mensaje de bienvenida
          mostrarUsuario();
          //En las listas saldrán las distintas opciones según el rol que tengas.
          acciones();
          document.getElementById("lista").addEventListener("click", function (e) {
            
            redireccionLista(e.target.id);
            
          });
          
          
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
              if (objetoComprobaciones != undefined) {
                imprimirTodosResultados(objetoComprobaciones);
              }
              else {
                location.href = "./tienda.html";
              }
            }
          });

          document.getElementById("registro").addEventListener("click",function(){
            location.href="./registro.html";
          })
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
                //hay que comprobar si se ha hecho bien
                location.href = "./carrito.html";
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
                    
                    imprimirComentarios(respuesta);
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
      /*********************************************************************************************************************************/
      /************************  ZONA CARRITO ******************************************************************************************/
      /******************************************************************************************************************************* */
      else if (window.location.pathname.includes("carrito.html")) {
        //Primero comprobamos si existe carrito.
        if (sessionStorage.getItem("carrito")) {
          imprimirCarrito();
          recorrerTotalProducto();

          document.getElementById("containerProductos").addEventListener("click", function (e) {

            if (e.target.classList.contains("cruz")) {

              let producto = e.target.parentNode;
              datosBorrarProducto(producto.id).then(respuesta => {
                if (respuesta) {
                  borrarDelCarrito(producto);
                  mostrarCantidadCarrito();
                }
              });
            }
            else if (e.target.classList.contains("inputCantidad")) {

              let producto = e.target.parentNode;
              e.target.addEventListener("input", cantidadDetalleClase(producto));

            }
          })
          //Si se hace click en cantidad busco el padre y luego uso children para escoger precio y precioTotal.




          document.getElementById("comprar").addEventListener("click", function () {
            funcionalidadCompra();
          })
        } else {

          imprimirCarritoVacio();


        }

        //Por otro lado comprobar si esta usuario.
        if (sessionStorage.getItem("usuario")) {
          //Siempre llamo a la base de datos o no?

          activarZonaUsuario();
          datosUsuario().then(respuesta => {
            imprimirDatosUsuarioCarrito(respuesta);
          
              document.getElementById("modificar").addEventListener("click", function (e) {
                const arrayDatos=[]
                const datos =e.target.parentNode.children;
                for(let dato of datos){
                 if(dato.tagName=="DIV"){
                   arrayDatos.push(dato.children[1].textContent);
                 }
                  
                }
                arrayDatos.push("Perfil");
                localStorage.setItem("modificar",JSON.stringify(arrayDatos));
               location.href="./modificar.html";
             })

          })

        }
        else {
          imprimirIniciarSesion();
          document.getElementById("login").addEventListener("click", function () {
            funcionalidadInicioSesion();
          })
        }
      }
      /*********************************************************************************************************************************/
      /************************  ZONA NOTICIAS ******************************************************************************************/
      /******************************************************************************************************************************* */
      else if (window.location.pathname.includes("noticias.html")) {
        noticia().then(respuesta => {
          imprimirNoticias(respuesta);

        });
      }
      /*********************************************************************************************************************************/
      /************************  ZONA LISTAS ******************************************************************************************/
      /******************************************************************************************************************************* */
      else if (window.location.pathname.includes("listas.html")) {
        comprobarAccion().then(async respuesta =>{
          
          if(respuesta.errores || typeof Object.values(respuesta)[0] == "boolean"){
            alert("Hubo algún error vuelva a iniciar sesión");
            sessionStorage.removeItem("usuario");
            location.href="./login.html";
          }else{

            lista(respuesta);
          }

        }).catch( respuesta =>{
          alert("Hubo algún error vuelva a iniciar sesión");
          sessionStorage.removeItem("usuario");
          location.href="./login.html";
        })

        document.getElementById("listado").addEventListener("click", function (e){
          //En una función
          let array=[];
          let elementosFila=e.target.parentNode.parentNode.children;
          if(e.target.textContent=="Modificar" && e.target.tagName=="BUTTON"){
            for(let i=0;i<elementosFila.length -2; i++){
              array.push(elementosFila[i].textContent);
            }
            const datosUrl = new URLSearchParams(window.location.search);
            //Zona ha mejorar 
            /**Hago esto para cuando se entre en el controladorlistasNoticias sepa a que funcion de la plantilla debe de ir. */
            array.push(datosUrl.entries().next().value[1]);
            //Uso localSotarege porque sesion a veces no funciona correctamente.
           
            localStorage.setItem("modificar",JSON.stringify(array));
            location.href="./modificar.html";
          }
          
        });

        document.getElementById("listado").addEventListener("click", function (e){
          //En una función
          let array=[];
          let elementosFila=e.target.parentNode.parentNode.children;
          if(e.target.textContent=="Eliminar" && e.target.tagName=="BUTTON"){
            const datosUrl = new URLSearchParams(window.location.search);
            let direccion=datosUrl.entries().next().value[1];
            //Es el único que necesita más de un ID
            if(direccion =="Lista comentarios"){
              array.push(elementosFila[3].textContent);
              array.push(elementosFila[4].textContent);
            }else if(direccion=="Lista permisos"){
              array.push(elementosFila[0].textContent);
              array.push(elementosFila[5].textContent);
            }
            else{
              array.push(elementosFila[0].textContent);
            }
           
            //Zona ha mejorar 
            /**Hago esto para cuando se entre en el controladorlistasNoticias sepa a que funcion de la plantilla debe de ir. */
            array.push(direccion);
            //Uso localSotarege porque sesion a veces no funciona correctamente.
            localStorage.setItem("eliminar",JSON.stringify(array));
            location.href="./borrar.html";
          }
          
        });
      }
      /*********************************************************************************************************************************/
      /************************  ZONA MODIFICAR ******************************************************************************************/
      /******************************************************************************************************************************* */
      else if (window.location.pathname.includes("modificar.html")) {
        const arrayDatos=JSON.parse(localStorage.getItem("modificar"));
        if(arrayDatos!=null){
          modificaciones(arrayDatos);
        }
        else{
          alert("Hubo algún error vuelva a iniciar sesión");
          sessionStorage.removeItem("usuario");
          localStorage.removeItem("modificar");
          location.href="./login.html";
        }
        
        
        document.getElementById("formulario").addEventListener("submit",function(e){
          e.preventDefault();
          comprobarAccionModificacion().then(respuesta => {
            if(respuesta.errores || respuesta.errorBBDD || typeof Object.values(respuesta)[0] == "boolean"){
            
                imprimirTodosResultados(respuesta);
            }
            else{
                
                modificacionCorrecta(respuesta);
            }
            
          });
          
          
        })
        //Remove da problemas
        localStorage.removeItem("modificar");
      }
      /*********************************************************************************************************************************/
      /************************  ZONA ELIMINAR ******************************************************************************************/
      /******************************************************************************************************************************* */
      else if (window.location.pathname.includes("borrar.html")) {
        const arrayDatos=JSON.parse(localStorage.getItem("eliminar"));
        if(arrayDatos!=null){
          eliminacion(arrayDatos);
        }
        else{
          alert("Hubo algún error vuelva a iniciar sesión");
          sessionStorage.removeItem("usuario");
          localStorage.removeItem("eliminar");
          location.href="./login.html";
        }

        document.getElementById("formulario").addEventListener("submit",function(e){
          e.preventDefault();
          comprobarAccionEliminacion().then(respuesta => {
            console.log(respuesta);
            if(respuesta.errores || respuesta.errorBBDD || typeof Object.values(respuesta)[0] == "boolean"){
              alert("Hubo algún error vuelva a iniciar sesión");
              sessionStorage.removeItem("usuario");
              localStorage.removeItem("eliminar");
              //location.href="./login.html";
                
            }
            else{
                eliminacionCorrecta(respuesta);
            }
          });
          
          
        })
        //Remove da problemas
        localStorage.removeItem("eliminar");
      }
    /*********************************************************************************************************************************/
      /************************  ZONA AÑADIR ******************************************************************************************/
      /******************************************************************************************************************************* */
      else if (window.location.pathname.includes("agregar.html")) {
        
          //tengo que sabe que voy a agregar y poner el formulrio correspondiente
          //haremos click en submit y nos iremos a la peticion, tras comprobar todo 
          //iremos a php donde comprobaremos de nuevo todo y agregaremos lo que sea
          //USUARIO,PRODUCTO,PERMISO,ROL,NOTICIA
          
        }
        //Remove da problemas
      
    
    /*********************************************************************************************************************************/
      /************************  ZONA PERFIL ******************************************************************************************/
      /******************************************************************************************************************************* */
      else if (window.location.pathname.includes("perfil.html")) {
        if (sessionStorage.getItem("usuario")) {
          //Siempre llamo a la base de datos o no?

          
          datosUsuario().then(respuesta => {
            imprimirDatosUsuarioPerfil(respuesta);
            document.getElementById("modificar").addEventListener("click", function (e) {
               const arrayDatos=[]
               const datos =e.target.parentNode.children;
               for(let dato of datos){
                if(dato.tagName=="DIV"){
                  arrayDatos.push(dato.children[1].textContent);
                }
                 
               }
               arrayDatos.push("Perfil");
               localStorage.setItem("modificar",JSON.stringify(arrayDatos));
               console.log(arrayDatos);
               location.href="./modificar.html";
            });
            document.getElementById("sesion").addEventListener("click", function (e) {
              cerrarSesion().then(respuesta => {
                console.log(respuesta);
                if(!respuesta){

                }else{
                  sessionStorage.removeItem("usuario");
                location.href="./tienda.html";
                }
              });
           });
            document.getElementById("eliminar").addEventListener("click", function (e) {
              const arrayDatos=["Perfil"]
              arrayDatos.push("Perfil");
              localStorage.setItem("eliminar",JSON.stringify(arrayDatos));
              location.href="./borrar.html";
           });

          });
          document.getElementById("pass").addEventListener("blur", async function () {
            let pass = await passIguales();
            imprimirIgualdadPass(pass);
          });

          document.getElementById("pass2").addEventListener("blur", async function () {
            let pass = await passIguales();
            imprimirIgualdadPass(pass);
          });

          document.getElementById("cambiarPass").addEventListener("submit",async function (e) {
            e.preventDefault();
            let resultado=await cambiarPass();
            if(resultado.exito){
                exitoCambioPass();
            }else{
              imprimirTodosResultados(resultado);
            }
         })

        }
      }
    });
}
interaccionesControlador();

