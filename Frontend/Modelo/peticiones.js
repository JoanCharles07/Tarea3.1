/**
 * @file Este script contendrá todas las funciones que hagan peticiones al servidor.
* 
* @author Juan Carlos Rodríguez Miranda.
* @version 1.0.0
*/

import { comprobacionMensaje, comprobacionREAD, comprobacionUPDATE, comprobarDatosRegex } from "./comprobaciones.js";

/**
 * Esta función hará una petición a la base de datos para conseguir todos los productos de la tienda.
 * @returns Objeto con todos los productos de nuestra BBDD.
 */
export function getProductos() {
  //DATOS NECESARIOS PARA EL SERVIDOR
  let datos = {
    llamada: "Productos"
  }
  return fetch("../../Backend/Controlador/controlador.php", {
    method: 'POST',
    body: JSON.stringify(datos)

  })
    .then(response => response.text())
    .then(  data => {
      const datos =  JSON.parse(data);
      
      console.log(datos);
      return datos;

    }).catch(error =>{
      console.error('Error al realizar la solicitud:', error);
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
          reject(error);
        });
    } catch (error) {
      // Capturamos y manejamos cualquier error sincrónico
      reject(error);
    }
  });
}

/**
 * Esta función llamará al servidor para conseguir los comentarios que forman parte de este producto.
 * @param {String} idProducto contiene el id del producto
 * @returns {Object} datos con todos los datos de los comentarios si los hubiera.
 */
export function verComentarios(idProducto) {
  return new Promise((resolve, reject) => {
    let datosIntroducidos = new Object();
    datosIntroducidos.id = idProducto;
    let datos = { llamada: "Comentarios", datosIntroducidos };
    fetch("../../Backend/Controlador/controlador.php", {
      method: 'POST',
      body: JSON.stringify(datos)

    })
      .then(response => response.text())
      .then(data => {
        const datos = JSON.parse(data);
        resolve(datos);

      });
  });
}
/**
 * Esta función llamará al servidor para añadir el mensaje si es posible.
 * @param {Object} datosComentario contiene todos los datos del comentario(Mensaje y valoración).
 * @returns 
 */
export function agregarComentarios(datosComentario) {
  return new Promise((resolve, reject) => {
    //DATOS NECESARIOS PARA EL SERVIDOR
    //Trasnformo el formdata a objeto para mejor manejo en PHP
    let datosIntroducidos = new Object();
    //Con esta expresión regular podemos confirmar var
    for (const dato of datosComentario.entries()) {
      datosIntroducidos[dato[0]] = dato[1];

    }
    let producto = sessionStorage.getItem("productoSeleccionado");
    datosIntroducidos["IDproducto"] = producto;

    let datos = { llamada: "agregarComentario", datosIntroducidos };
    fetch("../../Backend/Controlador/controlador.php", {
      method: 'POST',
      body: JSON.stringify(datos)

    })
      .then(response => response.text())
      .then(data => {
        const datos = JSON.parse(data);
        resolve(datos);

      });
  });
}
/**
 * Esta función añadirá a la BBDD el objeto que se agrega al carrito.
 * @param {Object} datosCarrito contendra los datos del producto en forma de objeto.
 * 
 */
export function agregarCarrito(datosCarrito) {
  try {
    return new Promise((resolve, reject) => {
      //DATOS NECESARIOS PARA EL SERVIDOR
      //Trasnformo el formdata a objeto para mejor manejo en PHP
      let usuario = JSON.parse(atob(sessionStorage.getItem("usuario")));
      let datosIntroducidos = new Object();

      //Con esta expresión regular podemos confirmar var
      for (const [key, value] of Object.entries(datosCarrito)) {
        if (key == "id" || key == "cantidad") {
          datosIntroducidos[key] = value;
        }

      }
      datosIntroducidos["IDusuario"] = usuario[0];
      let datos = { llamada: "agregarCarritoBBDD", datosIntroducidos };
      fetch("../../Backend/Controlador/controlador.php", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(datos)

      })
        .then(response => response.text())
        .then(data => {
          const datos = JSON.parse(data);
          resolve();

        }).catch(error => {
          reject(error);
        })
    });
  } catch (e) {
  }

}
/**
 * Esta función hará una petición a la base de datos para registrar o iniciar sesión del usuario
 * @param {datosCarrito} Object con datos proporcionado por el usuario.
 * @returns Objeto con datos de la petición o errores producidos en la BBDD
 */
export function borrarDelCarritoBBDD(datosCarrito) {
  try {
    return new Promise((resolve, reject) => {
      //DATOS NECESARIOS PARA EL SERVIDOR
      //Trasnformo el formdata a objeto para mejor manejo en PHP
      let usuario = JSON.parse(atob(sessionStorage.getItem("usuario")));
      
      let datosIntroducidos = new Object();

      //Con esta expresión regular podemos confirmar var
      datosIntroducidos["id"] = datosCarrito;
      datosIntroducidos["IDusuario"] = usuario[0];
      let datos = { llamada: "borrarCarritoBBDD", datosIntroducidos };
      fetch("../../Backend/Controlador/controlador.php", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(datos)

      })
        .then(response => response.text())
        .then(data => {
          const datos = JSON.parse(data);
          resolve();

        }).catch(error => {
          reject(error);
        })
    });
  } catch (e) {
  }

}
/**
 * Esta fución llamará al servidor para recuperar todos los productos que tuviera añadidos el usuario a su carrito.
 * @returns devuelve un objeto con los resultados
 */
