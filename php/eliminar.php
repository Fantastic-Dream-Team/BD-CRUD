<?php
// eliminar.php - Módulo DELETE
require_once 'conexion.php';

// Verificar que se recibió un ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php?msg=error");
    exit();
}

$id = intval($_GET['id']);

// Preparar consulta DELETE con manejo de errores
$stmt = $conexion->prepare("DELETE FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        header("Location: index.php?msg=eliminado");
    } else {
        header("Location: index.php?msg=error");
    }
} else {
    header("Location: index.php?msg=error");
}

$stmt->close();
$conexion->close();
exit();
?>