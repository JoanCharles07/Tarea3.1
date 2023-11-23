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
            
            let headerNav = `<header>
            <div class="divheader" id="containerLogo"><img id="logo"   src="Recursos/Imagenes/logo.webp" alt="Logo de la tierra"></div>
            <div class="divheader" id="containerBuscador"><input type="text" name="texto" id="buscador"><img id="lupa"
            src="Recursos/Imagenes//lupa.webp"  class="iconosHeader" alt=""> </div>
            <div class="divheader" id="containerSpan"><span id="spanBienvenida" class="bienvenida">Iniciar sesión</span></div>
            <div class="divheader" id="containerOpciones">
    
            <ul id="iconos">
                <li id="container_lista">
                    <img id="inicio" class="iconosHeader" src="Recursos/Imagenes/InicioSesion.webp" alt="">
                    <ul id="lista">
                    
                    </ul>
                </li>
                <li> 
                    <img id="accesibilidad" class="iconosHeader" src="Recursos/Imagenes/accesibilidad.webp" alt="">
                    <ul id="lista2">
                        <li class="listaIconos">texto texto largo largo</li>
                        <li class="listaIconos">texto</li>
                        <li class="listaIconos">texto</li>
                        <li class="listaIconos">texto</li>
                    </ul>
                </li>
                <li><img id="carrito" src="Recursos/Imagenes/CarritoCompra.webp"  class="iconosHeader" alt="">
                    <div id="cantidadProductosCarro">0</div></li>
            </ul>
            </div></header>`;

            headerNav += `
            <nav>
            <div id="boton"><a href="Vistas/index.html">Tienda</a></div>
            <div id="boton"><a href="Vistas/sobreNosotros.html">Sobre nosotros</a></div>
            <div id="boton"><a href="Vistas/noticias.html">Noticias</a></div>
            <div id="boton"><a href="">Contacto</a></div>
            </nav>
            `;
            document.body.innerHTML=headerNav;
            resolve("FIN");
            //Tras esto debemos añadir funcionalidad a las cosas
        } catch (error) {
            console.log(error);
        }
    });
}

function imprimirCabezera2() {
    return new Promise((resolve, reject) => {
        try {
            let respuesta = "Yo segundo";

            resolve(respuesta);
        } catch (error) {
            reject(error);
        }
    });
}

export function imprimirCabezera3() {
    return new Promise((resolve, reject) => {
        try {

            let respuesta = "Yo tercero";
            resolve(respuesta);
        } catch (error) {
            reject(error);
        }
    });
}

export{imprimirCabezera};