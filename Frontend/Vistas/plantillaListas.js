export function redireccionLista(eleccion) {
    
    const datosPorURL='?eleccion=' + encodeURIComponent(eleccion);
    location.href="./listas.html" + datosPorURL;
}

export function imprimirListaComentarios(datos){
    const lista=document.getElementById("listado");
    let tabla=`<thead>
        <tr>
            <th>Mensaje</th>
            <th>Valoración</th>
            <th>Fecha</th>
            <th>Producto</th>
            <th>Modificar</th>
            <th>Eliminar</th>
        </tr>
    </thead><tbody>`;
    for (const key of datos.comentarios) {
        tabla+= `<tr>
        <td>${key.mensaje}</td>
        <td>${key.valoracion}</td>
        <td>${key.fecha}</td>
        <td>${key.ID_Producto}</td>
        <td><button>Modificar</button></td>
        <td><button>Eliminar</button></td>
        </tr>`
    }
    tabla+=`</tbody>`
    lista.innerHTML=tabla;
}

export function imprimirListaUsuarios(datos){
    const lista=document.getElementById("listado");
    let tabla=`<thead>
        <tr>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Usuario</th>
            <th>Dirección</th>
            <th>Ciudad</th>
            <th>Provincia</th>
            <th>Código Postal</th>
            <th>email</th>
            <th>DNI</th>
            <th>Modificar</th>
            <th>Eliminar</th>
        </tr>
    </thead><tbody>`;
    for (const key of datos.usuarios) {
        tabla+= `<tr>
        <td>${key.nombre}</td>
        <td>${key.apellido}</td>
        <td>${key.nickname}</td>
        <td>${key.direccion}</td>
        <td>${key.ciudad}</td>
        <td>${key.provincia}</td>
        <td>${key.cpostal}</td>
        <td>${key.email}</td>
        <td>${key.dni}</td>
        <td><button>Modificar</button></td>
        <td><button>Eliminar</button></td>
        </tr>`
    }
    tabla+=`</tbody>`
    lista.innerHTML=tabla;
}

export function imprimirListaRoles(datos){
    const lista=document.getElementById("listado");
    const boton=document.getElementById("botonAgregar");
    let tabla=`<thead>
        <tr>
            <th>ID</th>
            <th>Rol</th>
            <th>Modificar</th>
            <th>Eliminar</th>
        </tr>
    </thead><tbody>`;
    for (const key of datos.roles) {
        tabla+= `<tr>
        <td>${key.ID}</td>
        <td>${key.Rol}</td>
        <td><button>Modificar</button></td>
        <td><button>Eliminar</button></td>
        </tr>`
    }
    tabla+=`</tbody>`;
    lista.innerHTML=tabla;
    boton.innerHTML=`<button>Añadir Rol</button>`
}

export function imprimirListaProductos(datos){
    const lista=document.getElementById("listado");
    const boton=document.getElementById("botonAgregar");
    let tabla=`<thead>
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
    for (const key of datos.productos) {
        tabla+= `<tr>
        <td>${key.id}</td>
        <td>${key.nombre_producto}</td>
        <td>${key.descripcion}</td>
        <td>${key.comentarios_totales}</td>
        <td>${key.valoracion_total}</td>
        <td>${key.imagen}</td>
        <td>${key.precio}</td>
        <td>${key.stock}</td>
        <td>${key.descuento}</td>
        <td>${key.Id_Vendedor}</td>
        <td><button>Modificar</button></td>
        <td><button>Eliminar</button></td>
        </tr>`
    }
    tabla+=`</tbody>`;
    lista.innerHTML=tabla;
    boton.innerHTML=`<button>Añadir Producto</button>`
}

export function imprimirListaPermisos(datos){
    console.log(datos.permisos);
    const lista=document.getElementById("listado");
    const boton=document.getElementById("botonAgregar");
    let tabla=`<thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Código</th>
            <th>Acción</th>
            <th>Modificar</th>
            <th>eliminar</th>
        </tr>
    </thead><tbody>`;
    for (const key of datos.permisos) {
        tabla+= `<tr>
        <td>${key.id_permiso}</td>
        <td>${key.nombre}</td>
        <td>${key.descripcion}</td>
        <td>${key.codigo}</td>
        <td>${key.accion}</td>
        <td><button>Modificar</button></td>
        <td><button>Eliminar</button></td>
        </tr>`
    }
    tabla+=`</tbody>`;
    lista.innerHTML=tabla;
    boton.innerHTML=`<button>Añadir Producto</button>`
}