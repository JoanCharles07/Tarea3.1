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
export function imprimirListaComentariosPropio(datos) {
    console.log(datos);
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

export function imprimirListaUsuarios(datos) {
    
    const boton = document.getElementById("botonAgregar");
    if (Object.values(datos.usuarios).length == 0) {
        let main = document.getElementById("main");
        main.innerHTML = `<div id="vacio"><p>No hay  ningún Usuario todavía</p><button>Añadir Usuario</button></div>`;
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
        boton.innerHTML = `<button>Añadir Usuario</button>`
    }

}

export function imprimirListaRoles(datos) {
    
    
    if (Object.values(datos.roles).length == 0) {
        let main = document.getElementById("main");
        main.innerHTML = `<div id="vacio"><p>No hay  ningún rol todavía</p><button>Añadir Rol</button></div>`;
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
        boton.innerHTML = `<button>Añadir Rol</button>`
    }

}

export function imprimirListaProductosGlobal(datos) {
    
    const boton = document.getElementById("botonAgregar");
    if (Object.values(datos.productosGlobal).length == 0) {
        let main = document.getElementById("main");
        main.innerHTML = `<div id="vacio"><p>No hay  ningún producto todavía</p>
        <button>Añadir Producto</button></div>`;
     
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
        boton.innerHTML = `<button>Añadir Producto</button>`

    }
}
export function imprimirListaProductosPropio(datos) {
    
   
    if (Object.values(datos.productosPropio).length == 0) {
        let main = document.getElementById("main");
        main.innerHTML = `<div id="vacio"><p>No hay  ningún producto todavía</p>
        <button>Añadir Producto</button></div>`;
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
        boton.innerHTML = `<button>Añadir Producto</button>`

    }
}

export function imprimirListaPermisos(datos) {
    const boton = document.getElementById("botonAgregar");
    if (Object.values(datos.permisos).length == 0) {
        let main = document.getElementById("main");
        main.innerHTML = `<div id="vacio"><p>No hay  ningún permiso todavía</p> <button>Añadir Permiso</button></div>`;
        
      
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
    boton.innerHTML = `<button>Añadir Permiso</button>`
    }
}

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
            <th>Cantidad Productos</th>
            <th>Estado</th>
            <th>Fecha envio</th>
            <th>Fecha entrega</th>
            <th>Total</th>
            <th>Id Comprador</th>
            <th>Id Vendedor</th>
            <th>Modificar</th>
            <th>eliminar</th>
        </tr>
    </thead><tbody>`;
    for (const key of datos.listaPedidos) {
        console.log("entro");
        tabla += `<tr>
        <td>${key.idPedido}</td>
        <td>${key.cantidadProductos}</td>
        <td>${key.estado}</td>
        <td>${key.fechaEnvio}</td>
        <td>${key.fechaLlegada}</td>
        <td>${key.total}</td>
        <td>${key.IDComprador}</td>
        <td>${key.IDVendedor}</td>
        <td><button>Modificar</button></td>
        <td><button>Eliminar</button></td>
        </tr>`
    }
    tabla += `</tbody>`;
    lista.innerHTML = tabla;
    }
}
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
            <th>Cantidad Productos</th>
            <th>Estado</th>
            <th>Fecha envio</th>
            <th>Fecha entrega</th>
            <th>Total</th>
        </tr>
    </thead><tbody>`;
    for (const key of datos.listaPedidosUsuario) {
        tabla += `<tr>
        <td>${key.idPedido}</td>
        <td>${key.cantidadProductos}</td>
        <td>${key.estado}</td>
        <td>${key.fechaEnvio}</td>
        <td>${key.fechaLlegada}</td>
        <td>${key.total}</td>
        </tr>`
    }
    tabla += `</tbody>`;
    lista.innerHTML = tabla;
    }
}
export function imprimirEnvios(datos) {
    if (Object.values(datos.envios).length == 0) {
        let main = document.getElementById("main");
        main.innerHTML = `<div id="vacio"><p>No hay  ningún envío todavía</p></div>`;
    }
    else {
    const lista = document.getElementById("listado");
    let tabla = `<thead>
        <tr>
            <th>Número pedido</th>
            <th>Cantidad Productos</th>
            <th>Estado</th>
            <th>Fecha envio</th>
            <th>Fecha entrega</th>
            <th>Total</th>
            <th>Id Comprador</th>
            <th>Id Vendedor</th>
            <th>Modificar</th>
            <th>eliminar</th>
        </tr>
    </thead><tbody>`;
    for (const key of datos.envios) {
        console.log("entro");
        tabla += `<tr>
        <td>${key.idPedido}</td>
        <td>${key.cantidadProductos}</td>
        <td>${key.estado}</td>
        <td>${key.fechaEnvio}</td>
        <td>${key.fechaLlegada}</td>
        <td>${key.total}</td>
        <td>${key.IDComprador}</td>
        <td>${key.IDVendedor}</td>
        <td><button>Modificar</button></td>
        <td><button>Eliminar</button></td>
        </tr>`
    }
    tabla += `</tbody>`;
    lista.innerHTML = tabla;
}
}

export function imprimirListaNotcias(datos) {
    
    const boton = document.getElementById("botonAgregar");
    if (Object.values(datos.noticias).length == 0) {
        let main = document.getElementById("main");
        main.innerHTML = `<div id="vacio"><p>No hay  ninguna noticia todavía</p><button>Añadir Noticia</button></div>`;
        
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
    boton.innerHTML = `<button>Añadir Noticia</button>`
}
}

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
            <th>Recibido</th>
        </tr>
    </thead><tbody>`;
    for (const key of datos.historial) {
        let fecha = new Date(key.fechaLlegada);
        tabla += `<tr>
        <td>${key.pedido}</td>
        <td>${key.nombre}</td>
        <td>${key.precio}</td>
        <td>${key.cantidad}</td>
        <td>${key.total}</td>
        <td>${fecha.getDate()}/${fecha.getMonth() + 1}/${fecha.getFullYear()}</td>
        </tr>`
    }
    tabla += `</tbody>`;
    lista.innerHTML = tabla;
}
}