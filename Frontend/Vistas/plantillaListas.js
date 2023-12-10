export function redireccionLista(eleccion) {
    
    const datosPorURL='?eleccion=' + encodeURIComponent(eleccion);
    location.href="./listas.html" + datosPorURL;
}