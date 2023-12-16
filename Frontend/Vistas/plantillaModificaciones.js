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
        <input type="text" id="id"  name="id" value="${arrayDatos[arrayDatos.length - 2]}"/>
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
        <select name="estado">
            <option value="value1" selected>Tramitando</option>
            <option value="value2" >Enviado</option>
            <option value="value3">Recibido</option>
        </select>
        <input type="text" id="opcion"  name="opcion" value="${arrayDatos[arrayDatos.length - 1]}"/>
        <input type="text" id="idComprador"  name="idComprador" value="${arrayDatos[arrayDatos.length - 2]}"/>
        <input type="text" id="idVendedor"  name="idVendedor" value="${arrayDatos[arrayDatos.length - 3]}"/>
        <input type="text" id="idPedido"  name="idVendedor" value="${arrayDatos[1]}"/>
        <input type="submit" class="botonSubmit" name="submit" value="Modificar"/>`;
    Form.innerHTML = texto;
    document.getElementById("id").style.display = "none";
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

export function modificacionCorrecta() {
    let main = document.getElementById("main");
    main.innerHTML = `<div id="vacio"><p>Se ha realizado la modificación</p></div>`;
    const intervalID = setInterval(function () {

        location.href="./tienda.html";
    }, 1500);

}