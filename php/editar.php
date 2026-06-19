<?php
// editar.php - Módulo UPDATE con manejo de errores
require_once 'conexion.php';

$mensaje = "";
$producto = null;

// Cargar datos del producto a editar (Capturar ID por GET)
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM productos WHERE id = $id";
    $resultado = $conexion->query($sql);
    
    if ($resultado && $resultado->num_rows > 0) {
        $producto = $resultado->fetch_assoc();
    } else {
        die("<div class='container mt-5'><div class='alert alert-danger'>Producto no encontrado. <a href='index.php' class='btn btn-sm btn-secondary'>Volver</a></div></div>");
    }
}

// Procesar actualización (Lógica UPDATE)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $categoria = $conexion->real_escape_string($_POST['categoria']);
    $precio = floatval($_POST['precio']);
    $cantidad = intval($_POST['cantidad']);
    
    $sql_update = "UPDATE productos SET 
                    nombre = '$nombre', 
                    categoria = '$categoria', 
                    precio = $precio, 
                    cantidad = $cantidad 
                  WHERE id = $id";
    
    if ($conexion->query($sql_update) === TRUE) {
        header("Location: index.php?msg=editado");
        exit();
    } else {
        $mensaje = "<div class='alert alert-danger'>Error al actualizar: " . $conexion->error . "</div>";
    }
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
                <div class="card shadow">
                    <div class="card-header bg-warning">
                        <h4 class="mb-0">✏️ Editar Producto</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                            
                            <div class="mb-3">
                                <label class="form-label">Nombre del Producto</label>
                                <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Categoría</label>
                                <input type="text" name="categoria" class="form-control" value="<?php echo htmlspecialchars($producto['categoria']); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Precio ($)</label>
                                <input type="number" step="0.01" name="precio" class="form-control" value="<?php echo $producto['precio']; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Cantidad en Stock</label>
                                <input type="number" name="cantidad" class="form-control" value="<?php echo $producto['cantidad']; ?>" required>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">💾 Guardar Cambios</button>
                                <a href="index.php" class="btn btn-secondary">❌ Cancelar</a>
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