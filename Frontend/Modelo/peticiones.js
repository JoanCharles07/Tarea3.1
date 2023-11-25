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

export function agregarUsuario(datosUsuario){
    //DATOS NECESARIOS PARA EL SERVIDOR
    console.log(datosUsuario.usuario + " HOLA");
        let datos={
            llamada:"usuario"
        }
        let datosRegistro={
            usuario:"El que sea",
            pass:"El que sea",
            pass2:"El que sea",
            nombre:"El que sea",
            apellidos:"El que sea",
            direccion:"El que sea",
            provincia:"El que sea",
            ciudad:"El que sea",
            cpostal:"El que sea",
            email:"El que sea",
            DNI:"El que sea",
            rol:"El que sea",
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