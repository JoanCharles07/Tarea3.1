<?php

/*INSERTAR AQUÍ CONFIGURACIÓN PARA CONECTAR A LA BASE DE DATOS */
define ('DB_DSN','mysql:host=localhost;dbname=delatierra;port=3306;charset=utf8');
define ('DB_USER','root');
define ('DB_PASSWD','XDDAW(21)');        
     
function conectar(){
    try {
        $pdo=new PDO(DB_DSN, DB_USER, DB_PASSWD);
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   } catch (PDOException $e)
   {
        $pdo=false;
   }
   
    return  $pdo;
}