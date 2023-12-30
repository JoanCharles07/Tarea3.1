/**
 * @file Este script se encargará de controlar lo relacionado con producto y carrito
 * @description Este script conectará a funciones de la BBDD y otras como de busqueda relacionadas con los productos
 * @author Juan Carlos Rodríguez Miranda.
 * @version 1.0.0
*/

import { resultadoBusqueda, filtroLateral,filtradoEstrellas } from "../Modelo/funcionesBusqueda.js";
import { rellenarCarritoUsuario,datosProducto,creacionObjetoCarrito,borrarProductoSesion, comprobarStockJS} from "../Modelo/funcionesProducto.js";
import { borrarDelCarritoBBDD,getProductos,verComentarios,agregarComentarios,agregarCarrito, recuperarCarrito, comprobarStock, finalizarCompraBBDD } from "../Modelo/peticiones.js";
import { comprobarRegexComentarios,usuarioConectado } from "../Modelo/comprobaciones.js";

/**
 * Esta función llama a la funcion datosProductos que devolverá una promesa.
 * @see datoProducto
 * @returns Object con los resultados de los productos que tenemos en la base de datos.
 */
export function recepcionDeDatosProducto() {
    return new Promise(async(resolve, reject) => {
        
        const idProducto=sessionStorage.getItem("productoSeleccionado");
        const productos=JSON.parse(sessionStorage.getItem("productos"));
        const resultado= datosProducto(idProducto,productos);
        resolve(resultado);
    })


}
/**
 * Esta función  se encargará de llamar a la funcion verComentarios que nos devolverá los comentarios.
 * @see verComentarios
 * @returns Object con los comentarios realizados en este producto si los hubiera
 */
export function recepcionDeComentarios() {
    return new Promise(async(resolve, reject) => {
        const idProducto=sessionStorage.getItem("productoSeleccionado");
        const resultado=await verComentarios(idProducto);
        resolve(resultado);
    })
}

/**
 * Esta función se encarga de seguir los pasos para agregar un objeto a la sesión y a la BBDD si fuera necesario.
 * @see creacionObjetoCarrito
 * @see agregarCarrito hace la petición a la BBDD
 * @returns  Objecto con los datos del producto que vamos  a comprar.
 */
export function objetoCarrito() {
    return new Promise(async(resolve, reject) => {
        //comprobar primero si hay stock, actualizamos productos tras esto.

        let producto = sessionStorage.getItem("productoSeleccionado");
        let cantidadProducto = parseInt(document.getElementById("cantidad").value);
       
        if(comprobarStockJS(producto,cantidadProducto)){
            let resultado = await comprobarStock();
            if(resultado.resultado){
                const respuesta=creacionObjetoCarrito(producto,cantidadProducto);
                if(sessionStorage.getItem("usuario")){
                await agregarCarrito(respuesta);
                resolve(respuesta);
           } 
           else{
             resolve(respuesta);
           }
            }else{
                resolve(resultado);
            }
        }else{
            
            reject("No hay suficiente stock");
        }
       
       
      
    })
}


/**
 * Esta función se encarga de llamar a las funciones necesarias para recuperar los productos que el usuario había cogido en una sesión pasada.
 * @see recuperarCarrito hace petición BBDD que nos dará los productos que tuviera en el carrito el usuario
 * @see rellenarCarritoUsuario rellena la sessionStorage del carrito con los nuevos productos.
 * @see usuarioConectado hace que el usuario aparezca como conectado y ya no entre más a esta función.
 */
export function comprobarCarrito(){
    return new Promise(async(resolve, reject) => {
        //carrito vacio
        console.log("entro aqui")
        let datosCarrito= await recuperarCarrito();
        console.log(datosCarrito)
        if(datosCarrito.carrito){
            
            rellenarCarritoUsuario(datosCarrito.carrito);
        }
        usuarioConectado();
        resolve();
    });
}
/**
 * Esta función controla el envio de un nuevo mensaje en el producto para que se guarde dentro de la BBDD
 * @see comprobarRegex comprobamos que el comentario de texto no incluye nada extraño
 * @returns Object datosServidor con la respuesta del servidor.
 */
