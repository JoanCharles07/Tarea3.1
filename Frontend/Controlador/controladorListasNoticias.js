/**
 * @file Este script se encargará de las funciones de ambito general.
 * @description Este script realizará funciones generales entre las que se encuentran un reconocimiento de
 * login, comprobación de que los datos de productos se encuentran disponibles
 * @author Juan Carlos Rodríguez Miranda.
 * @version 1.0.0
*/

import{recuperarNoticias}from "../Modelo/peticiones.js";
import { imprimirListaNotcias,imprimirListaPedidos,imprimirListaComentariosPropio,imprimirListaComentariosGlobal ,imprimirListaPermisos,
    imprimirListaRoles,imprimirListaUsuarios, imprimirEnvios,imprimirHistorial, imprimirListaPedidosUsuario, imprimirListaProductosGlobal, 
    imprimirListaProductosPropio,
    imprimirMensajes} from "../Vistas/plantillaListas.js";
import { modificacionComentariosGlobales, modificacionComentariosPropios, modificacionNoticias, modificacionPedido, modificacionPermisos, modificacionProductos, modificacionRol, modificacionUsuarioGlobal, modificacionUsuarioPropio } from "../Vistas/plantillaModificaciones.js";
import { confirmarEliminacion,confirmarEliminacionComentarios, confirmarEliminacionPermisos, confirmarEliminacionUsuario } from "../Vistas/plantillaBorrar.js";
import { agregarNoticia, agregarPermiso, agregarProductoGlobal, agregarProductoPropio, agregarRol, agregarUsuario, enviarRespuesta } from "../Vistas/plantillaAgregar.js";
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
        return new Promise(async(resolve, reject) => {
        try{
           
            if(datos.comentariosPropio){
                
                imprimirListaComentariosPropio(datos);
            }else if(datos.comentariosGlobal){
                
                imprimirListaComentariosGlobal(datos);
            }
            else if(datos.usuarios){
                imprimirListaUsuarios(datos);
            }
            else if(datos.roles){
                imprimirListaRoles(datos);
            }
            else if(datos.productosGlobal){
                imprimirListaProductosGlobal(datos);
            }
            else if(datos.productosPropio){
                imprimirListaProductosPropio(datos);
            }
            else if(datos.permisos){
                imprimirListaPermisos(datos);
            }
            else if(datos.listaPedidos){
                imprimirListaPedidos(datos);
            }
            else if(datos.noticias){
                imprimirListaNotcias(datos);
            }
            else if(datos.productosPropios){
                imprimirListaProductos(datos);
            }
            else if(datos.envios){
                imprimirEnvios(datos);
            }
            else if(datos.historial){
                imprimirHistorial(datos);
            }
            else if(datos.listaPedidosUsuario){
                imprimirListaPedidosUsuario(datos);
            }
            else if(datos.listaMensajes){
                imprimirMensajes(datos);
            }
            else{
                /**Llevar a imprimir vacio */
                console.log("o aqui");
            }

        }catch(e){
            
        }
         resolve();
    });
  
}

export function modificaciones(datos){
    if(datos[datos.length-1]=="Lista comentarios"){
        
        modificacionComentariosGlobales(datos);
    }
    else if(datos[datos.length-1]=="Comentarios"){
        modificacionComentariosPropios(datos);
    }
    else if(datos[datos.length-1]=="Lista Noticias"){
        
        modificacionNoticias(datos);
    }

    else if(datos[datos.length-1]=="Lista pedidos" || datos[datos.length-1]=="Envios"){
       
        modificacionPedido(datos);
    }
    else if(datos[datos.length-1]=="Lista usuarios"){
       
        modificacionUsuarioGlobal(datos);
    }
    //Puedes Modificarlo, pero no tiene mucho sentido por la estructuración del código.
    else if(datos[datos.length-1]=="Lista roles"){
       
        modificacionRol(datos);
    }
    else if(datos[datos.length-1]=="Lista permisos"){
        modificacionPermisos(datos);
    }
    else if(datos[datos.length-1]=="Lista productos"){
        modificacionProductos(datos);
    }
    else if(datos[datos.length-1]=="Productos"){
        modificacionProductos(datos);
    }
    else if(datos[datos.length-1]=="Perfil"){
        modificacionUsuarioPropio(datos);
    }
}

export function eliminacion(datos){
    if(datos[datos.length-1]=="Lista comentarios"){
        
        confirmarEliminacionComentarios(datos);
    }
    else if(datos[datos.length-1]=="Lista permisos"){
        
        confirmarEliminacionPermisos(datos);
    }
    else if(datos[datos.length-1]=="Perfil"){
        
        confirmarEliminacionUsuario(datos);
    }
    else{
        confirmarEliminacion(datos);
    }
}

export function agregar(datos){
   if(datos=="Lista Noticias"){
        agregarNoticia();
    }
    else if(datos=="Lista usuarios"){
       
        agregarUsuario();
    }
    //Puedes Modificarlo, pero no tiene mucho sentido por la estructuración del código.
    else if(datos=="Lista roles"){
       
        agregarRol();
    }
    else if(datos=="Lista permisos"){
        agregarPermiso();
    }
    else if(datos=="Lista productos"){
        agregarProductoGlobal();
    }
    else if(datos=="Productos"){
        agregarProductoPropio();
    }else if(datos[datos.length-1]=="Mensajes"){
        enviarRespuesta(datos);
    }
}
