import { comprobarFecha } from "../Modelo/comprobaciones.js";

/**
 * Esta función redireccionará a distintos puntos de la página
 * @param arrayDatos contendra los datos necesarios para borrar
 */
export function redireccionLista(eleccion) {
    if (eleccion == "Carrito") {
        location.href = "./carrito.html";
    }
    else if (eleccion == "Perfil") {
        location.href = "./perfil.html";
    }
    else {

        const datosPorURL = '?eleccion=' + encodeURIComponent(eleccion);
        location.href = "./listas.html" + datosPorURL;
    }
}
/**
 * Esta función imprimirá una tabla con los comentarios realizados por el usuario
 * @param datos contendra los datos necesarios para la lista.
 */
export function imprimirListaComentariosPropio(datos) {
  
    if (Object.values(datos.comentariosPropio).length == 0) {
        let main = document.getElementById("main");
        main.innerHTML = `<div id="vacio"><p>No ha realizado ningún comentario todavía</p></div>`;
    } else {
        const lista = document.getElementById("listado");
        let tabla = `<thead>
        <tr>
            <th style="display:none">ID producto</th>
            <th>Mensaje</th>
            <th>Valoración</th>
            <th>Fecha</th>
            <th>Producto</th>
            <th>Imagen</th>
            <th>Modificar</th>
            <th>Eliminar</th>
        </tr>
    </thead><tbody>`;
        for (const key of datos.comentariosPropio) {
            tabla += `<tr>
        <td style="display:none">${key.IDProducto}</td>
        <td>${key.mensaje}</td>
        <td>${key.valoracion}</td>
        <td>${key.fecha}</td>
        <td>${key.nombreProducto}</td>
        <td><img src="data:image/webp;base64,${key.imagen}" class="imagen" alt=""></td>
        
        <td><button>Modificar</button></td>
        <td><button>Eliminar</button></td>
        </tr>`
        }
        tabla += `</tbody>`
        lista.innerHTML = tabla;
    }

}
/**
 * Esta función imprimirá una tabla con los comentarios realizados por todos los usuarios
 * @param datos contendra los datos necesarios para la lista.
 */
export function imprimirListaComentariosGlobal(datos) {
    if (Object.values(datos.comentariosGlobal).length == 0) {
        let main = document.getElementById("main");
        main.innerHTML = `<div id="vacio"><p>No hay  ningún comentario todavía</p></div>`;
    } else {
        const lista = document.getElementById("listado");
        let tabla = `<thead>
        <tr>
            <th>Mensaje</th>
            <th>Valoración</th>
            <th>Fecha</th>
            <th>Producto</th>
            <th>Comprador</th>
            <th>Modificar</th>
            <th>Eliminar</th>
        </tr>
    </thead><tbody>`;
        for (const key of datos.comentariosGlobal) {
            tabla += `<tr>
        <td>${key.mensaje}</td>
        <td>${key.valoracion}</td>
        <td>${key.fecha}</td>
        <td>${key.ID_Producto}</td>
        <td>${key.nombreComprador}</td>
        
        <td><button>Modificar</button></td>
        <td><button>Eliminar</button></td>
        </tr>`
        }
        tabla += `</tbody>`
        lista.innerHTML = tabla;
    }

}
/**
 * Esta función imprimirá una tabla con los usuarios.
 * @param datos contendra los datos necesarios para la lista.
 */