export function recuperarCarrito() {
  let usuario = JSON.parse(atob(sessionStorage.getItem("usuario")));
  try {
    return new Promise((resolve, reject) => {
      //DATOS NECESARIOS PARA EL SERVIDOR
      //Trasnformo el formdata a objeto para mejor manejo en PHP
      let datosIntroducidos = {
        usuario: usuario[0],
        rol: usuario[1]
      };


      let datos = { llamada: "recuperarCarrito", datosIntroducidos };

      fetch("../../Backend/Controlador/controlador.php", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(datos)

      })
        .then(response => response.text())
        .then(data => {
          const datos = JSON.parse(data);
          resolve(datos);

        }).catch(error => {
          reject(error);
        })
    });
  } catch (e) {
  }

}
/**
 * Devuelve los datos del usaurio registrado.
 * @returns datos del usuario si no hay errores.
 */
export function recuperarDatosUsuario() {
  let usuario = JSON.parse(atob(sessionStorage.getItem("usuario")));
 
  try {
    return new Promise((resolve, reject) => {
      //DATOS NECESARIOS PARA EL SERVIDOR
      //Trasnformo el formdata a objeto para mejor manejo en PHP
      let datosIntroducidos = {
        usuario: usuario[0],
        rol: usuario[1]
      };


      let datos = { llamada: "recuperarUsuario", datosIntroducidos };

      fetch("../../Backend/Controlador/controlador.php", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(datos)

      })
        .then(response => response.text())
        .then(data => {
          const datos = JSON.parse(data);
          resolve(datos);

        }).catch(error => {
          reject(error);
        })
    });
  } catch (e) {
  }
}


/**
 * Hace la petición que cambia la contraseña del usuario
 * @returns datos del usuario si no hay errores.
 */
export function cambiarPassBBDD() {
  
  
  try {
    return new Promise((resolve, reject) => {
      //DATOS NECESARIOS PARA EL SERVIDOR
      //Trasnformo el formdata a objeto para mejor manejo en PHP
      let usuario = JSON.parse(atob(sessionStorage.getItem("usuario")));
      let datosPass = new FormData(document.getElementById("cambiarPass"));
      let datosIntroducidos={};
      for (const dato of datosPass.entries()) {
        datosIntroducidos[dato[0]] = dato[1];
      }
      datosIntroducidos["usuario"]=usuario[0];
      let datos = { llamada: "cambiarPass",  datosIntroducidos };

      fetch("../../Backend/Controlador/controlador.php", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(datos)

      })
        .then(response => response.text())
        .then(data => {
          const datos = JSON.parse(data);
          resolve(datos);

        }).catch(error => {
          reject(error);
        })
    });
  } catch (e) {
  }
}
/**
 * Esta función hará una petición a la base de datos para recuperar todas las noticias
 * @returns Objeto con datos del usuario o errores producidos en la BBDD
 */
export function recuperarNoticias() {

  try {
    return new Promise((resolve, reject) => {
      //DATOS NECESARIOS PARA EL SERVIDOR
      //Trasnformo el formdata a objeto para mejor manejo en PHP



      let datos = { llamada: "noticias" };

      fetch("../../Backend/Controlador/controlador.php", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(datos)

      })
        .then(response => response.text())
        .then(data => {
          const datos = JSON.parse(data);
          resolve(datos);

        }).catch(error => {
          reject(error);
        })
    });
  } catch (e) {
  }
}
/**
 * Esta función hará una petición para cerrar la sesión del usuario.
 * @returns Objeto con datos del usuario o errores producidos en la BBDD
 */
export function cerrarSesionBBDD() {

  try {
    return new Promise((resolve, reject) => {
      //DATOS NECESARIOS PARA EL SERVIDOR
      //Trasnformo el formdata a objeto para mejor manejo en PHP



      let datos = { llamada: "cerrarSesion" };

      fetch("../../Backend/Controlador/controlador.php", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(datos)

      })
        .then(response => response.text())
        .then(data => {
          const datos = JSON.parse(data);
          resolve(datos);

        }).catch(error => {
          reject(error);
        })
    });
  } catch (e) {
  }
}
/**
 * Esta función hará una petición a la base de datos que nos permitirá acceder a los distintos listados.
 * @returns Objeto con datos del usuario o errores producidos en la BBDD
 */
