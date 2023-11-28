/**
 * @file Este script se encargará de controlar lo relacionado con producto y carrito
 * @description Este script conectará a funciones de la BBDD y otras como de busqueda relacionadas con los productos
 * @author Juan Carlos Rodríguez Miranda.
 * @version 1.0.0
*/

import { resultadoBusqueda, filtroLateral } from "../Modelo/funcionesBusqueda.js";
import { datosProducto} from "../Modelo/funcionesProducto.js";
import { getProductos } from "../Modelo/peticiones.js";


export function recepcionDeDatosProducto() {
    return new Promise(async(resolve, reject) => {
        const resultado=await datosProducto();
        resolve(resultado);
    })


}
/**
 * Esta función recibe la palabra del buscador lupa y tras confirmar que existe en la sessionStorage de productos, llama
 * a la función resultadoBusqueda donde se realizará la parte lógica y devolverá array con la respuesta.
 * @param {String} palabraBuscador será el texto que buscaremos en el nombre de nuestros productos.
 * @see resultadoBusqueda
 * @see getProductos
 * @returns {Promise} con el array donde estarán los ids de los productos que coincidan con la palabra.
 */
export function datosLupa(palabraBuscador) {
    return new Promise(async (resolve, reject) => {
        if(!sessionStorage.getItem("productos")){
            const Productos=await getProductos();
            sessionStorage.setItem("productos",JSON.stringify(Productos));
            
        }   
            let resultado = await resultadoBusqueda(palabraBuscador);

            resolve(resultado);
        
        
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