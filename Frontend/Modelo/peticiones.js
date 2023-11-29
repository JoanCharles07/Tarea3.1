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
            llamada:"Productos"
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
 * Esta función hará una petición a la base de datos para registrar o iniciar sesión del usuario
 * @param {datosUsuario} Object con datos proporcionador por el usuario.
 * @param {direccion} String cadena de texto que indica si se ha producido desde el registro o desde el login.
 * @returns Objeto con datos del usuario o errores producidos en la BBDD
 */
export function usuario(datosUsuario,direccion){
    return new Promise((resolve, reject) => {
    //DATOS NECESARIOS PARA EL SERVIDOR
        //Trasnformo el formdata a objeto para mejor manejo en PHP
        let datosIntroducidos = new Object();
       
  //Con esta expresión regular podemos confirmar var
        for (const dato of datosUsuario.entries()) {
            datosIntroducidos[dato[0]] = dato[1];
           
        }
       
    //enviar llamada y datos registro a php
        let datos={llamada:direccion,datosIntroducidos};
        fetch("../../Backend/Controlador/controlador.php", {
            method: 'POST',
            body:JSON.stringify(datos)
            
        })
            .then(response => response.text())
            .then(data => {
                const datos=JSON.parse(data);
                resolve(datos);
                
        });
    });
}


export function peticionComentarios(idProducto){
    return new Promise((resolve, reject) => {
    
        let datos={llamada:"Comentarios",id:idProducto};
        fetch("../../Backend/Controlador/controlador.php", {
            method: 'POST',
            body:JSON.stringify(datos)
            
        })
            .then(response => response.text())
            .then(data => {
                const datos=JSON.parse(data);
                console.log(datos);
                resolve(datos);
                
        });
    });
}