export function imprimirListaUsuarios(datos) {
    
    const boton = document.getElementById("botonAgregar");
    if (Object.values(datos.usuarios).length == 0) {
        let main = document.getElementById("main");
        main.innerHTML = `<div id="vacio"><p>No hay  ningún Usuario todavía</p><button id="agregar">Añadir Usuario</button></div>`;
    }
    else {
        const lista = document.getElementById("listado");
        let tabla = `<thead>
        <tr>
            <th>Usuario</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Usuario</th>
            <th>Dirección</th>
            <th>Ciudad</th>
            <th>Provincia</th>
            <th>Código Postal</th>
            <th>email</th>
            <th>DNI</th>
            <th>Rol</th>
            <th>Modificar</th>
            <th>Eliminar</th>
        </tr>
    </thead><tbody>`;
        for (const key of datos.usuarios) {
            tabla += `<tr>
        <td>${key.usuario}</td>
        <td>${key.nombre}</td>
        <td>${key.apellido}</td>
        <td>${key.nickname}</td>
        <td>${key.direccion}</td>
        <td>${key.ciudad}</td>
        <td>${key.provincia}</td>
        <td>${key.cpostal}</td>
        <td>${key.email}</td>
        <td>${key.dni}</td>
        <td>${key.rol}</td>
        <td><button>Modificar</button></td>
        <td><button>Eliminar</button></td>
        </tr>`
        }
        tabla += `</tbody>`
        lista.innerHTML = tabla;
        boton.innerHTML = `<button id="agregar">Añadir Usuario</button>`
    }

}
/**
 * Esta función imprimirá una tabla con los roles .
 * @param datos contendra los datos necesarios para la lista.
 */
export function imprimirListaRoles(datos) {
    
    
    if (Object.values(datos.roles).length == 0) {
        let main = document.getElementById("main");
        main.innerHTML = `<div id="vacio"><p>No hay  ningún rol todavía</p><button id="agregar">Añadir Rol</button></div>`;
    }
    else {
        const boton = document.getElementById("botonAgregar");
        const lista = document.getElementById("listado");
        let tabla = `<thead>
        <tr>
            <th>ID</th>
            <th>Rol</th>
            <th>Modificar</th>
            <th>Eliminar</th>
        </tr>
        </thead><tbody>`;
        for (const key of datos.roles) {
            tabla += `<tr>
        <td>${key.ID}</td>
        <td>${key.Rol}</td>
        <td><button>Modificar</button></td>
        <td><button>Eliminar</button></td>
        </tr>`
        }
        tabla += `</tbody>`;
        lista.innerHTML = tabla;
        boton.innerHTML = `<button id="agregar">Añadir Rol</button>`
    }

}
/**
 * Esta función imprimirá una tabla con los todos los productos.
 * @param datos contendra los datos necesarios para la lista.
 */
export function imprimirListaProductosGlobal(datos) {
    
    const boton = document.getElementById("botonAgregar");
    if (Object.values(datos.productosGlobal).length == 0) {
        let main = document.getElementById("main");
        main.innerHTML = `<div id="vacio"><p>No hay  ningún producto todavía</p>
        <button id="agregar">Añadir Producto</button></div>`;
     
    }
    else {
        const lista = document.getElementById("listado");
        let tabla = `<thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Comentarios</th>
            <th>Valoraciones</th>
            <th>imagenes</th>
            <th>precio</th>
            <th>Stock</th>
            <th>descuento</th>
            <th>Id Agricultor</th>
            <th>Modificar</th>
            <th>eliminar</th>
        </tr>
    </thead><tbody>`;
        for (const key of datos.productosGlobal) {
            tabla += `<tr>
        <td>${key.id}</td>
        <td>${key.nombre_producto}</td>
        <td>${key.descripcion}</td>
        <td>${key.comentarios_totales}</td>
        <td>${key.valoracion_total}</td>
        <td><img src="data:image/webp;base64,${key.imagen}" class="imagen" alt=""></td>
        <td>${key.precio}</td>
        <td>${key.stock}</td>
        <td>${key.descuento}</td>
        <td>${key.Id_Vendedor}</td>
        <td><button>Modificar</button></td>
        <td><button>Eliminar</button></td>
        </tr>`
        }
        tabla += `</tbody>`;
        lista.innerHTML = tabla;
        boton.innerHTML = `<button id="agregar">Añadir Producto</button>`

    }
}
/**
 * Esta función imprimirá una tabla con los productos del agricultor.
 * @param datos contendra los datos necesarios para la lista.
 */
