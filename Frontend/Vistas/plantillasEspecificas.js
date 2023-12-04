/**
 * @file Este script imprimirá  los datos especificamente en cada una de las vistas especificas
 * @description Este script imprimirá los datos recibidos por la base de datos además de  notificar los errores producidos. 
 * @author Juan Carlos Rodríguez Miranda.
 * @version 1.0.0
*/



/**
* Esta función imprime 4 imagenes al azar en los detalles de nuestro producto seleccionado.
* @see paginaProducto añadimos la dirección a cada una de las imagenes.
*/
export function imprimirImagenesAzar() {
  const productos=JSON.parse(sessionStorage.getItem("productos"));
  let contador = 0;
  let elegidos = [];
  //Para que no incluya el que ya tenemos elegido
  elegidos.push(sessionStorage.getItem("productoSeleccionado"));
  while(contador < 4){
    let azar = Math.floor(Math.random() * (productos.length));
    if (!elegidos.includes(productos[azar].id)) {
      elegidos.push(productos[azar]["id"]);
      let img = `<img src="data:image/webp;base64,${productos[azar]["imagen"]}" class="otrasImagenes" id="${productos[azar]["id"]}"</img>`;
      contador ++;
      document.getElementById("otrosProductos").innerHTML+=img;
      
    }
   
  }
  paginaProducto("otrasImagenes");
}
/**
 * Esta función imprimirá los detalles del producto escogido.
 * @param {Object} producto contiene los datos de nuestro producto escogido
 */
export function imprimirDetalleProducto(producto){
       
      const texto=`
      <div id="imagen" class="imagenProducto">
      <img src="data:image/webp;base64,${producto["imagen"]}" class ="producto">
      </div>
      <div id="detalles">
              <h2 id="nombreProducto">${producto["nombre"]}</h2>
              <div id="containerPrecio" class="flex">
                  <div id="stock"></div>
                  <p>Precio: <span id="precio">${producto["precio"]}</span> €/kilo</p>
              </div>
              <div id="containerCantidad" class="flex">
                  <label name="cantidad">Cantidad: </label>
                  <input type="number" name="cantidad" id="cantidad" class="inputCantidad">
                  <p>Total: <span id="total"></span> €</p>
              </div>
              <input type="button" name="validar" id="validar" value="Comprar" class="botonesProducto">
              
          <div id="numeroComentarios" class="flex">
          
              <p>Comentarios: <span id="comentariosTotal">${producto["comentariosTotales"]}</span></p>
          </div>

      </div>
      `;
      //<img src="../../Recursos/Imagenes/${producto["valoracionTotal"]}estrellas.webp" id="valoracionTotal" alt="Valoracion">
      document.getElementById("container_producto").innerHTML=texto;

}
/**
* Esta función nos llevará a detalle producto del producto al seleccionarlo.
* 
* @see imprimirImagenesAzar se usa paginaProducto en esta función
* @see imprimirProductos se usa paginaProducto en esta función
*/
function paginaProducto(clase) {
  const containerProductos = document.getElementsByClassName(clase);

  for (let item of containerProductos) {
    item.addEventListener('click', function (e) {
      
      sessionStorage.setItem("productoSeleccionado", item.id);
      location.href = "detalleProducto.html";
    })
  }
}

/**
* Esta función mostrará los ids que coincidan con los del parámetro resultado para la busqueda por lupa
*@param {Array} resultado  
* @see todosDisplay desactivará todo antes de comprobar cuales debemos de activar.
*/
export function mostrarResultadoBusqueda(resultado) {
  todosDisplay(false);
  for(let id of resultado){
      document.getElementById(id).style.display = "flex";
  }
}
/**
 * Esta función mostrará los ids que coincidan con los del parámetro resultado para la busqueda por el filtro lateral.
 * @param {Array} resultado  contendrá todos los ids que debemos activar.
 * @param {Number} contador  nos ayudará a saber si se ha pulsado algunos de los checked.
 * @see todosDisplay
 */
export function mostrarResultadoAside(resultado,contador) {
  if(contador==0){
      todosDisplay(true);
  }
  else{
      todosDisplay(false);
      for(let id of resultado){
          document.getElementById(id).style.display = "flex";
      }
  }
  
  
}

/**
 * Esta función activará o desactivará todos los productos según el valor que tenga el parametro boolean.
 * @param {Boolean} boolean 
 */
function todosDisplay(boolean) {
  let producto = document.getElementsByClassName("producto");
  for (let i = 0; i < producto.length; i++) {
    if (!boolean) {
      producto[i].style.display = "none";
    }
    else {
      producto[i].style.display = "flex";
    }

  }
}


