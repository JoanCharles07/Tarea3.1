export function confirmarEliminacion(arrayDatos){

    let Form = document.getElementById("formulario");
    let texto = `
        <span id="errorBBDD"></span>
        <label>¿Seguro que quiere eliminar el producto?</label>
        <input type="text" id="id"  name="id" value="${arrayDatos[0]}"/>
        <input type="text" id="opcion"  name="opcion" value="${arrayDatos[arrayDatos.length - 1]}"/>
        <input type="submit" class="botonSubmit" name="submit" value="Eliminar"/>`;
    Form.innerHTML = texto;
    document.getElementById("id").style.display = "none";
    document.getElementById("opcion").style.display = "none";
}

export function confirmarEliminacionUsuario(arrayDatos){

    let Form = document.getElementById("formulario");
    let texto = `
        <span id="errorBBDD"></span>
        <label>¿Seguro que quiere eliminar el producto?</label>
        <input type="text" id="opcion"  name="opcion" value="${arrayDatos[arrayDatos.length - 1]}"/>
        <input type="submit" class="botonSubmit" name="submit" value="Eliminar"/>`;
    Form.innerHTML = texto;
    document.getElementById("opcion").style.display = "none";
}

export function confirmarEliminacionComentarios(arrayDatos){

    let Form = document.getElementById("formulario");
    let texto = `
        <span id="errorBBDD"></span>
        <label>¿Seguro que quiere eliminar el producto?</label>
        <input type="text" id="id"  name="id" value="${arrayDatos[0]}"/>
        <input type="text" id="comprador"  name="comprador" value="${arrayDatos[1]}"/>
        <input type="text" id="opcion"  name="opcion" value="${arrayDatos[arrayDatos.length - 1]}"/>
        <input type="submit" class="botonSubmit" name="submit" value="Eliminar"/>`;
    Form.innerHTML = texto;
    document.getElementById("id").style.display = "none";
    document.getElementById("comprador").style.display = "none";
    document.getElementById("opcion").style.display = "none";
}

export function confirmarEliminacionPermisos(arrayDatos){

    let Form = document.getElementById("formulario");
    let texto = `
        <span id="errorBBDD"></span>
        <label>¿Seguro que quiere eliminar el producto?</label>
        <input type="text" id="id"  name="id" value="${arrayDatos[0]}"/>
        <input type="text" id="Tipo"  name="Tipo" value="${arrayDatos[1]}"/>
        <input type="text" id="opcion"  name="opcion" value="${arrayDatos[arrayDatos.length - 1]}"/>
        <input type="submit" class="botonSubmit" name="submit" value="Eliminar"/>`;
    Form.innerHTML = texto;
    document.getElementById("id").style.display = "none";
    document.getElementById("Tipo").style.display = "none";
    document.getElementById("opcion").style.display = "none";
}



export function eliminacionCorrecta(respuesta) {
    let main = document.getElementById("main");
    main.innerHTML = `<div id="vacio"><p>Se ha realizado la eliminación</p></div>`;
    if(respuesta.borradoUsuario){
        sessionStorage.removeItem("usuario");
    }
    const intervalID = setInterval(function () {
        //Borramos productos para que se actualizen los datos si productos fuera alterado, por no complicar mas el codigo
        sessionStorage.removeItem("productos");
        location.href="./tienda.html";
    }, 1500);

}