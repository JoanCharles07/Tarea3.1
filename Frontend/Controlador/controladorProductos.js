/**
 * @file Este script se encargará de controlar lo relacionado con producto y carrito
 * @description Este script conectará a funciones de la BBDD y otras como de busqueda relacionadas con los productos
 * @author Juan Carlos Rodríguez Miranda.
 * @version 1.0.0
*/

import { resultadoBusqueda, filtroLateral } from "../Modelo/funcionesBusqueda.js";

export function recepcionDeDatosProductos() {
    return new Promise((resolve, reject) => {

    })


}

export function datosLupa(palabraBuscador) {
    return new Promise(async (resolve, reject) => {
        if (sessionStorage.getItem("productos")) {
            let resultado = await resultadoBusqueda(palabraBuscador);

            resolve(resultado);
        }
        else {
            location.reload();
        }
    });
}

export function datosFiltroLateral() {
        return new Promise(async (resolve, reject) => {
            
                let resultado = await filtroLateral();
                resolve(resultado);
            

        })

    }