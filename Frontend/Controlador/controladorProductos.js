/**
 * @file Este script se encargará de controlar lo relacionado con producto y carrito
 * @description Este script conectará a funciones de la BBDD y otras como de busqueda relacionadas con los productos
 * @author Juan Carlos Rodríguez Miranda.
 * @version 1.0.0
*/

import { resultadoBusqueda, filtroLateral } from "../Modelo/funcionesBusqueda.js";
import { rellenarCarritoUsuario,datosProducto,filtradoEstrellas,creacionObjetoCarrito} from "../Modelo/funcionesProducto.js";
import { getProductos,verComentarios,agregarComentarios,agregarCarrito, recuperarCarrito } from "../Modelo/peticiones.js";
import { comprobarRegex,usuarioConectado } from "../Modelo/comprobaciones.js";


export function recepcionDeDatosProducto() {
    return new Promise(async(resolve, reject) => {
        
        const idProducto=sessionStorage.getItem("productoSeleccionado");
        const productos=JSON.parse(sessionStorage.getItem("productos"));
        const resultado= datosProducto(idProducto,productos);
        resolve(resultado);
    })


}

export function recepcionDeComentarios() {
    return new Promise(async(resolve, reject) => {
        const idProducto=sessionStorage.getItem("productoSeleccionado");
        const resultado=await verComentarios(idProducto);
        resolve(resultado);
    })
}

export function objetoCarrito() {
    return new Promise(async(resolve, reject) => {
        let producto = sessionStorage.getItem("productoSeleccionado")
        let cantidadProducto = parseInt(document.getElementById("cantidad").value) //PONER VALORES REGOGIDOS BBDD;
       const respuesta=creacionObjetoCarrito(producto,cantidadProducto);
       if(sessionStorage.getItem("usuario")){
        let usuario=JSON.parse(atob(sessionStorage.getItem("usuario")));
        console.log(respuesta);
        agregarCarrito(respuesta,usuario[0]);
        resolve(respuesta);
       } 
       else{
         resolve(respuesta);
       }
      
    })
}
export function comprobarCarrito(){
    return new Promise(async(resolve, reject) => {
        //carrito vacio
        let usuario=JSON.parse(atob(sessionStorage.getItem("usuario")));
        let datosCarrito= await recuperarCarrito(usuario);
        if(datosCarrito.carrito){
            
            rellenarCarritoUsuario(datosCarrito.carrito);
        }
        usuarioConectado();
        resolve();
    });
}
export function envioDeComentarios() {
    return new Promise(async(resolve, reject) => {
        let datosComentario = new FormData(document.getElementById("formEnvioComentario"));
        let datos= comprobarRegex(datosComentario.get("comentarioTexto"));
        
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
            blabla();
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