<?php
// conexion.php

$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "inventario_utp";

// Crear la conexión usando MySQLi
$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar y manejar errores de conexión
if ($conexion->connect_error) {
    // Si falla, se detiene la ejecución y muestra una alerta de Bootstrap
    die("<div class='alert alert-danger m-3' role='alert'>
            <strong>Error crítico de conexión:</strong> " . $conexion->connect_error . "
         </div>");
}

// Opcional: Forzar el set de caracteres a UTF-8 para evitar problemas con tildes y ñ
$conexion->set_charset("utf8");
?>