export function imprimirListaProductosPropio(datos) {
    
   
    if (Object.values(datos.productosPropio).length == 0) {
        let main = document.getElementById("main");
        main.innerHTML = `<div id="vacio"><p>No hay  ningún producto todavía</p>
        <button id="agregar">Añadir Producto</button></div>`;
    }
    else {
        const lista = document.getElementById("listado");
        const boton = document.getElementById("botonAgregar");
        let tabla = `<thead>
        <tr>
            <th style="display:none">ID</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Comentarios</th>
            <th>Valoraciones</th>
            <th>imagenes</th>
            <th>precio</th>
            <th>Stock</th>
            <th>descuento</th>
            <th>Modificar</th>
            <th>eliminar</th>
        </tr>
    </thead><tbody>`;
        for (const key of datos.productosPropio) {
            tabla += `<tr>
        <td style="display:none">${key.id}</td>    
        <td>${key.nombre_producto}</td>
        <td>${key.descripcion}</td>
        <td>${key.comentarios_totales}</td>
        <td>${key.valoracion_total}</td>
        <td><img src="data:image/webp;base64,${key.imagen}" class="imagen" alt=""></td>
        <td>${key.precio}</td>
        <td>${key.stock}</td>
        <td>${key.descuento}</td>
        <td><button>Modificar</button></td>
        <td><button>Eliminar</button></td>
        </tr>`
        }
        tabla += `</tbody>`;
        lista.innerHTML = tabla;
        boton.innerHTML = `<button id="agregar">Añadir Producto</button>`

    }
}
/**
 * Esta función imprimirá una tabla con los permisos.
 * @param datos contendra los datos necesarios para la lista.
 */
export function imprimirListaPermisos(datos) {
    const boton = document.getElementById("botonAgregar");
    if (Object.values(datos.permisos).length == 0) {
        let main = document.getElementById("main");
        main.innerHTML = `<div id="vacio"><p>No hay  ningún permiso todavía</p> <button id="agregar">Añadir Permiso</button></div>`;
        
      
    }
    else {
    const lista = document.getElementById("listado");
    let tabla = `<thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Código</th>
            <th>Acción</th>
            <th>Permitido a</th>
            <th style="display:none">ID ROL </th>
            <th>Modificar</th>
            <th>eliminar</th>
        </tr>
    </thead><tbody>`;
    for (const key of datos.permisos) {
        tabla += `<tr>
        <td>${key.id_permiso}</td>
        <td>${key.nombre}</td>
        <td>${key.descripcion}</td>
        <td>${key.codigo}</td>
        <td>${key.accion}</td>
        <td>${key.roles}</td>
        <td style="display:none">${key.idRol}</td>
        <td><button>Modificar</button></td>
        <td><button>Eliminar</button></td>
        </tr>`
    }
    tabla += `</tbody>`;
    lista.innerHTML = tabla;
    boton.innerHTML = `<button id="agregar">Añadir Permiso</button>`
    }
}
/**
* Esta función imprimirá una tabla con todos los pedidos.
 * @param datos contendra los datos necesarios para la lista.
 */
export function imprimirListaPedidos(datos) {
    if (Object.values(datos.listaPedidos).length == 0) {
        let main = document.getElementById("main");
        main.innerHTML = `<div id="vacio"><p>No hay  ningún pedido todavía</p></div>`;
    }
    else {
    const lista = document.getElementById("listado");
    let tabla = `<thead>
        <tr>
            <th>Número pedido</th>
            <th>Fecha Realizado</th>
            <th>Total</th>
            <th>Id Comprador</th>
            <th>Estado</th>
            <th>Modificar</th>
            <th>eliminar</th>
        </tr>
    </thead><tbody>`;
    for (const key of datos.listaPedidos) {
        console.log("entro");
        tabla += `<tr>
        <td>${key.idPedido}</td>
        <td>${key.fechaRealizado}</td>
        <td>${key.total}</td>
        <td>${key.IDComprador}</td>
        <td>${key.estado}</td>
        <td><button>Modificar</button></td>
        <td><button>Eliminar</button></td>
        </tr>`
    }
    tabla += `</tbody>`;
    lista.innerHTML = tabla;
    }
}
/**
 * Esta función imprimirá una tabla con los pedidos del usuario.
 * @param datos contendra los datos necesarios para la lista.
 */
