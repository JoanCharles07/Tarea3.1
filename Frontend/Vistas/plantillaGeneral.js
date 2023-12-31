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
            <div id="boton"><a href="sobrenosotros.html">Sobre nosotros</a></div>
            <div id="boton"><a href="noticias.html">Noticias</a></div>
            <div id="boton"><a href="contacto.html">Contacto</a></div>
           
            `;
            document.getElementById("header").innerHTML=header;
            document.getElementById("nav").innerHTML=nav;

            //Una vez imprimido dirección de imagenes.
            redireccionesBasicas();
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
function redireccionesBasicas(){
    document.getElementById("logo").addEventListener("click",function(){
        location.href="tienda.html";
    });
    document.getElementById("spanBienvenida").addEventListener("click",function(){
        location.href="login.html";
    });
    document.getElementById("carrito").addEventListener("click",function(){
        location.href="carrito.html";
    });
    document.getElementById("inicio").addEventListener("click",function(){
        location.href="login.html";
    });
    document.getElementById("lupa").addEventListener("click",function(){
        if(!window.location.pathname.includes("tienda.html")){
            const palabraBuscador = document.getElementById("buscador").value;
            sessionStorage.setItem("busqueda",palabraBuscador);
            location.href="tienda.html";
        }
    });
}

/**
 * Esta función dará direccionalidad a nuestras imagenes del header pero solo en caso de que estemos conectados
 */
function redireccionesConectado(){
    
    document.getElementById("spanBienvenida").addEventListener("click",function(){
        location.href="perfil.html";
    });
    document.getElementById("inicio").addEventListener("click",function(){
        location.href="perfil.html";
    });
    
}
/**
 * Esta funcón saludará al usuario con un Hola y su nombre de usuario
 */
function mostrarUsuario() {
    const nombreUsuario=JSON.parse(atob(sessionStorage.getItem("usuario")));
    document.getElementById("spanBienvenida").textContent=`Hola ${nombreUsuario[0] }`;
}

/**
 * Esta función imprimira las opciones según el rol que tengamos.
 * Usando los dos arrays acciones y direcciones insertará en nuestra vista la correspondiente acción con su href teniendo
 * en cuenta el rol.
 */
function acciones(){
    const acciones=JSON.parse(atob(sessionStorage.getItem("acciones")));
    const listaOpciones = document.querySelector("#lista");
    for (const accion of acciones) {
        if(accion=="Carrito"){
            lista=`<li class="listaIconos" id="${accion}" ><a href="./carrito.html">${accion}</a></li>`
            listaOpciones.innerHTML+=lista;
        }
        else{
            lista=`<li class="listaIconos" id="${accion}" >${accion}</li>`
            listaOpciones.innerHTML+=lista;
        }
        
    }

}
/**
 * Esta función nos muestra en el icono del carrito del header la cantidad de productos en nuestro carrito.
 */
function mostrarCantidadCarrito(){
    let cantidadCarro = document.getElementById("cantidadProductosCarro");
    if(sessionStorage.getItem("carrito")){
        
        let arrayCarrito = JSON.parse(sessionStorage.getItem("carrito"));
        cantidadCarro.textContent = arrayCarrito.length;
    }
    else{
        cantidadCarro.textContent = 0;
    }
  
}

export{mostrarCantidadCarrito,imprimirCabezera,mostrarUsuario,acciones,redireccionesConectado};