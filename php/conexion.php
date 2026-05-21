<?php

$host      = "localhost";
$usuario   = "root";
$contrasena = "";
$port      = 3307;
$base_datos = "inventario_utp";

// Crear la conexión pasando el puerto correctamente
$conexion = new mysqli($host, $usuario, $contrasena, $base_datos, $port);

// Verificar y manejar errores de conexión
if ($conexion->connect_error) {
    die("<div class='alert alert-danger m-3' role='alert'>
            <strong>Error crítico de conexión:</strong> " . $conexion->connect_error . "
         </div>");
}
$conexion->set_charset("utf8");
?>