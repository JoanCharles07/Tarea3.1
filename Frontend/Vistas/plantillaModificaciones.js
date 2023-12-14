export function modificacionComentariosGlobales(arrayDatos){

    let Form=document.getElementById("formulario");
        let texto=`
        <label for="mensaje">Mensaje</label>
        <input type="text" id="mensaje" name="mensaje" value="${arrayDatos[0]}"/>
        <label for="valoracion">Valoracion</label>
        <input type="text" id="valoracion" name="valoracion" value="${arrayDatos[1]}" />
        <label for="fecha">Fecha Publicación</label>
        <input type="text" id="fecha" name="fecha" placeholder="YYYY-MM-DD" value="${arrayDatos[2]}"/>
        <input type="text" id="id"  name="id" value="${arrayDatos[3]}"/>
        <input type="text" id="comprador"  name="comprador" value="${arrayDatos[4]}"/>
        <input type="text" id="opcion"  name="opcion" value="Lista comentarios"/>
        <input type="submit" class="botonSubmit" name="submit" value="Modificar"/>`;
        Form.innerHTML=texto;
        document.getElementById("id").style.display = "none";
        document.getElementById("opcion").style.display = "none";
        document.getElementById("comprador").style.display = "none";
}