export function modificacionComentariosGlobales(arrayDatos) {

    let Form = document.getElementById("formulario");
    let texto = `
        <span id="errorBBDD"></span>
        <label for="mensaje">Mensaje</label>
        <input type="text" id="mensaje" name="mensaje" value="${arrayDatos[0]}" title="Mensaje no valido"/>
        <span id="errorMensaje"></span>
        <label for="valoracion">Valoracion</label>
        <input type="text" id="valoracion" name="valoracion" value="${arrayDatos[1]}" title="Estrellas no válidas" />
        <span id="errorValoracion"></span>
        <label for="fecha">Fecha Publicación</label>
        <input type="date" id="fecha" name="fecha" placeholder="YYYY-MM-DD" value="${arrayDatos[2]}" title="Fecha no válida"/>
        <span id="errorFecha"></span>
        <input type="text" id="id"  name="id" value="${arrayDatos[3]}"/>
        <input type="text" id="comprador"  name="comprador" value="${arrayDatos[4]}"/>
        <input type="text" id="opcion"  name="opcion" value="${arrayDatos[arrayDatos.length - 1]}"/>
        <input type="submit" class="botonSubmit" name="submit" value="Modificar"/>`;
    Form.innerHTML = texto;
    document.getElementById("id").style.display = "none";
    document.getElementById("opcion").style.display = "none";
    document.getElementById("comprador").style.display = "none";
}

export function modificacionComentariosPropios(arrayDatos) {
    let Form = document.getElementById("formulario");
    let texto = `
        <span id="errorBBDD"></span>
        <label for="mensaje">Mensaje</label>
        <input type="text" id="mensaje" name="mensaje" value="${arrayDatos[0]}"/>
        <span id="errorMensaje"></span>
        <label for="valoracion">Valoracion</label>
        <span id="errorValoracion"></span>
        <input type="text" id="valoracion" name="valoracion" value="${arrayDatos[1]}" />
        <input type="text" id="opcion"  name="opcion" value="${arrayDatos[arrayDatos.length - 1]}"/>
        <input type="text" id="id"  name="id" value="${arrayDatos[0]}"/>
        <input type="submit" class="botonSubmit" name="submit" value="Modificar"/>`;
    Form.innerHTML = texto;
    document.getElementById("id").style.display = "none";
    document.getElementById("opcion").style.display = "none";
}
/**En este caso solo se puede cambiar el estado y segun el estado se pondra una fecha de envio
 * y fecha de entrega.
 */
export function modificacionPedido(arrayDatos) {
    let Form = document.getElementById("formulario");
    let texto = `
        <span id="errorBBDD"></span>
        <label for="estado">Estado del Pedido</label>
        <select name="estado">
            <option value="Tramitando" selected>Tramitando</option>
            <option value="Enviado" >Enviado</option>
            <option value="Recibido">Recibido</option>
        </select>
        <input type="text" id="opcion"  name="opcion" value="${arrayDatos[arrayDatos.length - 1]}"/>
        <input type="text" id="pedido"  name="pedido" value="${arrayDatos[0]}"/>
        <input type="submit" class="botonSubmit" name="submit" value="Modificar"/>`;
    Form.innerHTML = texto;
    document.getElementById("pedido").style.display = "none";
    document.getElementById("opcion").style.display = "none";
}



export function modificacionNoticias(arrayDatos) {
    let Form = document.getElementById("formulario");
    let texto = `
        <span id="errorBBDD"></span>
        <label for="titulo">Título</label>
        <input type="text" id="titulo" name="titulo" value="${arrayDatos[0]}"/>
        <span id="errorTitulo"></span>
        <label for="subtitulo">Subtítulo</label>
        <input type="text" id="subtitulo" name="subtitulo" value="${arrayDatos[1]}"/>
        <span id="errorSub"></span>
        <label for="imagen">Imagen</label>
        <input type="file" id="imagen" name="imagen" accept=".png, .jpg, .webp" />
        <span id="errorImagen"></span>
        <label for="fecha">Fecha Publicación</label>
        <input type="date" id="fecha" name="fecha" placeholder="YYYY-MM-DD" value="${arrayDatos[3]}" title="Fecha no válida"/>
        <span id="errorFecha"></span>
        <label for="cuerpo">Cuerpo</label>
        <textarea  cols="30" rows="5" id="cuerpo" name="cuerpo" form="formulario">${arrayDatos[4]}</textarea>
        <span id="errorCuerpo"></span>
        <input type="text" id="id" name="id"  value="${arrayDatos[arrayDatos.length - 2]}" />
        <input type="text" id="opcion"  name="opcion" value="${arrayDatos[arrayDatos.length - 1]}"/>
        <input type="submit" class="botonSubmit" name="submit" value="Modificar"/>`;
    Form.innerHTML = texto;
    document.getElementById("id").style.display = "none";
    document.getElementById("opcion").style.display = "none";
}

