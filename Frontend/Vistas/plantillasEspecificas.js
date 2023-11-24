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
export function imprimirProductos(){
    const productos=JSON.parse(sessionStorage.getItem("productos"));
    let seccion = document.getElementById("containerProductos");
    let texto="";
    
    if(productos!=null){
        for (const producto of productos) {
            texto+=`<div class="producto">
            <img src="data:image/webp;base64,${producto["imagen"]}" class="productos"></img>
            <p>${producto["Nombre_Producto"]} €/kilo</p>
            <p>${producto["precio"]} €/kilo</p>
            
            </div>`;
        }
    }
    seccion.innerHTML=texto;
    
}