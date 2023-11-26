/**
 * @file Este script añadirá al DOM zonas comunes a todos las vistas html.
* @description Este script añadirá mediante innerHTML zonas como header,nav y footer, que son comunes en todos los html.
* @author Juan Carlos Rodríguez Miranda.
* @version 1.0.0
*/


/**
 * Esta función imprimirá la cabezera que compartiran toda nuestra página, la cual es identica en todas las vistas.
 */
function imprimirCabezera() {

    return new Promise((resolve, reject) => {
        try {
            
            let header = `
            <div class="divheader" id="containerLogo"><img id="logo"   src="../../Recursos/Imagenes/logo.webp" alt="Logo de la tierra"></div>
            <div class="divheader" id="containerBuscador"><input type="text" name="texto" id="buscador"><img id="lupa"
            src="../../Recursos/Imagenes//lupa.webp"  class="iconosHeader" alt=""> </div>
            <div class="divheader" id="containerSpan"><span id="spanBienvenida" class="bienvenida">Iniciar sesión</span></div>
            <div class="divheader" id="containerOpciones">
    
            <ul id="iconos">
                <li id="container_lista">
                    <img id="inicio" class="iconosHeader" src="../../Recursos/Imagenes/InicioSesion.webp" alt="">
                    <ul id="lista">
                    
                    </ul>
                </li>
                <li> 
                    <img id="accesibilidad" class="iconosHeader" src="../../Recursos/Imagenes/accesibilidad.webp" alt="">
                    <ul id="lista2">
                        <li class="listaIconos">texto texto largo largo</li>
                        <li class="listaIconos">texto</li>
                        <li class="listaIconos">texto</li>
                        <li class="listaIconos">texto</li>
                    </ul>
                </li>
                <li><img id="carrito" src="../../Recursos/Imagenes/CarritoCompra.webp"  class="iconosHeader" alt="">
                    <div id="cantidadProductosCarro">0</div></li>
            </ul>
            </div>`;

            let nav = `
            
            <div id="boton"><a href="index.html">Tienda</a></div>
            <div id="boton"><a href="sobreNosotros.html">Sobre nosotros</a></div>
            <div id="boton"><a href="noticias.html">Noticias</a></div>
            <div id="boton"><a href="">Contacto</a></div>
           
            `;
            document.getElementById("header").innerHTML=header;
            document.getElementById("nav").innerHTML=nav;

            //Una vez imprimido damos funcionalidad visual.
            
            resolve();
            //Tras esto debemos añadir funcionalidad a las cosas
        } catch (error) {
            reject(error);
        }
    });
}


function mostrarUsuario() {
    const nombreUsuario=JSON.parse(atob(sessionStorage.getItem("usuario")));
    document.getElementById("spanBienvenida").textContent=`Hola ${nombreUsuario[0] }`;
}

function acciones(){
    const rol=JSON.parse(atob(sessionStorage.getItem("usuario")));
    const acciones = ["Perfil", "Carrito", "Pedidos", "Productos", "Lista Productos", "Lista Usuarios", "Lista Roles", "Lista Noticias", "Lista Permisos"];
    const listaOpciones = document.querySelector("#lista");
    for (let i = 0; i < acciones.length; i++) {
        let opcion = document.createElement("li");
        opcion.className = "listaIconos";
        opcion.textContent = acciones[i];
        if (rol[1] == 1 && i <= 2) {
            listaOpciones.appendChild(opcion);
        }
        else if (rol[1]==2 && i <= 4) {
            listaOpciones.appendChild(opcion);
        } else if (rol[1]== 3) {
            listaOpciones.appendChild(opcion);
        } else {
            break;
            //borrar cosas porque se ha alterado
        }
    }

}
export{imprimirCabezera,mostrarUsuario,acciones};