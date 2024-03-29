/**
 * @file Este script añadirá al DOM zonas comunes a todos las vistas html.
* @description Este script añadirá mediante innerHTML zonas como header,nav y footer, que son comunes en todos los html.
* @author Juan Carlos Rodríguez Miranda.
* @version 1.0.0
*/


/**
 * Esta función imprimirá la cabezera que compartiran toda nuestra página, la cual es identica en todas las vistas.
 * y llamará a la función redireccionesBasicas que dará funcionalidad a algunas de las zonas creadas
 * @see redireccionesBasicas
 */
function imprimirCabezera() {

    return new Promise((resolve, reject) => {
        try {

            let header = `
            <div class="divheader" id="containerLogo"><img id="logo"   src="../../Recursos/Imagenes/logo.webp" alt="Logo de la tierra"></div>
            <div class="divheader" id="containerBuscador"><input type="text" name="texto" id="buscador"><img id="lupa"
            src="../../Recursos/Imagenes//lupa.webp"  class="iconoLupa" alt=""> </div>
            <div class="divheader" id="containerSpan"><span id="spanBienvenida" class="bienvenida fuente">Iniciar sesión</span></div>
            <div class="divheader" id="containerOpciones">
    
            <ul id="iconos">
                <li id="container_lista">
                    <img id="inicio" class="iconosHeader" src="../../Recursos/Imagenes/sinConexion.webp" alt="">
                    <ul id="lista">
                    
                    </ul>
                </li>
                <li> 
                    <img id="accesibilidad" class="iconosHeader" src="../../Recursos/Imagenes/accesibilidad.webp" alt="">
                    <ul id="lista2" class="fuente">
                        <li class="listaIconos" id="modoOscuro">Modo Oscuro</li>
                        <li class="listaIconos" id="aumentarFuente">Aumentar Fuente</li>
                        <li class="listaIconos" id="disminuirFuente">Disminuir Fuente</li>
                    </ul>
                </li>
                <li><div id="containerImagenCarrito"><img id="carrito" src="../../Recursos/Imagenes/CarritoCompra.webp"  class="iconosHeader" alt="">
                <div id="cantidadProductosCarro" class="fuente">0</div></div></li>
            </ul>
            </div>`;
            document.getElementById("header").innerHTML = header;
            let nav = `
            
            <div  class="claro botonNAV"><a href="tienda.html" class="fuente">Tienda</a></div>
            <div  class="claro botonNAV"><a href="sobrenosotros.html" class="fuente">Sobre nosotros</a></div>
            <div  class="claro botonNAV"><a href="noticias.html" class="fuente">Noticias</a></div>
            <div  class="claro botonNAV"><a href="contacto.html" class="fuente">Contacto</a></div>
            <div  class="claro botonNAV"><a href="ayuda.html" class="fuente">Ayuda</a></div>
            `;
            let footer = `
            <div>
            <h2>Conócenos</h2>
            <ul>
                <li class="listaFooter"><a href="./tienda.html" class="fuente">Tienda</a></li>
                <li class="listaFooter"><a href="./sobrenosotros.html" class="fuente">Sobre Nosotros</a></li>
                <li class="listaFooter"><a href="./noticias.html" class="fuente">Noticias</a></li>
                <li class="listaFooter"> <a href="./contacto.html" class="fuente">Contacto</a></li>
            </ul>
            </div>
            <div>
            <h2>Información Relevante</h2>
            <ul>
                <li class="listaFooter"><a href="./proyectoEducativo.html" class="fuente">Aviso Legal</a></li>
                <li class="listaFooter"><a href="./atribuciones.html" class="fuente">Atribuciones</a></li>
                <li class="listaFooter"><a href="./licencia.html" class="fuente">Licencia</a></li>
            </ul>
            </div>
            <div>
       
            <h2>Como funcionamos</h2>
            <ul>
            <li class="listaFooter"><a href="./contacto.html" class="fuente">Atención al cliente</a></li>
            <li class="listaFooter"><a href="./proyectoEducativo.html" class="fuente">Políticas de Envío</a></li>
            <li class="listaFooter"><a href="./proyectoEducativo.html" class="fuente">Métodos de pago</a></li>
            </ul>
            </div>
            `;
          
            document.getElementById("nav").innerHTML = nav;
            document.getElementById("footer").innerHTML = footer;
            //Una vez imprimido dirección de imagenes.
            redireccionesBasicas();
            if(sessionStorage.getItem("usuario")){
                document.getElementById("inicio").src="../../Recursos/Imagenes/usuarioActivo.webp"
            }
            console.log("antes");
            resolve();
            //Tras esto debemos añadir funcionalidad a las cosas
        } catch (error) {
            reject(error);
        }

        
    });

}

