<?php

$host      = "localhost";
$usuario   = "root";
$contrasena = "123";
$port      = 3306;
$base_datos = "inventario_utp";

// Crear la conexión (SIN el puerto en el constructor)
$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar y manejar errores de conexión
if ($conexion->connect_error) {
    die("<div class='alert alert-danger m-3' role='alert'>
            <strong>Error crítico de conexión:</strong> " . $conexion->connect_error . "
         </div>");
}

$conexion->set_charset("utf8");
?>