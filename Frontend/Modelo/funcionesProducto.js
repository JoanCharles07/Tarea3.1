/**
 * @file Este script contendra las funciones relacionada con los productos y carrito
 * @description Este script tendrá funciones como la recuperación de un producto por su id
 * @author Juan Carlos Rodríguez Miranda.
 * @version 1.0.0
*/

/**
 * Esta función hace llamadas a la función creacionObjetoCarrito que se encargará de crear los objetos que se insertarán dentro
 * del carrito.
 * @see creacionObjetoCarrito donde se crean los objetos del carrito.
 * @param {Array} carrito con objetos con información del carrito
 */
export function rellenarCarritoUsuario(carrito){
   //variables necesarias para crear nuestro objeto carrito
   
   for(let producto of carrito){
    
    creacionObjetoCarrito(producto.producto,producto.cantidad);
   }
   
}
/**
 * Esta funcion se encarga de crear el producto que insertaremos en nuestro carrito.
 * @see agregarCarrito. donde agregaremos el producto a nuestra sessionStorage
 * @returns objetoCarrito Objeto con los datos del producto
 */

export function creacionObjetoCarrito(product,cantidadTotal) {
  //variables necesarias para crear nuestro objeto carrito
  let objetoCarrito = new Object();
  let datoProducto = product //PONER VALORES REGOGIDOS BBDD;
  let productos = JSON.parse(sessionStorage.getItem("productos"));
  let cantidadProducto = cantidadTotal //PONER VALORES REGOGIDOS BBDD;
  //si no existen ni cantidad ni datos del producto y la cantidad es 0 o menor no se hará
  if (datoProducto != null && (!isNaN(cantidadProducto) && cantidadProducto > 0)) {
    
    for (let producto of productos) {
      if (producto.id == datoProducto) {
        //const precioDescuento=producto.precio-(producto.precio*(producto.descuento/100));
        objetoCarrito = {
          id: producto.id,
          nombre: producto.nombre_producto,
          imagen: producto.imagen,
          precioInicial: producto.precio,
          cantidad: cantidadProducto,
          precioTotal: (producto.precio * cantidadProducto).toFixed(2)
        };
        //Agregamos dentro de la sesión de carrito
        agregarObjetoCarrito(objetoCarrito);

      }
    };
    
  }
  return objetoCarrito;
}
/**
 * En esta función insertaremos los datos dentro de la sessionStorage
 * @param {Object} objetoCarrito con datos del producto
 */
export function agregarObjetoCarrito(objetoCarrito) {
  if (sessionStorage.getItem("carrito")) {
    let array = JSON.parse(sessionStorage.getItem("carrito"));
    if (array.find(objeto => objeto.id == objetoCarrito.id)) {
      let index = array.findIndex(index => index.id == objetoCarrito.id);
      array[index].cantidad = array[index].cantidad + parseInt(objetoCarrito.cantidad);
      array[index].precioTotal = (array[index].cantidad * array[index].precioInicial).toFixed(2);
      sessionStorage.setItem("carrito", JSON.stringify(array));
    } else {
      array.push(objetoCarrito);
      sessionStorage.setItem("carrito", JSON.stringify(array));
    }

  }
  else {
    let array = [objetoCarrito];
    sessionStorage.setItem("carrito", JSON.stringify(array));
  }

}
/**
 * Esta función busca el id del producto y crea un array con los datos del producto en concreto.
 * @param {Numbre} idProducto 
 * @param {Array} productos 
 * @returns  array con los datos del producto.
 */
export function datosProducto(idProducto,productos){
    
    let datosProductoSeleccionado={};
    for (const producto of productos) {
        
        if(idProducto==producto.id){
            datosProductoSeleccionado.id=idProducto;
            datosProductoSeleccionado.nombre=producto.nombre_producto;
            datosProductoSeleccionado.stock=producto.stock;
            datosProductoSeleccionado.precio=producto.precio;
            datosProductoSeleccionado.imagen=producto.imagen;
            datosProductoSeleccionado.valoracionTotal=producto.valoracion_total;
            datosProductoSeleccionado.comentariosTotales=producto.comentarios_totales;
            datosProductoSeleccionado.descuento=producto.descuento;

            //si entra cortamos la ejecución con break.
            break;
        }
    }
    return datosProductoSeleccionado;
}

export function borrarProductoSesion(id){
  let productos= JSON.parse(sessionStorage.getItem("carrito"));
  
  for(producto of productos){
      if(producto.id==id){
        let index=productos.indexOf(producto);
        productos.splice(index, 1);
        sessionStorage.setItem("carrito", JSON.stringify(productos));
      }
  }
   
  return true;

}
/**
 * Esta función comprueba si hay stock en primera instancia en nuestra session
 * @param {} IDproducto con el id del producto en cuestion
 * @param {*} cantidad con el número del producto que quiere el cliente.
 * @returns Boolean con resultado de la expresión regular.
 */
export function comprobarStockJS(IDproducto,cantidad){
  let productos= JSON.parse(sessionStorage.getItem("productos"));
  let resultado=false;
  for(let producto of productos){
    
      if(producto.id==IDproducto && producto.stock >= cantidad){          
        resultado=true;
        break;
      }
  }
   
  return resultado;

}
/**
 * Esta función comprueba si hay stock en el carrito
 * @param {} IDproducto con el id del producto en cuestion
 * @param {*} cantidad con el número del producto que quiere el cliente.
 * @returns Boolean con resultado de la expresión regular.
 */
export function comprobarStockJSCarrito(){
  let productos= JSON.parse(sessionStorage.getItem("productos"));
  let carrito=JSON.parse(sessionStorage.getItem("carrito"));
  //conseguimos las coincidencias filtramos y luego con some hacemos las comparaciones de lo que necesitamos.Se puede añadir precio
  const coincidencias=  productos.filter( IDproducto => 
    carrito.some( IDcarrito => (IDcarrito.id === IDproducto.id && parseInt(IDcarrito.cantidad) > parseInt(IDproducto.stock))));
  //añadimos a array con map
  const idCoincidencia = coincidencias.map(elemento => elemento.id);

  return idCoincidencia;
}