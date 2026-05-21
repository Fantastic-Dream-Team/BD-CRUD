-- ============================================
-- Base de Datos: inventario_utp
-- Sistema CRUD de Inventario Académico
-- ============================================

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS inventario_utp;
USE inventario_utp;

-- ============================================
-- Tabla: productos
-- Almacena información de productos del inventario
-- ============================================
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificador único del producto',
    nombre VARCHAR(100) NOT NULL COMMENT 'Nombre del producto',
    categoria VARCHAR(50) NOT NULL COMMENT 'Categoría del producto',
    precio DECIMAL(10, 2) NOT NULL COMMENT 'Precio unitario del producto',
    cantidad INT NOT NULL DEFAULT 0 COMMENT 'Cantidad disponible en inventario',
    descripcion TEXT COMMENT 'Descripción detallada del producto',
    estado ENUM('activo', 'inactivo') DEFAULT 'activo' COMMENT 'Estado del producto',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de registro',
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Última actualización',
    INDEX idx_categoria (categoria),
    INDEX idx_estado (estado),
    INDEX idx_fecha_creacion (fecha_creacion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
COMMENT='Tabla de productos del inventario académico';

-- ============================================
-- Insertar datos de ejemplo
-- ============================================
INSERT INTO productos (nombre, categoria, precio, cantidad, descripcion, estado) VALUES
('Laptop Dell XPS 13', 'Equipos', 899.99, 5, 'Laptop de alto rendimiento para estudiantes de ingeniería', 'activo'),
('Monitor LG 27"', 'Equipos', 299.99, 12, 'Monitor Full HD para laboratorios', 'activo'),
('Ratón Logitech MX Master', 'Accesorios', 99.99, 20, 'Ratón inalámbrico profesional', 'activo'),
('Teclado Mecánico RGB', 'Accesorios', 149.99, 15, 'Teclado mecánico con iluminación RGB', 'activo'),
('Cable HDMI 2.1', 'Cables', 25.99, 50, 'Cable HDMI de alta velocidad', 'activo'),
('Hub USB-C Multipuerto', 'Accesorios', 79.99, 8, 'Adaptador USB-C con 7 puertos', 'activo'),
('Webcam Logitech 4K', 'Equipos', 199.99, 10, 'Cámara web 4K para videoconferencias', 'activo'),
('Micrófono Condenser', 'Accesorios', 129.99, 6, 'Micrófono de condensador para grabación', 'activo');

-- ============================================
-- Crear usuario para la aplicación (opcional pero recomendado)
-- ============================================
-- NOTA: En Supabase, esto se maneja a través del dashboard
-- Para ambientes locales:
-- CREATE USER 'inventario_user'@'localhost' IDENTIFIED BY 'tu_contraseña_segura';
-- GRANT ALL PRIVILEGES ON inventario_utp.* TO 'inventario_user'@'localhost';
-- FLUSH PRIVILEGES;