/**
* Esta función imprime los productos que tenemos en nuestra página principal tienda.html.
* Mediante la sessionStorage consigue imprimir todos los productos con innerHTML.
* Además  daremos funcionalidad a los divs llamando a la función paginaProducto.
* @see paginaProducto
* 
*/
export function imprimirProductos() {
  const productos = JSON.parse(sessionStorage.getItem("productos"));
  let seccion = document.getElementById("containerProductos");
  let texto = "";

  if (productos != null) {
      for (const producto of productos) {
          texto += `<div class="producto" id=${producto["id"]}>
          <img src="data:image/webp;base64,${producto["imagen"]}" class="productos"></img>
          <p>${producto["nombre_producto"]} €/kilo</p>
          <p>${producto["precio"]} €/kilo</p>
          
          </div>`;
      }
  }
  seccion.innerHTML = texto;

  //Damos funcionalidad a los productos
  paginaProducto("producto");

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
/**
* Esta función dará estilos a nuestro input pass si no coinciden además de avisar al usuario del error.
* @param {Boolean} resultado  
*/
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

/**
 * Esta función se encarga de mostrar los comentarios que indica nuestro parámetro filtro
 * @param {String} filtro contendrá un String que nos ayudará a saber que comentarios debemos filtrar. 
 * */
export function imprimirFiltradoEstrellas(filtro) {
      let todos = document.getElementsByClassName("parteSuperiorComentario");
      if (filtro != "todas") {
        for (let i = 0; i < todos.length; i++) {
          if (todos[i].childNodes[3].className != filtro) {
            document.getElementsByClassName("comentario")[i].style.display = "none";
          }
          else {
            document.getElementsByClassName("comentario")[i].style.display = "flex";
          }
        }
      }
      else {
        for (let i = 0; i < todos.length; i++) {
          document.getElementsByClassName("comentario")[i].style.display = "flex";
        }
      }

  }

/**
 * Esta función imprimirá los comentarios del producto guardados en nuestra BBDD si los hubiera.
 * @param {Object} datos contendrá los comentario obtenidos de la BBDD si los hubiera.
 */
export function imprimirComentarios(datos) {
    let container = document.getElementById("container_Comentarios");
    let fecha=new Date;
    if(datos.datosComentarios){
      let comentario="";
      for (let dato of datos.datosComentarios) {
  
        comentario += `<div class="comentario"><div id="parteSuperiorComentario" class="parteSuperiorComentario">
        <div class="zonanombre">
        <img src="../../Recursos/Imagenes/usuarioAnonimo.webp" alt="imagen de usuario estandar" id="imagenUsuario">
        <p id="nombreUsuario">${dato.nombre_comprador}</p>
        </div>
        <img src="../../Recursos/Imagenes/${dato.valoracion}estrellas.webp" alt="valoración" class="${dato.valoracion}_Estrellas">
        </div>
        <p>${fecha.toLocaleDateString('es-ES',{day:'2-digit', month:"2-digit",year:"numeric"})}</p>
        <p>${dato.mensaje}</p>
       
        </div>`;
    
        container.innerHTML = comentario;
      }
    }
    else{
      let comentario = `<div class="sinComentarios"> 
      <p class="sinComentario">NO HAY COMENTARIOS TODAVIA</p>
      <p class="sinComentario">¡SE EL PRIMERO EN HACERLO!</p>
      </div>`;
     
      container.innerHTML = comentario;
    }
    let comentario=document.getElementById("container_Comentarios").childNodes.length;
    
    document.getElementById("comentariosTotal").textContent=comentario;
  }
  /**
   * Esta función se encargaá de mostrarnos el precio de nuestro producto según alteremos la cantidad que queremos comprar.
   */
  export function cantidadDetalle() {
  
    let precio = parseFloat(document.getElementById("precio").textContent);
    let cantidad = parseInt(document.getElementById("cantidad").value);
  
  
    if (isNaN(cantidad)) {
      document.getElementById("total").innerHTML = 0;
    }
    else if (cantidad < 0) {
      document.getElementById("cantidad").value = 0;
    }
    else {
      let total = cantidad * precio;
      document.getElementById("total").innerHTML = total.toFixed(2);
    }
  }


/**
* Función que alertará si se quiere registrar mientrás se esta conectado.
*/

export function imprimirConectadoRegistro(){
  alert("No puede registrarse mientras siga conectado, cierre sesión si quiere realizar otro registro");
}

/**
* Función que alertará si se quiere logear de nuevo mientrás se esta conectado.
*/
export function imprimirConectadoLogin(){
  alert("No puede iniciar sesión mientras siga conectado, cierre sesión si quiere realizar otro inicio de sesión");
}