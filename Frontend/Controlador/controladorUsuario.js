/**
 * @file Este script se encargará de controlar lo relacionado con el usuario
 * @description Este script conectará a funciones de la BBDD y comprobaciones de los inputs.
 * @author Juan Carlos Rodríguez Miranda.
 * @version 1.0.0
*/

import { usuario,recuperarDatosUsuario, accesoListados } from "../Modelo/peticiones.js";
/**
 * Esta función recibe los datos del Usuario y devolverá un array con los resultados.
 * devolverá una promesa que entregará el array y así seguir con el código.
 * @see comprobarDatosRegex comprobamos que los datos recibidos sean correctos.
 * @see usuario se encarga de hacer la petición al servidor que se encargará de determinar si es login o registro.
 * @returns promesa con los datos JSON recibidos por comprobarDatosRegex.
 */
export function recepcionDeDatosUsuario(direccion) {
    return new Promise((resolve, reject) => {
           
            
            let datosRegistro = new FormData(document.getElementById("formulario"));
            import("../Modelo/comprobaciones.js").then(async(funciones) => {
                let datos = funciones.comprobarDatosRegex(datosRegistro);
                if(datos!=null){
                    let control= Object.values(datos).filter(elemento => elemento == true);
                    if(control.length==0){
                       //Nos aseguramos de tener los datos antes de continuar
                        let datosServidor= await usuario(datosRegistro,direccion);
                        //En caso de tener la propiedad datosUuario quiere decir que ha sido correcto
                        if(datosServidor.datosUsuario && datosServidor.acciones){
                            //codificar datos antes de meterlos
                            
                            sessionStorage.setItem("usuario",btoa(JSON.stringify(datosServidor.datosUsuario)));
                            sessionStorage.setItem("acciones",btoa(JSON.stringify(datosServidor.acciones)));
                            resolve();
                        }else{
                            resolve(datosServidor);
                        }
                        resolve();
                        
                    }
                    else{
                        resolve(datos);
                    }
                    
               }
               else{
                    reject("Hubo un error Recepción de Datos Usuario");
               }
            })
        })

    
}

/**
 * Esta función llama a la función validarPass que devolverá el resultado.
 * @see validarPass realización de la lógica para saber si son iguales.
 * @return Promise con el resultado de la función validarPass
 */
export function passIguales() {
    return new Promise((resolve, reject) => {

        import("../Modelo/comprobaciones.js").then((funciones) => {

            let pass = funciones.validarPass();
           if(pass!=null){
                resolve(pass);
           }
           else{
                reject("Hubo un error en PassIguales");
           }
            
        });
    })


};

export function datosUsuario(){
    return new Promise(async (resolve, reject) => {
        const respuesta=await recuperarDatosUsuario();
        
        resolve(respuesta);
    });
    
}


export function comprobarAccion() {
    return new Promise(async(resolve, reject) => {
        
          const respuesta=await accesoListados();
          resolve(respuesta);
        })
        
    
}