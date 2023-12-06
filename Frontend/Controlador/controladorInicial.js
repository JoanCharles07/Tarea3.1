/**
 * @file Este script se encargará de las funciones de ambito general.
 * @description Este script realizará funciones generales entre las que se encuentran un reconocimiento de
 * login, comprobación de que los datos de productos se encuentran disponibles
 * @author Juan Carlos Rodríguez Miranda.
 * @version 1.0.0
*/

import{getProductos}from "../Modelo/peticiones.js";
/**
 * Esta función comprobará si tenemos en el sessionStorage lo productos, si no los tenemos hará una llamada a la
 * base de datos para recuperarlos, esto será asincrono por lo que usaremos async await para esperar la respuesta
 * de la BBDD antes de continuar.
 * 
 */
export function comprobarProductos() {
    return new Promise(async(resolve, reject) => {
        //Comprobamos si no existe los productos para que siempre esten en nuestra sesión y podamos usarlo correctamente.
        
        try{
            if(!sessionStorage.getItem("productos")){
                //Llamamos a la base de datos y esperamos a que termine.
                const Productos=await getProductos();
                sessionStorage.setItem("productos",JSON.stringify(Productos));
                resolve();
            }else{  
                
                resolve();
            }  
        }catch(e){
            
            reject(e);
        }
         

    });
}

//enviar a opción de lupa



