<?php

include 'conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre    = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $precio    = $_POST['precio'];
    $cantidad  = $_POST['cantidad'];

    $sql = "INSERT INTO productos (nombre, categoria, precio, cantidad) 
            VALUES ('$nombre', '$categoria', $precio, $cantidad)";

    if ($conexion->query($sql) === TRUE) {
        $mensaje = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        ✅ Producto registrado exitosamente.
                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                    </div>";
    } else {
        $mensaje = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Error en la consulta:</strong> " . $conexion->error . "
                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                    </div>";
    }
}
?>

<?php echo $mensaje; ?>

<form action="index.php" method="POST">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre del Producto</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
    </div>

    <div class="mb-3">
        <label for="categoria" class="form-label">Categoría</label>
        <input type="text" class="form-control" id="categoria" name="categoria" required>
    </div>

    <div class="row">
        <div class="col-6 mb-3">
            <label for="precio" class="form-label">Precio ($)</label>
            <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
        </div>
        <div class="col-6 mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" required>
        </div>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-success">Guardar Producto</button>
    </div>
</form>