export function modificacionCorrecta(datosServidor) {
    let main = document.getElementById("main");
    main.innerHTML = `<div id="vacio"><p>Se ha realizado la modificación</p></div>`;
    const intervalID = setInterval(function () {
        //Borramos productos para que se actualizen los datos si productos fuera alterado, por no complicar mas el codigo
        if(datosServidor.datosUsuario){
            sessionStorage.setItem("usuario",btoa(JSON.stringify(datosServidor.datosUsuario)));
        }
        sessionStorage.removeItem("productos");
        location.href="./tienda.html";
    }, 1500);

}

export function modificacionUsuarioPropio(arrayDatos) {
    let Form = document.getElementById("formulario");
    let texto = `
        <span id="errorBBDD"></span>
        <label for="Nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" value="${arrayDatos[0]}"/>
        <span id="errorNombre"></span>

        <label for="apellidos">Apellidos</label>
        <input type="text" id="apellidos" name="apellidos" value="${arrayDatos[1]}"/>
        <span id="errorApellidos"></span>
        
        <label for="nickname">Usuario</label>
        <input type="text" id="nickname" name="nickname" value="${arrayDatos[2]}"/>
        <span id="errorUsuario"></span>
        <label for="direccion">Dirección</label>
        <input type="text" id="direccion" name="direccion" value="${arrayDatos[3]}"/>
        <span id="errordireccion"></span>

        <label for="ciudad">Ciudad</label>
        <input type="text" id="Ciudad" name="ciudad" value="${arrayDatos[4]}" />
        <span id="errorCiudad"></span>
        
        <label for="provincia">Provincia</label>
        <input type="text" id="provincia" name="provincia" value="${arrayDatos[5]}" />
        <span id="errorProvincia"></span>

        <label for="cpostal">Código Postal</label>
        <input type="text" id="cpostal" name="cpostal" value="${arrayDatos[6]}" />
        <span id="errorCpostal"></span>

        <label for="email">Correo Electrónico</label>
        <input type="text" id="email" name="email" value="${arrayDatos[7]}" />
        <span id="erroremail"></span>

        <label for="dni">Código DNI</label>
        <input type="text" id="dni" name="dni" value="${arrayDatos[8]}" />
        <span id="errorDNI"></span>

        <input type="text" id="opcion"  name="opcion" value="${arrayDatos[arrayDatos.length - 1]}"/>
        <input type="submit" class="botonSubmit" name="submit" value="Modificar"/>`;
    Form.innerHTML = texto;
   
    document.getElementById("opcion").style.display = "none";
}
export function modificacionUsuarioGlobal(arrayDatos) {
    let Form = document.getElementById("formulario");
    let texto = `
        <span id="errorBBDD"></span>
        <label for="Nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" value="${arrayDatos[1]}"/>
        <span id="errorNombre"></span>

        <label for="apellidos">Apellidos</label>
        <input type="text" id="apellidos" name="apellidos" value="${arrayDatos[2]}"/>
        <span id="errorApellidos"></span>
        
        <label for="nickname">Usuario</label>
        <input type="text" id="nickname" name="nickname" value="${arrayDatos[3]}"/>
        <span id="errorUsuario"></span>
        <label for="direccion">Dirección</label>
        <input type="text" id="direccion" name="direccion" value="${arrayDatos[4]}"/>
        <span id="errordireccion"></span>

        <label for="ciudad">Ciudad</label>
        <input type="text" id="Ciudad" name="ciudad" value="${arrayDatos[5]}" />
        <span id="errorCiudad"></span>
        
        <label for="provincia">Provincia</label>
        <input type="text" id="provincia" name="provincia" value="${arrayDatos[6]}" />
        <span id="errorProvincia"></span>

        <label for="cpostal">Código Postal</label>
        <input type="text" id="cpostal" name="cpostal" value="${arrayDatos[7]}" />
        <span id="errorCpostal"></span>

        <label for="email">Correo Electrónico</label>
        <input type="text" id="email" name="email" value="${arrayDatos[8]}" />
        <span id="erroremail"></span>

        <label for="dni">Código DNI</label>
        <input type="text" id="dni" name="dni" value="${arrayDatos[9]}" />
        <span id="errorDNI"></span>

        <label for="rol">ROL</label>
        <input type="text" id="IDrol" name="IDrol" value="${arrayDatos[10]}" />
        <span id="errorRol"></span>



        <input type="text" id="opcion"  name="opcion" value="${arrayDatos[arrayDatos.length - 1]}"/>
        <input type="text" id="id"  name="id" value="${arrayDatos[arrayDatos.length - 2]}"/>
        <input type="submit" class="botonSubmit" name="submit" value="Modificar"/>`;
    Form.innerHTML = texto;
    document.getElementById("id").style.display = "none";
    document.getElementById("opcion").style.display = "none";
}

