<?php

namespace TAREA31\test;

require __DIR__ . '/../Backend/Modelo/comprobaciones.php';
require __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;


class test extends TestCase {
    /**comprobaciones.php */
    public function testTransformarCadenaCORRECTO() {
        $this->assertEquals("limon", transformarPalabra("LimóN"));
    }
    public function testTransformarCadenaERROR() {
        $this->assertNotEquals("limoN", transformarPalabra("LimóN"));
        $this->assertNotEquals("limón", transformarPalabra("LimóN"));
        $this->assertNotEquals("limóN", transformarPalabra("LimóN"));
        
    }

    public function testEstrellasEsNumeroEntre5y1CORRECTO(){
        $this->assertEquals(false, regexEstrellas("1"));
        $this->assertEquals(false, regexEstrellas(2));
        $this->assertEquals(false, regexEstrellas(3));
    }

    public function testEstrellasEsNumeroEntre5y1ERROR(){
        $this->assertNotEquals(false, regexEstrellas("6"));
        $this->assertNotEquals(false, regexEstrellas(7));
        $this->assertNotEquals(false, regexEstrellas("Hola"));
    }

    public function testRegexBooleanCORRECTO(){
        $this->assertEquals(false, RegexBoolean(3,"id"));
        $this->assertEquals(false, RegexBoolean("Un texto cualquiera","UnNameAleatorio"));
        $this->assertEquals(false, RegexBoolean("Una dirección con tilde","mensaje"));
        $this->assertEquals(true, RegexBoolean("delete","mensaje"));
    }

    public function testRegexBooleanERROR(){
        $this->assertEquals(true, RegexBoolean("Hola","id"));
        $this->assertEquals(true, RegexBoolean(123,"unNameAleatorio"));
        $this->assertEquals(true, RegexBoolean("delete","mensaje"));
    }

    

    
}