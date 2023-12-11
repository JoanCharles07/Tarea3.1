/**
 * @file Este script se encargará de las funciones de ambito general.
 * @description Este script realizará funciones generales entre las que se encuentran un reconocimiento de
 * login, comprobación de que los datos de productos se encuentran disponibles
 * @author Juan Carlos Rodríguez Miranda.
 * @version 1.0.0
*/

import{recuperarNoticias}from "../Modelo/peticiones.js";
import { imprimirListaComentarios ,imprimirListaPermisos,imprimirListaProductos,imprimirListaRoles,imprimirListaUsuarios} from "../Vistas/plantillaListas.js";
/**
 * Esta función comprobará si tenemos en el sessionStorage lo productos, si no los tenemos hará una llamada a la
 * base de datos para recuperarlos, esto será asincrono por lo que usaremos async await para esperar la respuesta
 * de la BBDD antes de continuar.
 * @see getProductos Se enncarga de la petición al servidor de todos los productos.
 * 
 */
export function noticia() {
    return new Promise(async(resolve, reject) => {
        //Comprobamos si no existe los productos para que siempre esten en nuestra sesión y podamos usarlo correctamente.
        
        try{
            const respuesta=recuperarNoticias();
                resolve(respuesta);
            
        }catch(e){
            
            reject(e);
        }
         

    });
}

export function lista(datos) {
   
        //Comprobamos que parametro entra y nos enviará a la vista correspondiente.
        console.log(datos);
        try{
            if(datos.comentarios){
                imprimirListaComentarios(datos);
            }
            else if(datos.usuarios){
                imprimirListaUsuarios(datos);
            }
            else if(datos.roles){
                imprimirListaRoles(datos);
            }
            else if(datos.productos){
                imprimirListaProductos(datos);
            }
            else if(datos.permisos){
                imprimirListaPermisos(datos);
            }
            else{
                console.log("o aqui");
            }

        }catch(e){
            
        }
         

  
}