export function modificacionRol(arrayDatos) {
    let Form = document.getElementById("formulario");
    let texto = `
        <span id="errorBBDD"></span>
        <label for="nombreRol">Nombre del rol</label>
        <input type="text" id="nombreRol"  name="nombreRol" value="${arrayDatos[1]}"/>
        <input type="text" id="opcion"  name="opcion" value="${arrayDatos[arrayDatos.length - 1]}"/>
        <input type="text" id="IDrol"  name="IDrol" value="${arrayDatos[0]}"/>
        <input type="submit" class="botonSubmit" name="submit" value="Modificar"/>`;
    Form.innerHTML = texto;
    document.getElementById("IDrol").style.display = "none";
    document.getElementById("opcion").style.display = "none";
}

export function modificacionPermisos(arrayDatos) {
    let Form = document.getElementById("formulario");
    let texto = `
        <span id="errorBBDD"></span>
        <label for="nombre">Nombre permiso</label>
        <input type="text" id="nombre"  name="nombrePermiso" value="${arrayDatos[1]}"/>
        <label for="descripcion">Descripción</label>
        <input type="text" id="descripcion"  name="descripcion" value="${arrayDatos[2]}"/>
        <label for="codigo">Código</label>
        <input type="text" id="codigo"  name="codigo" value="${arrayDatos[3]}"/>
        <label for="accion">Acción</label>
        <select name="cambiarAccion">
            <option value="leer" selected>Leer</option>
            <option value="Modificar" >Modificar</option>
            <option value="crear">Crear</option>
            <option value="borrar">Borrar</option>
        </select>
        <label for="rol">Roles Permitidos</label>
        <select name="Tipo">
            <option value="Usuario" selected>Usuario</option>
            <option value="Agricultor" >Agricultor</option>
            <option value="Administrador">Administrador</option>
        </select>
        <input type="text" id="opcion"  name="opcion" value="${arrayDatos[arrayDatos.length - 1]}"/>
        <input type="text" id="IDrol"  name="IDrol" value="${arrayDatos[arrayDatos.length - 2]}"/>
        <input type="text" id="id"  name="id" value="${arrayDatos[0]}"/>
        <input type="submit" class="botonSubmit" name="submit" value="Modificar"/>`;
    Form.innerHTML = texto;
    document.getElementById("id").style.display = "none";
    document.getElementById("IDrol").style.display = "none";
    document.getElementById("opcion").style.display = "none";
}

export function modificacionProductos(arrayDatos) {
    let Form = document.getElementById("formulario");
    let texto = `
        <span id="errorBBDD"></span>
        <label for="nombre">Nombre Producto</label>
        <input type="text" id="nombre"  name="nombre" value="${arrayDatos[1]}"/>
        <label for="descripcion">Descripción Producto</label>
        <input type="text" id="descripcion"  name="descripcion" value="${arrayDatos[2]}"/>
        <label for="imagen">Imagen</label>
        <input type="file" id="imagen" name="imagen" accept=".png, .jpg, .webp" "/>
        <label for="precio">Precio</label>
        <input type="number" step=".01" id="precio"  name="precio" value="${arrayDatos[6]}"/>
        <label for="stock">Stock</label>
        <input type="number" min="0"  id="stock"  name="stock" value="${arrayDatos[7]}"/>
        <label for="descuento">Descuento</label>
        <input type="number" min="0" max="100"  id="descuento"  name="descuento" value="${arrayDatos[8]}"/>
        <input type="text" id="opcion"  name="opcion" value="${arrayDatos[arrayDatos.length - 1]}"/>
        <input type="text" id="id"  name="id" value="${arrayDatos[0]}"/>
        <input type="submit" class="botonSubmit" name="submit" value="Modificar"/>`;
    Form.innerHTML = texto;
    document.getElementById("id").style.display = "none";
    document.getElementById("opcion").style.display = "none";
}