export function envioDeComentarios() {
    return new Promise(async(resolve, reject) => {
        let datosComentario = new FormData(document.getElementById("formEnvioComentario"));
        let datos= comprobarRegexComentarios(datosComentario.get("comentarioTexto"));
        
        if(datos==false){
            let datosServidor=agregarComentarios(datosComentario);
            
            resolve(datosServidor);
        }
        else{
            let datosServidor={comentarioTexto:true}
            resolve(datosServidor);
        }
        
    })
}
/**
 * Esta función se encarga de llamar a la función filtradoEstrellas que nos dará la cadena que usaremos para mostrar al usuario los resultados.
 * 
 * @param {String} id Cadena con la cadena que esta dentro del id de la etiqueta clicada.
 * @see filtradoEstrellas con el id se encarga de saber donde hemos hecho click.
 * @returns String resultado del filtradoEstrellas
 */
export function recepcionDeFiltro(id) {
    return new Promise(async(resolve, reject) => {
        
        const filtro= filtradoEstrellas(id);
        resolve(filtro);
    })
}
/**
 * Esta función recibe la palabra del buscador lupa y tras confirmar que existe en la sessionStorage de productos, llama
 * a la función resultadoBusqueda donde se realizará la parte lógica y devolverá array con la respuesta.
 * @see resultadoBusqueda
 * @see getProductos
 * @returns {Promise} con el array donde estarán los ids de los productos que coincidan con la palabra.
 */
export function datosLupa() {
    return new Promise(async (resolve, reject) => {
        //Uso try catch porque es asincrono
        try {
            let resultado ="";
        if(!sessionStorage.getItem("productos")){
            const Productos=await getProductos();
            sessionStorage.setItem("productos",JSON.stringify(Productos));
            resultado = await resultadoBusqueda();
            
        }else{
            resultado = await resultadoBusqueda();
        }
            

            resolve(resultado);
        
        } catch (error) {
            //console.error(error);
           
        }
        
        
    });
}
/**
 * Esta función  comprobará si existe la sessionStorage de productos y una vez que exista llamará a la funcion filtroLateral donde
 * se realizará la lógica que filtrará los resultados segun los checked.
 * @see filtroLateral
 * @see getProductos
 * @returns {Promise} con el array donde estarán los ids de los productos que coincidan con los checked.
 */
export function datosFiltroLateral() {
        return new Promise(async (resolve, reject) => {
            if(!sessionStorage.getItem("productos")){
                const Productos=await getProductos();
                sessionStorage.setItem("productos",JSON.stringify(Productos));
                
            }   

                let resultado = await filtroLateral();
                resolve(resultado);
            

        })

    }

export function datosBorrarProducto(index){
    return new Promise( async(resolve, reject) => {

        let respuesta=await borrarProductoSesion(index);
        if(sessionStorage.getItem("usuario")){
            await borrarDelCarritoBBDD(index);
            resolve(respuesta);
       } 
       else{
         resolve(respuesta);
       }

    });
    
}


export function comprobarCompra() {
    return new Promise(async(resolve, reject) => {
        //comprobar primero si hay stock, actualizamos productos tras esto.
        let producto=sessionStorage.getItem("productoSeleccionado");
        let cantidadProducto=document.getElementById("cantidad").value;
        console.log(cantidadProducto + " " + producto);
        //comprobar en el carrito
        if(comprobarStockJS(producto,cantidadProducto)){
            let resultado = await comprobarStock();
            
            if(resultado.resultado){
                //Segun la respuesta debemos actualizar productos y borrar carrito si todo ha ido bien.
                const respuesta=creacionObjetoCarrito(producto,cantidadProducto);
                if(sessionStorage.getItem("usuario")){
                await agregarCarrito(respuesta);
                resolve(respuesta);
           } 
           else{
             resolve(respuesta);
           }
            }else{
                resolve(resultado);
            }
        }else{
            
            reject("No hay suficiente stock");
        }
       
       
      
    })
}

export function finalizarCompra(){
    return new Promise(async(resolve, reject) => {
        
        let respuesta=await finalizarCompraBBDD();
        console.log(respuesta);
        resolve(respuesta)
    });
}
