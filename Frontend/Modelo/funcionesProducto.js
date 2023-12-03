/**
 * @file Este script contendra las funciones relacionada con los productos y carrito
 * @description Este script tendrá funciones como la recuperación de un producto por su id
 * @author Juan Carlos Rodríguez Miranda.
 * @version 1.0.0
*/
export function creacionObjetoCarrito() {
  //variables necesarias para crear nuestro objeto carrito
  let objetoCarrito = new Object();
  let datoProducto = sessionStorage.getItem("productoSeleccionado") //PONER VALORES REGOGIDOS BBDD;
  let productos = JSON.parse(sessionStorage.getItem("productos"));
  let cantidadProducto = parseInt(document.getElementById("cantidad").value) //PONER VALORES REGOGIDOS BBDD;
  //si no existen ni cantidad ni datos del producto y la cantidad es 0 o menor no se hará
  if (datoProducto != null && (!isNaN(cantidadProducto) && cantidadProducto > 0)) {
    //A
    for (let producto of productos) {
      if (producto.id == datoProducto) {
        objetoCarrito = {
          id: producto.id,
          nombre: producto.nombre_producto,
          imagen: producto.imagen,
          precioInicial: producto.precio,
          cantidad: cantidadProducto,
          precioTotal: (producto.precio * cantidadProducto).toFixed(2)
        };
        //Agregamos dentro de la sesión de carrito
        

      }
    };
    
  }
  return objetoCarrito;
}
function agregarObjetoCarrito(objetoCarrito) {
  if (sessionStorage.getItem("carrito")) {
    let array = JSON.parse(sessionStorage.getItem("carrito"));
    if (array.find(objeto => objeto.id == objetoCarrito.id)) {
      let index = array.findIndex(index => index.id == objetoCarrito.id);
      array[index].cantidad = array[index].cantidad + objetoCarrito.cantidad;
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

export function filtradoEstrellas(id){
    let respuesta="";
    
        switch (id) {
          case "5estrellas":
            respuesta = "5_Estrellas";
            break;
          case "4estrellas":
            respuesta = "4_Estrellas";
  
            break;
          case "3estrellas":
            respuesta = "3_Estrellas";
  
            break;
          case "2estrellas":
            respuesta = "2_Estrellas";
  
            break;
          case "1estrellas":
            respuesta = "1_Estrellas";
  
            break;
           case "todas":
            respuesta = "todas";
            break;

            default:
              respuesta = "";
              break;
        }
   
    return respuesta;
}