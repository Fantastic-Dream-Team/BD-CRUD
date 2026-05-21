<?php
// registrar.php

// 1. Incluir el archivo de conexión
include 'conexion.php';

$mensaje = ""; // Variable para guardar alertas de éxito o error

// 2. Lógica para procesar el formulario (INSERT)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos del formulario
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    // Preparar la consulta SQL
    $sql = "INSERT INTO productos (nombre, categoria, precio, cantidad) 
            VALUES ('$nombre', '$categoria', $precio, $cantidad)";

    // Ejecutar la consulta y manejar errores
    if ($conexion->query($sql) === TRUE) {
        $mensaje = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        Producto registrado exitosamente.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
    } else {
        $mensaje = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Error en la consulta:</strong> " . $conexion->error . "
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Producto - Inventario UTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <?php echo $mensaje; ?>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Registrar Nuevo Producto</h4>
                </div>
                <div class="card-body">
                    <form action="registrar.php" method="POST">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoría</label>
                            <input type="text" class="form-control" id="categoria" name="categoria" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="precio" class="form-label">Precio ($)</label>
                                <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="cantidad" class="form-label">Cantidad en Stock</label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Guardar Producto</button>
                            <a href="index.php" class="btn btn-outline-secondary">Volver a la lista</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>