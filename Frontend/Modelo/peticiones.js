/**
 * @file Este script contendrá todas las funciones que hagan peticiones al servidor.
* 
* @author Juan Carlos Rodríguez Miranda.
* @version 1.0.0
*/

/**
 * Esta función hará una petición a la base de datos para conseguir todos los productos de la tienda.
 * @returns Objeto con todos los productos de nuestra BBDD.
 */
export function getProductos(){
    //DATOS NECESARIOS PARA EL SERVIDOR
        let datos={
            llamada:"productos"
        }
        return fetch("../../Backend/Controlador/controlador.php", {
            method: 'POST',
            body:JSON.stringify(datos)
            
        })
            .then(response => response.text())
            .then(data => {
                const datos=JSON.parse(data);
                return datos;
                
        });
    
}
/**
 * Esta función hará una petición a la base de datos para conseguir todos los productos de la tienda.
 * @returns Objeto con datos del usuario y efectividad del registro.
 */
export function agregarUsuario(datosUsuario){
    //DATOS NECESARIOS PARA EL SERVIDOR
        //Trasnformo el formdata a objeto para mejor manejo en PHP
        let datosRegistro = new Object();
       
  //Con esta expresión regular podemos confirmar var
        for (const dato of datosUsuario.entries()) {
            datosRegistro[dato[0]] = dato[1];
           
        }
    //enviar llamada y datos registro a php
        let datos={llamada:"registro",datosRegistro};
        return fetch("../../Backend/Controlador/controlador.php", {
            method: 'POST',
            body:JSON.stringify(datos)
            
        })
            .then(response => response.text())
            .then(data => {
                const datos=JSON.parse(data);
                return datos;
                
        });
    
}