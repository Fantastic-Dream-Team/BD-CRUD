<?php
/**
 * API CRUD - Sistema de Inventario Académico
 * Maneja todas las operaciones de lectura, creación, actualización y eliminación
 * 
 * Endpoints disponibles:
 * GET  /api.php?action=read
 * POST /api.php?action=create
 * POST /api.php?action=update
 * POST /api.php?action=delete
 */

require_once __DIR__ . '/config.php';

// Obtener la acción solicitada
$action = $_GET['action'] ?? $_POST['action'] ?? null;

try {
    switch ($action) {
        case 'read':
            readProductos();
            break;
        
        case 'create':
            createProducto();
            break;
        
        case 'update':
            updateProducto();
            break;
        
        case 'delete':
            deleteProducto();
            break;
        
        default:
            http_response_code(400);
            respondJSON(false, 'Acción no especificada o inválida');
    }
} catch (Exception $e) {
    http_response_code(400);
    respondJSON(false, $e->getMessage());
    logActivity('error', $e->getMessage());
}

// ============================================
// OPERACIÓN: LEER (SELECT)
// ============================================
/**
 * Obtener todos los productos
 * GET /api.php?action=read
 */
function readProductos() {
    global $mysqli;
    
    try {
        $query = "
            SELECT id, nombre, categoria, precio, cantidad, descripcion, estado, 
                   fecha_creacion, fecha_actualizacion
            FROM productos
            WHERE estado = 'activo'
            ORDER BY fecha_creacion DESC
        ";
        
        $result = $mysqli->query($query);
        
        if (!$result) {
            throw new Exception("Error en la consulta: " . $mysqli->error);
        }
        
        $productos = [];
        while ($row = $result->fetch_assoc()) {
            // Convertir valores numéricos a tipos correctos
            $row['id'] = (int)$row['id'];
            $row['precio'] = (float)$row['precio'];
            $row['cantidad'] = (int)$row['cantidad'];
            $productos[] = $row;
        }
        
        http_response_code(200);
        respondJSON(true, 'Productos obtenidos correctamente', $productos);
        logActivity('READ', 'Se obtuvieron ' . count($productos) . ' productos');
        
    } catch (Exception $e) {
        throw $e;
    }
}

// ============================================
// OPERACIÓN: CREAR (INSERT)
// ============================================
/**
 * Crear un nuevo producto
 * POST /api.php?action=create
 * 
 * Body JSON requerido:
 * {
 *   "nombre": "string",
 *   "categoria": "string",
 *   "precio": number,
 *   "cantidad": number,
 *   "descripcion": "string"
 * }
 */
