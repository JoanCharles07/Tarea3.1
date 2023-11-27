/**
 * @file Este script imprimirá  los datos especificamente en cada una de las vistas especificas
 * @description Este script imprimirá los datos recibidos por la base de datos además de  notificar los errores producidos. 
 * @author Juan Carlos Rodríguez Miranda.
 * @version 1.0.0
*/


/**
 * Esta función imprime los productos que tenemos en nuestra página principal tienda.html.
 * Mediante la sessionStorage consigue imprimir todos los productos con innerHTML.
 */
export function imprimirProductos() {
    const productos = JSON.parse(sessionStorage.getItem("productos"));
    let seccion = document.getElementById("containerProductos");
    let texto = "";

    if (productos != null) {
        for (const producto of productos) {
            texto += `<div class="producto">
            <img src="data:image/webp;base64,${producto["imagen"]}" class="productos"></img>
            <p>${producto["Nombre_Producto"]} €/kilo</p>
            <p>${producto["precio"]} €/kilo</p>
            
            </div>`;
        }
    }
    seccion.innerHTML = texto;

}
/**
 * Esta función se usa para llamar varias veces a la función imprimirResultado cuando queremos
 * mostrar más de un error a la vez.
 * @see imprimirResultado.
 */
export function imprimirTodosResultados(objetoComprobaciones) {
    
    for (let clave in objetoComprobaciones) {

        if(clave == "errorBBDD"){
            
            for (let errorBBDD of objetoComprobaciones[clave]){
                let span=document.getElementById(clave);
                span.style.border = "3px solid red";
                span.innerHTML+= `<p>${errorBBDD}</p> </br>`;
            }
        }else{
             //Esto se envia a imprimir resultado y borde rojo si no es correcto
            imprimirResultado(clave, objetoComprobaciones[clave]);
        }
       
    }

}

/**
 * Esta función imprime el texto correspondiente en el span posterior al input
 * que contenga el error en caso de que resultado sea true, de lo contrario no imprimirá nada.
 * Estos datos llegan a través de 
 * @see comprobarDatosRegex de comprobaciones.js
 * @see recepcionDeDatosUsuario de funcionesUsuario.js
 */
function imprimirResultado(id, resultado) {
    let input = document.getElementById(id);
    let span = input.nextElementSibling;
    let texto = input.title;
    if (resultado) {
        input.style.border = "3px solid red";
        span.textContent = texto;
    }
    else{
        input.style.border = "none";
        span.textContent = "";
    }
}

export function imprimirIgualdadPass(resultado) {
    
    if (resultado) {
        document.getElementById("pass").style.border = "";
        document.getElementById("pass2").style.border = "";
        document.getElementById("errorP2").innerHTML = "";


    }
    else {
        document.getElementById("pass").style.border = "3px solid rgb(234,98,98)";
        document.getElementById("pass2").style.border = "3px solid rgb(234,98,98)";
        document.getElementById("errorP2").innerHTML = "No coinciden contraseñas";
    }
}