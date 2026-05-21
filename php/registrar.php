<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar y sanitizar los datos para evitar inyecciones SQL
    $nombre    = $conexion->real_escape_string($_POST['nombre']);
    $categoria = $conexion->real_escape_string($_POST['categoria']);
    $precio    = floatval($_POST['precio']);
    $cantidad  = intval($_POST['cantidad']);

    $sql = "INSERT INTO productos (nombre, categoria, precio, cantidad) 
            VALUES ('$nombre', '$categoria', $precio, $cantidad)";

    if ($conexion->query($sql) === TRUE) {
        header("Location: index.php?msg=creado");
    } else {
        header("Location: index.php?msg=error");
    }
    exit();
}

header("Location: index.php");