function createProducto() {
    global $mysqli;
    
    try {
        // Obtener datos JSON del body
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        if ($data === null && $json !== '') {
            throw new Exception('JSON inválido en el body de la solicitud');
        }
        
        // Validar campos requeridos
        validateRequired('nombre', $data['nombre'] ?? null);
        validateRequired('categoria', $data['categoria'] ?? null);
        validateRequired('precio', $data['precio'] ?? null);
        validateRequired('cantidad', $data['cantidad'] ?? null);
        
        // Validaciones específicas
        validatePrice($data['precio']);
        validateQuantity($data['cantidad']);
        
        // Sanitizar datos
        $nombre = sanitize($data['nombre']);
        $categoria = sanitize($data['categoria']);
        $precio = (float)$data['precio'];
        $cantidad = (int)$data['cantidad'];
        $descripcion = sanitize($data['descripcion'] ?? '');
        
        // Validar longitudes
        if (strlen($nombre) > 100) {
            throw new Exception('El nombre no puede exceder 100 caracteres');
        }
        if (strlen($categoria) > 50) {
            throw new Exception('La categoría no puede exceder 50 caracteres');
        }
        
        // Verificar que el producto no exista (opcional)
        $check = $mysqli->query("SELECT id FROM productos WHERE nombre = '$nombre' AND estado = 'activo' LIMIT 1");
        if ($check->num_rows > 0) {
            throw new Exception('Ya existe un producto con este nombre');
        }
        
        // Preparar y ejecutar consulta INSERT
        $stmt = $mysqli->prepare("
            INSERT INTO productos (nombre, categoria, precio, cantidad, descripcion, estado)
            VALUES (?, ?, ?, ?, ?, 'activo')
        ");
        
        if (!$stmt) {
            throw new Exception("Error en la preparación: " . $mysqli->error);
        }
        
        // Vincular parámetros
        $stmt->bind_param("ssdis", $nombre, $categoria, $precio, $cantidad, $descripcion);
        
        // Ejecutar
        if (!$stmt->execute()) {
            throw new Exception("Error al insertar: " . $stmt->error);
        }
        
        $id_nuevo = $stmt->insert_id;
        $stmt->close();
        
        http_response_code(201);
        respondJSON(true, 'Producto creado correctamente', ['id' => $id_nuevo]);
        logActivity('CREATE', "Producto creado: $nombre (ID: $id_nuevo)");
        
    } catch (Exception $e) {
        throw $e;
    }
}

// ============================================
// OPERACIÓN: ACTUALIZAR (UPDATE)
// ============================================
/**
 * Actualizar un producto existente
 * POST /api.php?action=update
 * 
 * Body JSON requerido:
 * {
 *   "id": number,
 *   "nombre": "string",
 *   "categoria": "string",
 *   "precio": number,
 *   "cantidad": number,
 *   "descripcion": "string"
 * }
 */
function updateProducto() {
    global $mysqli;
    
    try {
        // Obtener datos JSON
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        if ($data === null && $json !== '') {
            throw new Exception('JSON inválido en el body de la solicitud');
        }
        
        // Validar ID
        validateRequired('id', $data['id'] ?? null);
        $id = (int)$data['id'];
        
        if ($id <= 0) {
            throw new Exception('ID inválido');
        }
        
        // Validar que el producto existe
        $check = $mysqli->query("SELECT id FROM productos WHERE id = $id");
        if ($check->num_rows === 0) {
            throw new Exception('El producto no existe');
        }
        
        // Validar campos requeridos
        validateRequired('nombre', $data['nombre'] ?? null);
        validateRequired('categoria', $data['categoria'] ?? null);
        validateRequired('precio', $data['precio'] ?? null);
        validateRequired('cantidad', $data['cantidad'] ?? null);
        
        // Validaciones específicas
        validatePrice($data['precio']);
        validateQuantity($data['cantidad']);
        
        // Sanitizar datos
        $nombre = sanitize($data['nombre']);
        $categoria = sanitize($data['categoria']);
        $precio = (float)$data['precio'];
        $cantidad = (int)$data['cantidad'];
        $descripcion = sanitize($data['descripcion'] ?? '');
        
        // Validar longitudes
        if (strlen($nombre) > 100) {
            throw new Exception('El nombre no puede exceder 100 caracteres');
        }
        if (strlen($categoria) > 50) {
            throw new Exception('La categoría no puede exceder 50 caracteres');
        }
        
        // Preparar y ejecutar UPDATE
        $stmt = $mysqli->prepare("
            UPDATE productos 
            SET nombre = ?, categoria = ?, precio = ?, cantidad = ?, descripcion = ?
            WHERE id = ?
        ");
        
        if (!$stmt) {
            throw new Exception("Error en la preparación: " . $mysqli->error);
        }
        
        // Vincular parámetros
        $stmt->bind_param("ssdisi", $nombre, $categoria, $precio, $cantidad, $descripcion, $id);
        
        // Ejecutar
        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar: " . $stmt->error);
        }
        
        $stmt->close();
        
        http_response_code(200);
        respondJSON(true, 'Producto actualizado correctamente', ['id' => $id]);
        logActivity('UPDATE', "Producto actualizado: $nombre (ID: $id)");
        
    } catch (Exception $e) {
        throw $e;
    }
}

// ============================================
// OPERACIÓN: ELIMINAR (DELETE)
// ============================================
/**
 * Eliminar un producto (soft delete)
 * POST /api.php?action=delete
 * 
 * Body JSON requerido:
 * {
 *   "id": number
 * }
 */
function deleteProducto() {
    global $mysqli;
    
    try {
        // Obtener datos JSON
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        if ($data === null && $json !== '') {
            throw new Exception('JSON inválido en el body de la solicitud');
        }
        
        // Validar ID
        validateRequired('id', $data['id'] ?? null);
        $id = (int)$data['id'];
        
        if ($id <= 0) {
            throw new Exception('ID inválido');
        }
        
        // Validar que el producto existe
        $check = $mysqli->query("SELECT nombre FROM productos WHERE id = $id");
        if ($check->num_rows === 0) {
            throw new Exception('El producto no existe');
        }
        
        $row = $check->fetch_assoc();
        $nombre = $row['nombre'];
        
        // Hacer soft delete (cambiar estado a inactivo)
        $stmt = $mysqli->prepare("
            UPDATE productos 
            SET estado = 'inactivo'
            WHERE id = ?
        ");
        
        if (!$stmt) {
            throw new Exception("Error en la preparación: " . $mysqli->error);
        }
        
        $stmt->bind_param("i", $id);
        
        if (!$stmt->execute()) {
            throw new Exception("Error al eliminar: " . $stmt->error);
        }
        
        $stmt->close();
        
        http_response_code(200);
        respondJSON(true, 'Producto eliminado correctamente', ['id' => $id]);
        logActivity('DELETE', "Producto eliminado: $nombre (ID: $id)");
        
    } catch (Exception $e) {
        throw $e;
    }
}

?>
