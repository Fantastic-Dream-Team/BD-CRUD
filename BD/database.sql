-- 1. Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS inventario_utp;
USE inventario_utp;

-- 2. Crear la tabla de productos con el manejo de datos correcto
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    cantidad INT NOT NULL
);
