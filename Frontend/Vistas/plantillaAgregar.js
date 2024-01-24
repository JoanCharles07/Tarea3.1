/**
 * Esta función imprimirá un formulario para añadir un nuevo rol
 */

export function agregarRol() {
    let formulario = document.getElementById("formulario");
    let texto = `
    <span id="errorBBDD"></span>
    <label for="nombreRol">Inserte nuevo  Rol</label> 
    <input type="text" id="nombreRol" name="nombreRol">
    <span id="errorRol"></span>
    <input type="text" id="opcion" name="opcion" value="Lista roles">
    <input type="submit" class="botonSubmit" value="Añadir Rol">`;
    formulario.innerHTML = texto;
    document.getElementById("opcion").style.display = "none";
}
/**
 * Esta función imprimirá un formulario para añadir un nuevo usuario
 */
export function agregarUsuario() {
    let formulario = document.getElementById("formulario");
    let texto = `<form id="formulario" action="" method="post" enctype="application/x-www-form-urlencoded">
    <span id="errorBBDD"></span>
    <label for="usuarioNuevo">Usuario</label>
    <input type="text" name="usuarioNuevo" id="usuarioNuevo" required minlength="4" maxlength="25" 
    title="Usuario no válido">
    <span id="errorU"></span>
    <label for="pass">Contraseña</label>
    <input type="password" name="pass" id="pass" required minlength="4" maxlength="25" 
    title="Contraseña no válida">
    <span id="errorP"></span>
    <label for="pass2">Repetir Contraseña</label>
    <input type="password" name="pass2" id="pass2" required minlength="4" maxlength="25" 
    title="Contraseña no válida">
    <span id="errorP2"></span>
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre" required minlength="4" maxlength="25" 
    title="Nombre no válido">
    <span id="errorN"></span>
    <label for="apellidos">Apellidos</label>
    <input type="text" name="apellidos" id="apellidos" required minlength="4" maxlength="50"
    title="Apellidos no válidos">
    <span id="errorA"></span>
    <label for="direccion">Dirección</label>
    <input type="text" name="direccion" id="direccion" required minlength="4" maxlength="25"
    title="Dirección no válido">
    <span id="errorD"></span>
    <label for="provincia">Provincia</label>
    <input type="text" name="provincia" id="provincia" required minlength="4" maxlength="25"
    title="Provincia no válida">
    <span id="errorProvincia"></span>
    <label for="ciudad">Ciudad</label>
    <input type="text" name="ciudad" id="ciudad" required minlength="4" maxlength="25"
    title="Ciudad no válida">
    <span id="errorCiudad"></span>
    <label for="cpostal">Código Postal</label>
    <input type="text" name="cpostal" id="cpostal" required minlength="5" maxlength="5"
    pattern="^[0-9]{3,5}$"
    title="Solo compuesto por 5 números">
    <span id="errorCpostal"></span>
    <label for="email">Email</label>
    <input type="email" name="email" id="email" required minlength="4" maxlength="25"
     pattern="(?!.*delete)(?!.*select)(?!.*insert)(?!.*update)(?!.*null)(^.{4,25}$)"
     title="Emailno válido">
    <span id="errorE"></span>
    <label for="DNI">DNI</label>
    <input type="text" name="DNI" id="DNI" required minlength="9" maxlength="9"
    pattern="^[0-9]{8}[A-Za-z]$"
    title="Debe tener 8 digitos y una letra">
    <span id="errorDNI"></span>
    <label for="rol">¿Que desea ser?</label>
    <select name="nombreRol" id="rol" required>
        <option value="usuario" selected>Usuario</option>
        <option value="agricultor">Agricultor</option>
    </select>
    <input type="text" id="opcion" name="opcion" value="Lista usuarios">
    <input class="botonSubmit" type="submit" value="Crear Usuario">
</form>`;
    formulario.innerHTML = texto;
    document.getElementById("opcion").style.display = "none";
}
/**
 * Esta función imprimirá un formulario para añadir un nuevo Permiso
 */
export function agregarPermiso() {
    let formulario = document.getElementById("formulario");
    let texto = `<form id="formulario" action="">
    <span id="errorBBDD"></span>

    <label for="nombre">Nombre Permiso</label> 
    <input type="text" id="nombre" name="nombre">
    <span id="errorNombre"></span>

    <label for="descripcion">Descripción Permiso</label> 
    <input type="text" id="descripcion" name="descripcion">
    <span id="errorDescripcion"></span>

    <label for="codigo">Código Permiso</label> 
    <input type="text" id="codigo" name="codigo">
    <span id="errorDescripcion"></span>

    <label for="cambiarAccion">Acción Permiso</label> 
    <select name="cambiarAccion">
            <option value="leer" selected>Leer</option>
            <option value="Modificar" >Modificar</option>
            <option value="borrar">Eliminar</option>
            <option value="crear">Crear</option>
        </select>
    <label for="IDrol">Permitido a</label> 
    <select name="IDrol">
        <option value="1" selected>Usuario</option>
        <option value="2" >Agricultor</option>
        <option value="3">Administrador</option>
    </select>
    <input type="text" id="opcion" name="opcion" value="Lista permisos">
    <input type="submit" class="botonSubmit" value="Añadir Permiso">
</form>`;
    formulario.innerHTML = texto;

    document.getElementById("opcion").style.display = "none";
}
/**
 * Esta función imprimirá un formulario para añadir una nueva noticia
 */