export function accesoListados() {

    return new Promise(async(resolve, reject) => {
      const datosIntroducidos=comprobacionREAD();
      if(typeof Object.values(datosIntroducidos)[0] != "boolean"){
        let datos = { llamada: "listas", datosIntroducidos };
        fetch("../../Backend/Controlador/controlador.php", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(datos)

        })
          .then(response => response.text())
          .then(data => {
            const datos = JSON.parse(data);
            resolve(datos);

          }).catch(error => {
            reject(error);
          })
      
    
      }
      else{
        resolve(datosIntroducidos)
      }
    });
        
  
}
/**
 * Esta función hará una petición a la base de datos que nos permitirá agregar datos.
 * @returns Objeto con datos del usuario o errores producidos en la BBDD
 */
export  function accesoAgregar() {

  try {
    return new Promise(async(resolve, reject) => {
      //tambien sirver para agregar comprobacionUpdate
      const datosIntroducidos= await comprobacionUPDATE();
      
      if(typeof Object.values(datosIntroducidos)[0] != "boolean"){
        datosIntroducidos["accion"] = "crear";
        let datos = { llamada: "agregar", datosIntroducidos };
        fetch("../../Backend/Controlador/controlador.php", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(datos)
  
        })
          .then(response => response.text())
          .then(data => {
            const datos = JSON.parse(data);
            resolve(datos);
  
          }).catch(error => {
            reject(error);
          })
      }
      else{
        resolve(datosIntroducidos)
      }
      
    });
  } catch (e) {
  }
}
/**
 * Esta función hará una petición a la base de datos que nos permitirá modificar datos.
 * @returns Objeto con datos del usuario o errores producidos en la BBDD
 */
export  function accesoListadosModificado() {

  try {
    return new Promise(async(resolve, reject) => {
      const datosIntroducidos= await comprobacionUPDATE();
      
      if(typeof Object.values(datosIntroducidos)[0] != "boolean"){
        let datos = { llamada: "modificar", datosIntroducidos };
        fetch("../../Backend/Controlador/controlador.php", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(datos)
  
        })
          .then(response => response.text())
          .then(data => {
            const datos = JSON.parse(data);
            resolve(datos);
  
          }).catch(error => {
            reject(error);
          })
      }
      else{
        resolve(datosIntroducidos)
      }
      
    });
  } catch (e) {
  }
}
/**
 * Esta función hará una petición a la base de datos que nos permitirá eliminar datos .
 * @returns Objeto con datos del usuario o errores producidos en la BBDD
 */
export function accesoListadosEliminado() {

  try {
    return new Promise((resolve, reject) => {
      if (sessionStorage.getItem("usuario")) {

      }
      let datosModificados = new FormData(document.getElementById("formulario"));
      const usuario = JSON.parse(atob(sessionStorage.getItem("usuario")));
      let datosIntroducidos = {};
      for (const dato of datosModificados.entries()) {
        datosIntroducidos[dato[0]] = dato[1];
      }

      datosIntroducidos["usuario"] = usuario[0];
      datosIntroducidos["accion"] = "borrar";
      let datos = { llamada: "eliminar", datosIntroducidos };

      fetch("../../Backend/Controlador/controlador.php", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(datos)

      })
        .then(response => response.text())
        .then(data => {
          const datos = JSON.parse(data);
          resolve(datos);

        }).catch(error => {
          reject(error);
        })
    });
  } catch (e) {
  }
}

/**
 * Esta función comprueba el stock del producto en la BBDD.
 * @returns Objeto con datos del usuario o errores producidos en la BBDD
 */
export  function comprobarStock() {
  
  try {
    return new Promise(async(resolve, reject) => {
        let producto = sessionStorage.getItem("productoSeleccionado");
        let cantidadProducto = parseInt(document.getElementById("cantidad").value);
        let datosIntroducidos={
          producto:producto,
          cantidad:cantidadProducto
        } 
        let datos = { llamada: "comprobarStock", datosIntroducidos };
        
        fetch("../../Backend/Controlador/controlador.php", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(datos)
  
        })
          .then(response => response.text())
          .then(data => {
            const datos = JSON.parse(data);
            resolve(datos);
  
          }).catch(error => {
            reject(error);
          })
      
      
    });
  } catch (e) {
  }
}
/**
 * Esta función hará una petición a la base de datos que agregará los datos necesarios para terminar la compra.
 * @returns Objeto con datos del usuario o errores producidos en la BBDD
 */
export  function finalizarCompraBBDD() {
  
  try {
    return new Promise(async(resolve, reject) => {
        let carrito = JSON.parse(sessionStorage.getItem("carrito"));
        const usuario = JSON.parse(atob(sessionStorage.getItem("usuario")));
        let carritoDatos=carrito.map(elemento => [elemento.id , elemento.precioInicial ,elemento.cantidad, elemento.precioTotal ]);
        //Comprobar que sean numeros y todos mayores que 0
        carrito["usuario"]=usuario[0];
        let datos = { llamada: "finalizarCompra", objeto:carritoDatos };
        
        fetch("../../Backend/Controlador/controlador.php", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(datos)
  
        })
          .then(response => response.text())
          .then(data => {
            const datos = JSON.parse(data);
            resolve(datos);
  
          }).catch(error => {
            reject(error);
          })
      
      
    });
  } catch (e) {
  }
}