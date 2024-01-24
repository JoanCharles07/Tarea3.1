import { comprobarFecha, comprobarRegex, comprobarRegexEstrellas, validarNumero } from "../Frontend/Modelo/comprobaciones.js";
import { filtradoEstrellas, palabraPreparada } from "../Frontend/Modelo/funcionesBusqueda.js";

describe("Distintas pruebas unitarias para probar funciones de nuestra aplicación",function(){
    it("Frase ejemplo con mayusculas y tilde",function(){
        
       expect(palabraPreparada("CARLOS eS mi Tío")).toBe("carlos es mi tio");
    })
    it("Las estrellas deben de ser un número entre el 1-5",function(){
        //False significa que si esta entre el 1-5
        expect(comprobarRegexEstrellas(5)).toBe(false);
        expect(comprobarRegexEstrellas(6)).toBe(true);
     })
     it("Esta función detecta una serie de palbras que pueden ser comprometidas para la BBDD",function(){
        expect(comprobarRegex("Cualquiera","delete")).toBe(true);
        expect(comprobarRegex("Cualquiera","Otra cosa")).toBe(false);
        
     })
     it("Esta función comprueba que sea un número no negativo",function(){
        expect(validarNumero(5)).toBe(true);
        expect(validarNumero("Otra cosa")).toBe(false);
        
     })
     it("Esta función comprueba que es una fecha valida o sino esta pendiente",function () {  
         const timestamp=1706080230;
         let tiempo=new Date(timestamp *1000);
         expect(comprobarFecha(tiempo)).toBe("24/1/2024");
     })
     it("Esta función devuelve un String según el id que entre como parametro", function(){
      let id="estrellas4";
      let id2="Otra cosa";
      expect(filtradoEstrellas(id)).toBe("4_Estrellas");
      expect(filtradoEstrellas(id2)).toBe("");
     })
})
describe("Distintas pruebas de integración de las comparaciones al llegar un objeto",function(){
    it("Frase ejemplo con datos correctos",function(){
        let booleano=comprobarRegex("Dato",palabraPreparada("Ejemplo de cadena normal"));
        expect(booleano).toBe(false);
    })
    
    it("Frase incorrecta la cual debe ser un número",function(){
      let booleano=comprobarRegex("id",palabraPreparada("Ejemplo de cadena normal"));
      expect(booleano).toBe(true);
  })
 
  it("Frase incorrecta que contiene una palabra prohibida",function(){
   let booleano=comprobarRegex("Dato",palabraPreparada("delete no debe poder ser usado"));
   expect(booleano).toBe(true);
    }) 
    
})