/**
 * Esta función dara direccionalidad a nuestras imagenes del header según la vista donde este, no afecta estar conectado.
 */
function redireccionesBasicas() {
    const footer=document.getElementsByClassName("listaFooter");
    for(let i=0;i<footer.length;i++){
        footer[i].addEventListener("click",function(){
            const direccion=footer[i].children[0].href;
            location.href=direccion;
        });
    }
    document.getElementById("logo").addEventListener("click", function () {
        location.href = "tienda.html";
    });
    document.getElementById("spanBienvenida").addEventListener("click", function () {
        location.href = "login.html";
    });
    document.getElementById("carrito").addEventListener("click", function () {
        location.href = "carrito.html";
    });
    document.getElementById("inicio").addEventListener("click", function () {
        location.href = "login.html";
    });
    document.getElementById("lupa").addEventListener("click", function () {
        if (!window.location.pathname.includes("tienda.html")) {
            const palabraBuscador = document.getElementById("buscador").value;
            sessionStorage.setItem("busqueda", palabraBuscador);
            location.href = "tienda.html";
        }
    });
}

/**
 * Esta función dará direccionalidad a nuestras imagenes del header pero solo en caso de que estemos conectados
 */
function redireccionesConectado() {

    document.getElementById("spanBienvenida").addEventListener("click", function () {
        location.href = "perfil.html";
    });
    document.getElementById("inicio").addEventListener("click", function () {
        location.href = "perfil.html";
    });

}
/**
 * Esta funcón saludará al usuario con un Hola y su nombre de usuario
 */
function mostrarUsuario() {
    const nombreUsuario = JSON.parse(atob(sessionStorage.getItem("usuario")));
    document.getElementById("spanBienvenida").textContent = `Hola ${nombreUsuario[0]}`;
}

/**
 * Esta función imprimira las opciones según el rol que tengamos.
 * Usando los dos arrays acciones y direcciones insertará en nuestra vista la correspondiente acción con su href teniendo
 * en cuenta el rol.
 */
function acciones() {
    const acciones = JSON.parse(atob(sessionStorage.getItem("acciones")));
    const listaOpciones = document.getElementById("lista");
    for (const accion of acciones) {
        if (accion == "Carrito") {
            let lista = `<li class="listaIconos fuente" id="${accion}" ><a href="./carrito.html">${accion}</a></li>`
            listaOpciones.innerHTML += lista;
        }
        else {
            let lista = `<li class="listaIconos fuente" id="${accion}" >${accion}</li>`
            listaOpciones.innerHTML += lista;
        }

    }

}
/**
 * Esta función nos muestra en el icono del carrito del header la cantidad de productos en nuestro carrito.
 */
function mostrarCantidadCarrito() {
    let cantidadCarro = document.getElementById("cantidadProductosCarro");
    if (sessionStorage.getItem("carrito")) {

        let arrayCarrito = JSON.parse(sessionStorage.getItem("carrito"));
        cantidadCarro.textContent = arrayCarrito.length;
    }
    else {
        cantidadCarro.textContent = 0;
    }

}

export function mantenerFuente(){
    if (localStorage.getItem("Fuente")) {
        let valorFuente = parseInt(localStorage.getItem("Fuente")) * 2;
        let elementosDOM = document.body.getElementsByClassName("fuente");
        for (let i = 0; i < elementosDOM.length; i++) {
          //evitamos que el header se sume dos veces
          let propiedades = window.getComputedStyle(elementosDOM[i]);
          let fuente = parseFloat(propiedades.getPropertyValue('font-size'));
          fuente = fuente + valorFuente;
          elementosDOM[i].style.fontSize = `${fuente}px`;

        }
      }
}
 

export { mostrarCantidadCarrito, imprimirCabezera, mostrarUsuario, acciones, redireccionesConectado };