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
    
        return fetch("Backend/Controlador/controlador.php", {
            method: 'GET'
            
        })
            .then(response => response.text())
            .then(data => {
                //return
                console.log(data);
                
        });
    
}