<?php

namespace TAREA31\test;

require __DIR__ . '/../Backend/Controlador/controlador.php';
require __DIR__ . '/../Backend/Modelo/funcionesBBDD.php';
require __DIR__ . '/../Backend/Conf/conn.php';
require_once __DIR__ . './../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use PDO;
use stdClass;

class testIntegracion extends TestCase {
    protected $conexion; // Conexión a la base de datos de prueba

    protected function setUp(): void {
        // Configurar la conexión a la base de datos de prueba antes de cada prueba
        $this->conexion = new PDO('sqlite::memory:');
        $this->conexion->exec('CREATE TABLE usuario (ID_Usuario INTEGER PRIMARY KEY, Nombre TEXT,Apellido TEXT,
        nickname TEXT,email TEXT,dirección TEXT,ciudad TEXT,provincia TEXT,Codigo_Postal TEXT,DNI TEXT,pass TEXT, ID_rol INTEGER)');
        $this->conexion->exec('INSERT INTO usuario (ID_Usuario,Nombre ,Apellido ,nickname,email,dirección ,ciudad ,provincia ,Codigo_Postal ,DNI ,pass, ID_rol )
        VALUES(1,"Carlos","Rodríguez","JCRM","j@gmail.com","Avenida","Motril","Granada","18600","12345678A","test",3)');
        $this->conexion->exec('INSERT INTO usuario (ID_Usuario,Nombre ,Apellido ,nickname,email,dirección ,ciudad ,provincia ,Codigo_Postal ,DNI ,pass, ID_rol )
        VALUES(2,"PEPE","Rodríguez","PEPILLO","jAS@gmail.com","calle","Motril","Granada","18600","87654321A","testeo",1)');
    }

    public function testRecuperarUsuario() {
        // Configurar datos de sesión de prueba
        $_SESSION["datosUsuario"]['usuario'] = "JCRM";

        // Llamar a la función y obtener los resultados
        $errores = [];
        $session = new stdClass();
        //Para probarlo hay que hacer cambios, conf debe de ser include en controlador php y pasar la conexion temporal por parametro.
        $usuario = recuperarUsuario($this->conexion,$errores,$session);
        
        $this->assertEquals("Carlos", $session->nombre);
        $this->assertEquals('12345678A', $session->dni);
    }

    protected function tearDown(): void {
        // Limpiar la base de datos de prueba después de cada prueba
        $this->conexion = null;
        unset($_SESSION["datosUsuario"]);
    } 
}