export function imprimirListaPedidosUsuario(datos) {
    if (Object.values(datos.listaPedidosUsuario).length == 0) {
        let main = document.getElementById("main");
        main.innerHTML = `<div id="vacio"><p>No ha realizado ningún pedido todavía</p></div>`;
    }
    else {
    const lista = document.getElementById("listado");

    let tabla = `<thead>
        <tr>
            <th>Número pedido</th>
            <th>Fecha Realización</th>
            <th>Total</th>
            <th>Estado</th>
        </tr>
    </thead><tbody>`;
    for (const key of datos.listaPedidosUsuario) {
        tabla += `<tr>
        <td>${key.idPedido}</td>
        <td>${key.fechaRealizado}</td>
        <td>${key.total}</td>
        <td>${key.estado}</td>
        </tr>`
    }
    tabla += `</tbody>`;
    lista.innerHTML = tabla;
    }
}
/**
* Esta función imprimirá una tabla con los envios que debe realizar el agricultor.
 * @param datos contendra los datos necesarios para la lista.
 */
export function imprimirEnvios(datos) {
    if (Object.values(datos.envios).length == 0) {
        let main = document.getElementById("main");
        main.innerHTML = `<div id="vacio"><p>No hay  ningún envío todavía</p></div>`;
    }
    else {
    const lista = document.getElementById("listado");
    let tabla = `<thead>
        <tr>
            
            <th>Nombre producto</th>
            <th>Cantidad</th>
            <th>Estado</th>
            <th>Fecha Envio</th>
            <th>Fecha entrega</th>
            <th>Nombre Comprador</th>
            <th>Direccion Comprador</th>
            <th style="display:none">Id Pedido</th>
            <th style="display:none">Id Producto</th>
            <th>Modificar</th>
            <th>eliminar</th>
        </tr>
    </thead><tbody>`;
    for (const key of datos.envios) {
        tabla += `<tr>
        <td>${key.nombreProducto}</td>
        <td>${key.cantidad}</td>
        <td>${key.estado}</td>
        <td>${comprobarFecha(key.fechaEnvio)}</td>
        <td>${comprobarFecha(key.fechaLlegada)}</td>
        <td>${key.nombreComprador}</td>
        <td>${key.direccionComprador}</td>
        <td style="display:none">${key.IDPedido}</td>
        <td style="display:none">${key.IDProducto}</td>
        <td><button>Modificar</button></td>
        <td><button>Eliminar</button></td>
        </tr>`
    }
    tabla += `</tbody>`;
    lista.innerHTML = tabla;
}
}
/**
* Esta función imprimirá una tabla con todos los envios.
 * @param datos contendra los datos necesarios para la lista.
 */
export function imprimirEnviosGlobal(datos) {
    if (Object.values(datos.enviosGlobal).length == 0) {
        let main = document.getElementById("main");
        main.innerHTML = `<div id="vacio"><p>No hay  ningún envío todavía</p></div>`;
    }
    else {
    const lista = document.getElementById("listado");
    let tabla = `<thead>
        <tr>
            
            <th>Nombre producto</th>
            <th>Cantidad</th>
            <th>Estado</th>
            <th>Fecha Envio</th>
            <th>Fecha entrega</th>
            <th>Nombre Comprador</th>
            <th>Direccion Comprador</th>
            <th >Id Pedido</th>
            <th >Id Producto</th>
            <th>Modificar</th>
            <th>eliminar</th>
        </tr>
    </thead><tbody>`;
    for (const key of datos.enviosGlobal) {
        tabla += `<tr>
        <td>${key.nombreProducto}</td>
        <td>${key.cantidad}</td>
        <td>${key.estado}</td>
        <td>${comprobarFecha(key.fechaEnvio)}</td>
        <td>${comprobarFecha(key.fechaLlegada)}</td>
        <td>${key.nombreComprador}</td>
        <td>${key.direccionComprador}</td>
        <td >${key.IDPedido}</td>
        <td >${key.IDProducto}</td>
        <td><button>Modificar</button></td>
        <td><button>Eliminar</button></td>
        </tr>`
    }
    tabla += `</tbody>`;
    lista.innerHTML = tabla;
}
}
/**
* Esta función imprimirá una tabla con las noticias.
 * @param datos contendra los datos necesarios para la lista.
 */
