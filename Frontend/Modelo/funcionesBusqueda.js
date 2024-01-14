
/**
 * Esta función  recibe una cadena y la compara con los nombres de todos los productos que tengamos
 * @see palabraPreparada
 * @returns {Array} resultado con los ids que contengan la palabra que se busca por el buscador.
 */
export function resultadoBusqueda() {

    let palabraBuscador="";
    //comprobamos de donde viene la busqueda
    if(sessionStorage.getItem("busqueda")){
        palabraBuscador = sessionStorage.getItem("busqueda");
        sessionStorage.removeItem("busqueda");
    }else{
        
        palabraBuscador = document.getElementById("buscador").value;
    }
    
    let resultado = []
    let datos = JSON.parse(sessionStorage.getItem("productos"));
    palabraBuscador = palabraPreparada(palabraBuscador);
    for (let dato of datos) {
        let palabraArray = palabraPreparada(dato.nombre_producto);
        
        if (palabraArray.includes(palabraBuscador)) {
            resultado.push(dato.id);
        }
    }

    return resultado;
}
/**
 * Esta función  recibe una cadena y la transforma en minúscula y sin acentos por si hay fallos de ortografía poder
 * encontrar lo que se busca.
 * @param {String} texto cadena sin modificar
 * @returns {String} cadena modificada en minúscula y sin acentos.
 */

export function palabraPreparada(texto) {
    let palabra = "";
    let mapa = { "á": "a", "é": "e", "í": "i", "ó": "o", "ú": "u", "Á": "a", "É": "e", "Í": "i", "Ó": "o", "Ú": "U" };
    for (let i = 0; i < texto.length; i++) {
        palabra += mapa[texto[i]] || texto[i];
    }
    palabra = palabra.toLowerCase();

    return palabra;
}
/**
 * Esta función contiene distintos arrays con grupos de frutas y verduras y un contador para saber si han sido clicados todos o ninguno.
 * se llamará a la función filtroComparación donde se añadirán los productos que esten en la tienda que cumplan con los que están dentro del
 * array de fruta en concreto.
 * @example
 * Si clicamos en tropicales se enviará al método filtroComparacion donde mirará en el array productos cuales coinciden.
 * @see filtroComparacion
 * @returns {Array} resultado con los ids que contengan cada uno de los arrays enviados a filtroComparacion.
 */
export function filtroLateral() {
    const tropicales = ["Mango", "Piña", "Aguacate", "Papaya", "Chirimoya", "Coco", "Granada", "Guayaba", "Níspero", "Litchi", "Melón", "Sandía"];
    const seco = ["Almendra", "Pistacho", "Nuez", "Nueces", "Anacardo", "Avellana", "Castaña"]
    const citricos = ["Limón", "Lima", "Naranja", "Mandarina", "Pomelo", "Clementina"];
    const dulces = ["Plátano", "Melón", "Manzana", "Albaricoque", "Melocotón", "Pera", "Cereza", "Ciruela", "Papaya", "Níspero", "Melón", "Sandía"];
    const rojos = ["Frambuesa", "Arándano", "Grosella", "Cereza", "Fresa", "Mora"];
    const veryhor = ["Calabaza", "Acelga", "Guisante", "Zanahoria", "Pimiento", "Lechuga", "Pepino", "Berenjena", "Judía Verde", "Esparrago", "Remolacha", "Coliflor", "Repollo", "Tomate", "Brócoli", "Patata", "Boniato", "Apío", "Cebolla", "Ajo", "Puerro"];
    let contador = 0;
    let arrayResultado=[];
    let resultado=new Object();

    if (document.getElementById("frutaTropical").checked) {
        arrayResultado=arrayResultado.concat(filtroComparacion(tropicales));
        
        contador++;
    }
    if (document.getElementById("frutosRojos").checked) {
        arrayResultado=arrayResultado.concat(filtroComparacion(rojos));
        contador++;
    }

    if (document.getElementById("verYHor").checked) {
        arrayResultado=arrayResultado.concat(filtroComparacion(veryhor));
        contador++;
    }
    if (document.getElementById("dulce").checked) {
        arrayResultado=arrayResultado.concat(filtroComparacion(dulces));
        contador++;
    }

    if (document.getElementById("secos").checked) {
        arrayResultado=arrayResultado.concat(filtroComparacion(seco));
        contador++;
    }

    if (document.getElementById("citricos").checked) {
        arrayResultado=arrayResultado.concat(filtroComparacion(citricos));
        contador++;
    }

    resultado.contador=contador;
    //Con set nos aseguramos de que no haya ids repetidos ya que en algunas frutas o verduras pueden entrar en varias categorias.
    resultado.array=[...new Set(arrayResultado)];

    return resultado;
}

/**
 * Esta función  recibe un array con nombres de productos y se comparán con los que están dentro de sessionStorage para devolverlos con un
 * array
 * @see palabraPreparada
 * @returns {Array} resultado con los ids que contengan la palabra que se busca por el buscador.
 */
function filtroComparacion(tipo) {
    let datos = JSON.parse(sessionStorage.getItem("productos"));
    let palabraTipo = "";
    let palabraDatos = "";
    let arrayResultado=[]

    for (let i = 0; i < tipo.length; i++) {
        palabraTipo = palabraPreparada(tipo[i]);

        for (let dato of datos) {
            palabraDatos = palabraPreparada(dato.nombre_producto);

            if (palabraDatos.includes(palabraTipo)) {

                arrayResultado.push(dato.id);

            }
        }
    }

    return arrayResultado

}

/**
 * Esta función devuelve un String según donde hagamos click.
 * @param {String} id contiene una cadena con una de las opciones de estrellas.
 * @returns String devuelve cadena con los datos necesario.
 */
export function filtradoEstrellas(id){
    let respuesta="";
    
        switch (id) {
          case "estrellas5":
            respuesta = "5_Estrellas";
            break;
          case "estrellas4":
            respuesta = "4_Estrellas";
  
            break;
          case "estrellas3":
            respuesta = "3_Estrellas";
  
            break;
          case "estrellas2":
            respuesta = "2_Estrellas";
  
            break;
          case "estrellas1":
            respuesta = "1_Estrellas";
  
            break;
           case "todas":
            respuesta = "todas";
            break;

            default:
              respuesta = "";
              break;
        }
   
    return respuesta;
}