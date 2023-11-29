/**
 * @file Este script contendra las funciones relacionada con los productos y carrito
 * @description Este script tendrá funciones como la recuperación de un producto por su id
 * @author Juan Carlos Rodríguez Miranda.
 * @version 1.0.0
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