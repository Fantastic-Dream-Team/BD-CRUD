<?php
/**
 * Configuración de Conexión a Base de Datos
 * Sistema CRUD de Inventario Académico
 * 
 * Este archivo maneja la conexión a Supabase/MySQL
 * Incluye manejo de errores y funciones utilitarias
 */

// Mostrar errores en desarrollo (desactivar en producción)
ini_set('display_errors', 0);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/logs/error.log');

// Crear directorio de logs si no existe
if (!is_dir(__DIR__ . '/logs')) {
    mkdir(__DIR__ . '/logs', 0755, true);
}

// Cargar variables de entorno desde backend/.env si existe
$envPath = __DIR__ . '/.env';
if (file_exists($envPath)) {
    $envLines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($envLines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) {
            continue;
        }
        if (strpos($line, '=') === false) {
            continue;
        }
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        if ($key !== '') {
            putenv("$key=$value");
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}

// ============================================
// CREDENCIALES DE BASE DE DATOS
// ============================================
// IMPORTANTE: En producción usar variables de entorno
// Para desarrollo local, usar valores directo (no recomendado en producción)

// Opción 1: Usando Supabase (Recomendado)
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_password = getenv('DB_PASSWORD') ?: '';
$db_name = getenv('DB_NAME') ?: 'inventario_utp';
$db_port = getenv('DB_PORT') ?: 3307;

// ============================================
// CREAR CONEXIÓN CON MYSQLI
// ============================================
try {
    $mysqli = new mysqli($db_host, $db_user, $db_password, $db_name, (int)$db_port);
    
    // Verificar conexión
    if ($mysqli->connect_error) {
        throw new Exception("Error de conexión: " . $mysqli->connect_error);
    }
    
    // Configurar charset UTF-8
    $mysqli->set_charset("utf8mb4");
    
    // Habilitar excepciones para MySQLi
    $mysqli->report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
} catch (Exception $e) {
    // Loguear error
    error_log("Error de conexión a BD: " . $e->getMessage());
    
    // Responder con error en JSON
    http_response_code(503);
    echo json_encode([
        'success' => false,
        'message' => 'No se pudo conectar a la base de datos',
        'error' => $_ENV['APP_DEBUG'] ?? false ? $e->getMessage() : null
    ]);
    exit;
}

// ============================================
// FUNCIONES AUXILIARES
// ============================================

/**
 * Sanitizar entrada de usuario
 * @param string $data Datos a sanitizar
 * @return string Datos sanitizados
 */
function sanitize($data) {
    global $mysqli;
    return $mysqli->real_escape_string(trim($data));
}

/**
 * Validar que un campo no esté vacío
 * @param string $field Nombre del campo
 * @param mixed $value Valor a validar
 * @return bool
 */
function validateRequired($field, $value) {
    if ($value === null || $value === '') {
        throw new Exception("El campo '$field' es requerido");
    }
    return true;
}

/**
 * Validar precio (debe ser número positivo)
 * @param float $price Precio a validar
 * @return bool
 */
function validatePrice($price) {
    if (!is_numeric($price) || $price < 0) {
        throw new Exception("El precio debe ser un número positivo");
    }
    return true;
}

/**
 * Validar cantidad (debe ser número entero positivo)
 * @param int $cantidad Cantidad a validar
 * @return bool
 */
function validateQuantity($cantidad) {
    if (!is_numeric($cantidad) || $cantidad < 0 || (int)$cantidad != $cantidad) {
        throw new Exception("La cantidad debe ser un número entero positivo");
    }
    return true;
}

/**
 * Responder en formato JSON
 * @param bool $success Estado de la operación
 * @param string $message Mensaje descriptivo
 * @param mixed $data Datos adicionales (opcional)
 */
function respondJSON($success, $message, $data = null) {
    header('Content-Type: application/json; charset=utf-8');
    
    $response = [
        'success' => $success,
        'message' => $message
    ];
    
    if ($data !== null) {
        $response['data'] = $data;
    }
    
    echo json_encode($response);
}

/**
 * Log de actividades
 * @param string $action Acción realizada
 * @param string $details Detalles de la acción
 */
function logActivity($action, $details) {
    $timestamp = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $log_message = "[$timestamp] IP: $ip | Acción: $action | Detalles: $details\n";
    error_log($log_message, 3, __DIR__ . '/logs/activity.log');
}

// Habilitar CORS para solicitudes desde el frontend
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

?>