export function agregarNoticia() {
    let formulario = document.getElementById("formulario");
    let texto = `
        <span id="errorBBDD"></span>
        <label for="titulo">Título</label>
        <input type="text" id="titulo" name="titulo" />
        <span id="errorTitulo"></span>
        <label for="subtitulo">Subtítulo</label>
        <input type="text" id="subtitulo" name="subtitulo""/>
        <span id="errorSub"></span>
        <label for="imagen">Imagen</label>
        <input type="file" id="imagen" name="imagen" accept=".png, .jpg, .webp" />
        <span id="errorImagen"></span>
        <label for="fecha">Fecha Publicación</label>
        <input type="date" id="fecha" name="fecha" placeholder="YYYY-MM-DD"  title="Fecha no válida"/>
        <span id="errorFecha"></span>
        <label for="cuerpo">Cuerpo</label>
        <textarea  cols="30" rows="5" id="cuerpo" name="cuerpo" form="formulario"></textarea>
        <span id="errorCuerpo"></span>
        <input type="text" id="opcion" name="opcion" value="Lista noticias">
        <input type="submit" class="botonSubmit" value="Añadir Noticia">`;
    formulario.innerHTML = texto;

    document.getElementById("opcion").style.display = "none";
}
/**
 * Esta función imprimirá un formulario para añadir un nuevo producto por parte del agricultor
 */
export function agregarProductoPropio() {
    let formulario = document.getElementById("formulario");
    let texto = `<span id="errorBBDD"></span>
    <label for="nombre">Nombre Producto</label>
    <input type="text" id="nombre"  name="nombre"/>
    <label for="descripcion">Descripción Producto</label>
    <input type="text" id="descripcion"  name="descripcion"/>
    <label for="imagen">Imagen</label>
    <input type="file" id="imagen" name="imagen" accept=".png, .jpg, .webp" "/>
    <label for="precio">Precio</label>
    <input type="number" min="0" step=".01" id="precio"  name="precio" />
    <label for="stock">Stock</label>
    <input type="number" min="0"  id="stock"  name="stock" />
    <label for="descuento">Descuento</label>
    <input type="number" min="0" max="100"  id="descuento"  name="descuento" "/>
    <input type="text" id="opcion" name="opcion" value="Productos">
    <input type="submit" class="botonSubmit" value="Añadir Producto">`;
    formulario.innerHTML = texto;

    document.getElementById("opcion").style.display = "none";

}
/**
 * Esta función imprimirá un formulario para añadir un nuevo producto por parte del administrador
 */
export function agregarProductoGlobal() {

    let formulario = document.getElementById("formulario");
    let texto = `<span id="errorBBDD"></span>
    <label for="nombre">Nombre Producto</label>
    <input type="text" id="nombre"  name="nombre" />
    <label for="descripcion">Descripción Producto</label>
    <input type="text" id="descripcion"  name="descripcion" />
    <label for="imagen">Imagen</label>
    <input type="file" id="imagen" name="imagen" accept=".png, .jpg, .webp" "/>
    <label for="precio">Precio</label>
    <input type="number" min="0" step=".01" id="precio"  name="precio" />
    <label for="stock">Stock</label>
    <input type="number" min="0"  id="stock"  name="stock" />
    <label for="descuento">Descuento</label>
    <input type="number" min="0" max="100"  id="descuento"  name="descuento" />
    <label for="idVendedor">ID Vendedor</label>
    <input type="number" min="1" id="id"  name="id" required/>
    <input type="text" id="opcion" name="opcion" value="Lista productos">
    <input type="submit" class="botonSubmit" value="Añadir Producto">`;
    formulario.innerHTML = texto;
    document.getElementById("opcion").style.display = "none";

}
/**
 * Esta función imprimirá un formulario para añadir un nuevo mensaje al administrador.
 */
export function enviarRespuesta(datos) {
    let mensaje=`${datos[1]}`;
    let parrafo=document.createElement("p");
    parrafo.id="mensajeUsuario";
    parrafo.innerHTML=mensaje;
    let main = document.getElementById("main");
    main.insertBefore(parrafo, main.firstChild);
    let formulario = document.getElementById("formulario");
    let texto = `<span id="errorBBDD"></span>
    <label for="mensaje">Mensaje<br>
    <textarea name="mensaje" id="mensaje" cols="30" rows="10" form="formulario"></textarea>
    </label>
    <input type="text" min="1" id="id"  name="id" value="${datos[0]}" required/>
    <input type="text" id="opcion" name="opcion" value="${datos[2]}">
    <input type="submit" class="botonSubmit" value="Responder Mensaje">`;
    formulario.innerHTML = texto;
    document.getElementById("id").style.display = "none";
    document.getElementById("opcion").style.display = "none";


}
/**
 * Esta función imprimirá un div que informará al usuario de que se ha realizado la acción 
 */
export function agregarCorrecto() {
    let main = document.getElementById("main");
    main.innerHTML = `<div id="vacio" class="claro"><p>Se ha realizado la acción</p></div>`;
    
    const intervalID = setInterval(function () {
        //Borramos productos para que se actualizen los datos si productos fuera alterado, por no complicar mas el codigo
        sessionStorage.removeItem("Productos");
        location.href="./tienda.html";
    }, 1500);

}

