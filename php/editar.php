<?php
// editar.php

// 1. Incluir el archivo de conexión
include 'conexion.php';

$mensaje = ""; // Variable para alertas
$producto = null;

// Paso 2: Carga de Datos (Capturar ID por GET y precargar valores)
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitización básica del ID
    $sql = "SELECT * FROM productos WHERE id = $id";
    $resultado = $conexion->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $producto = $resultado->fetch_assoc();
    } else {
        $mensaje = "<div class='alert alert-danger'>Producto no encontrado.</div>";
    }
}

// Paso 3: Lógica UPDATE (Procesar formulario por POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $categoria = $conexion->real_escape_string($_POST['categoria']);
    $precio = floatval($_POST['precio']);
    $cantidad = intval($_POST['cantidad']);

    // Sentencia SQL para actualizar
    $sql_update = "UPDATE productos SET 
                    nombre = '$nombre', 
                    categoria = '$categoria', 
                    precio = $precio, 
                    cantidad = $cantidad 
                  WHERE id = $id";

    if ($conexion->query($sql_update) === TRUE) {
        $mensaje = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>¡Éxito!</strong> El producto ha sido actualizado correctamente.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
        // Actualizamos el array local para que el formulario refleje los cambios inmediatamente
        $producto = ['id' => $id, 'nombre' => $nombre, 'categoria' => $categoria, 'precio' => $precio, 'cantidad' => $cantidad];
    } else {
        $mensaje = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Error:</strong> No se pudo actualizar el producto. " . $conexion->error . "
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
    }
}

// Si no hay producto que editar (y no es una respuesta de POST), detenemos la carga
if (!$producto && $_SERVER["REQUEST_METHOD"] != "POST") {
    die("<div class='container mt-5'><div class='alert alert-warning'>ID de producto no válido. <a href='index.php' class='btn btn-sm btn-secondary'>Regresar</a></div></div>");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - Inventario UTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <?php echo $mensaje; ?>

            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Modificar Datos del Producto</h4>
                </div>
                <div class="card-body">
                    <form action="editar.php?id=<?php echo $producto['id']; ?>" method="POST">
                        <!-- Paso 2: Campos precargados -->
                        <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                        
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoría</label>
                            <input type="text" class="form-control" id="categoria" name="categoria" value="<?php echo htmlspecialchars($producto['categoria']); ?>" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="precio" class="form-label">Precio ($)</label>
                                <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?php echo $producto['precio']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cantidad" class="form-label">Cantidad en Stock</label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad" value="<?php echo $producto['cantidad']; ?>" required>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
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