export function imprimirListaNotcias(datos) {
    
    const boton = document.getElementById("botonAgregar");
    if (Object.values(datos.noticias).length == 0) {
        let main = document.getElementById("main");
        main.innerHTML = `<div id="vacio"><p>No hay  ninguna noticia todavía</p><button id="agregar">Añadir Noticia</button></div>`;
        
    }
    else {
    const lista = document.getElementById("listado");
    let tabla = `<thead>
        <tr>
            <th>ID Noticia</th>
            <th>Título</th>
            <th>Subtítulo</th>
            <th>imagen</th>
            <th>fecha</th>
            <th>cuerpo </th>
            <th>Modificar</th>
            <th>eliminar</th>
        </tr>
    </thead><tbody>`;
    for (const key of datos.noticias) {
        tabla += `<tr>
        <td>${key.IDNoticia}</td>
        <td>${key.titulo}</td>
        <td>${key.subtitulo}</td>
        <td><img src="data:image/webp;base64,${key.imagen}" class="imagen" alt=""></td>
        <td>${key.fecha}</td>
        <td>${key.cuerpo}</td>
        <td><button>Modificar</button></td>
        <td><button>Eliminar</button></td>
        </tr>`
    }
    tabla += `</tbody>`;
    lista.innerHTML = tabla;
    boton.innerHTML = `<button id="agregar">Añadir Noticia</button>`
}
}
/**
* Esta función imprimirá una tabla con todos los productos comprador por parte del usuario
 * @param datos contendra los datos necesarios para la lista.
 */
export function imprimirHistorial(datos) {
    if (Object.values(datos.historial).length == 0) {
        let main = document.getElementById("main");
        main.innerHTML = `<div id="vacio"><p>No hay  ningún pedido en el historial todavía</p></div>`;
    }
    else {
    const lista = document.getElementById("listado");
    let tabla = `<thead>
        <tr>
            <th>Número pedido</th>
            <th>Nombre producto</th>
            <th>Precio unidad</th>
            <th>Cantidad</th>
            <th>Total</th>
            <th>Envio</th>
            <th>Recepción</th>
        </tr>
    </thead><tbody>`;
    for (const key of datos.historial) {
        console.log(typeof key.fechaLlegada);
        console.log(comprobarFecha(key.fechaLlegada));
        tabla += `<tr>
        <td>${key.pedido}</td>
        <td>${key.nombre}</td>
        <td>${key.precio}</td>
        <td>${key.cantidad}</td>
        <td>${key.total}</td>
        <td>${comprobarFecha(key.fechaEnvio)}</td>
        <td>${comprobarFecha(key.fechaLlegada)}</td>
        </tr>`
    }
    tabla += `</tbody>`;
    lista.innerHTML = tabla;
}
}
/**
* Esta función imprimirá una tabla con los mensajes enviados al administrador.
 * @param datos contendra los datos necesarios para la lista.
 */
export function imprimirMensajes(datos){
    if (Object.values(datos.listaMensajes).length == 0) {
        let main = document.getElementById("main");
        main.innerHTML = `<div id="vacio"><p>No hay  ningún Mensaje que pueda leer</p></div>`;
    }
    else {
    const lista = document.getElementById("listado");
    let tabla = `<thead>
        <tr>
            <th>ID</th>
            <th>Asunto</th>
            <th>Mensaje</th>
            <th>Fecha</th>
            <th>Correo Electrónico</th>
            <th>Usuario</th>
            <th>Estado</th>
            <th>Contestar</th>
        </tr>
    </thead><tbody>`;
    for (const key of datos.listaMensajes) {
        let fecha = new Date(key.fechaEnvio);
        let usuario="";
        if(key.usuario==0){
            usuario="Desconocido";
        }
        else{
            usuario=key.usuario;
        }
        tabla += `<tr>
        <td>${key.id}</td>
        <td>${key.asunto}</td>
        <td>${key.mensaje}</td>
        <td>${fecha.getDate()}/${fecha.getMonth() + 1}/${fecha.getFullYear()}</td>
        <td>${key.email}</td>
        <td>${usuario}</td>
        <td>${key.estado}</td>
        <td><button>Contestar</button></td>
        </tr>`
    }
    tabla += `</tbody>`;
    lista.innerHTML = tabla;
}
}