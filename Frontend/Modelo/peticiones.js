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
export function usuario(datosUsuario, direccion) {
    return new Promise((resolve, reject) => {
      try {
        // DATOS NECESARIOS PARA EL SERVIDOR
        // Trasnformo el formdata a objeto para mejor manejo en PHP
        let datosIntroducidos = {};
        for (const dato of datosUsuario.entries()) {
          datosIntroducidos[dato[0]] = dato[1];
        }
  
        // enviar llamada y datos registro a php
        let datos = { llamada: direccion, datosIntroducidos };
        fetch("../../Backend/Controlador/controlador.php", {
          method: 'POST',
          body: JSON.stringify(datos)
        })
          .then(response => {
            if (!response.ok) {
              throw new Error(`Error en la solicitud: ${response.status}`);
            }
            return response.text();
          })
          .then(data => {
            const datos = JSON.parse(data);
            resolve(datos);
          })
          .catch(error => {
            // Capturamos y manejamos el error
            console.error("Error en la llamada fetch:", error);
            reject(error);
          });
      } catch (error) {
        // Capturamos y manejamos cualquier error sincrónico
        console.error("Error en la función usuario:", error);
        reject(error);
      }
    });
  }


export function verComentarios(idProducto){
    return new Promise((resolve, reject) => {
        let datosIntroducidos = new Object();
        datosIntroducidos.id=idProducto;
        let datos={llamada:"Comentarios",datosIntroducidos};
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

export function agregarComentarios(datosComentario){
    return new Promise((resolve, reject) => {
         //DATOS NECESARIOS PARA EL SERVIDOR
        //Trasnformo el formdata a objeto para mejor manejo en PHP
        let datosIntroducidos = new Object();
        //Con esta expresión regular podemos confirmar var
        console.log(datosComentario);
        for (const dato of datosComentario.entries()) {
            datosIntroducidos[dato[0]] = dato[1];
           
        }
        let producto=sessionStorage.getItem("productoSeleccionado");
        datosIntroducidos["IDproducto"]=producto;

        let datos={llamada:"agregarComentario",datosIntroducidos};
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
export function agregarCarrito(datosCarrito,IDusuario){
    try{
        return new Promise((resolve, reject) => {
            //DATOS NECESARIOS PARA EL SERVIDOR
           //Trasnformo el formdata a objeto para mejor manejo en PHP
           let datosIntroducidos = new Object();
           
           //Con esta expresión regular podemos confirmar var
           for (const [key,value] of Object.entries(datosCarrito)) {
              if(key=="id" || key=="cantidad"){
                datosIntroducidos[key] = value;
              }
               
              
           }
           datosIntroducidos["IDusuario"]=IDusuario;
           console.log(datosIntroducidos);
           let datos={llamada:"agregarCarritoBBDD",datosIntroducidos};
           
           fetch("../../Backend/Controlador/controlador.php", {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
          },
            body:JSON.stringify(datos)
            
        })
            .then(response => response.text())
            .then(data => {
                const datos=JSON.parse(data);
                resolve();
                
        }).catch(error =>{
          reject(error);
        })
       });
    }catch(e){
        console.log(e);
    }
    
}
export function recuperarCarrito(usuario){
  try{
      return new Promise((resolve, reject) => {
          //DATOS NECESARIOS PARA EL SERVIDOR
         //Trasnformo el formdata a objeto para mejor manejo en PHP
         let datosIntroducidos = {
          usuario:usuario[0],
          rol:usuario[1]
         };
         
         //Con esta expresión regular podemos confirmar var
         
         console.log(datosIntroducidos);
         let datos={llamada:"recuperarCarrito",datosIntroducidos};
         
         fetch("../../Backend/Controlador/controlador.php", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
        },
          body:JSON.stringify(datos)
          
      })
          .then(response => response.text())
          .then(data => {
              const datos=JSON.parse(data);
              console.log(datos);
              resolve(datos);
              
      }).catch(error =>{
        reject(error);
      })
     });
  }catch(e){
      console.log(e);
  }
  
}
