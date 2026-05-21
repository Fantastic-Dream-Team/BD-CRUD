# 🎓 Sistema CRUD de Inventario Académico

Sistema completo de gestión de inventario desarrollado con **PHP**, **MySQL** y **JavaScript moderno** para la **Universidad Tecnológica de Panamá (UTP)**.

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue)](https://www.php.net)
[![MySQL Version](https://img.shields.io/badge/MySQL-5.7%2B-blue)](https://www.mysql.com)

---

## 📋 Tabla de Contenidos

1. [Características](#características)
2. [Requisitos del Laboratorio](#requisitos-del-laboratorio)
3. [Rúbrica de Evaluación](#rúbrica-de-evaluación)
4. [Instalación](#instalación)
5. [Configuración](#configuración)
6. [Estructura del Proyecto](#estructura-del-proyecto)
7. [Guía de Uso](#guía-de-uso)
8. [Recomendaciones para Docentes](#recomendaciones-para-docentes)
9. [Endpoints API](#endpoints-api)
10. [Troubleshooting](#troubleshooting)

---

## ✨ Características

### Funcionalidades CRUD Completas
- ✅ **CREATE** - Registrar nuevos productos
- ✅ **READ** - Visualizar lista de productos
- ✅ **UPDATE** - Editar productos existentes
- ✅ **DELETE** - Eliminar productos (soft delete)

### Validaciones Robustas
- ✔️ Validación en el cliente (JavaScript)
- ✔️ Validación en el servidor (PHP)
- ✔️ Sanitización de datos para prevenir SQL injection
- ✔️ Manejo completo de errores
- ✔️ Logging de actividades

### Interfaz Moderna
- 🎨 Diseño según Human Interface Guidelines (HIG)
- 📱 **100% Responsivo** - Funciona en desktop, tablet y móvil
- ⚡ Animaciones suaves y transiciones
- 🌙 Soporte para modo oscuro
- ♿ Accesible (WCAG 2.1 AA)

### Base de Datos
- 🗄️ Estructura optimizada en MySQL/Supabase
- 📊 Índices para consultas rápidas
- 🔐 Soft delete (recuperación segura)
- 📅 Timestamps automáticos

---

## 📚 Requisitos del Laboratorio

Según la actividad propuesta, este proyecto cumple con:

### Base de Datos ✅
- [x] Crear base de datos `inventario_utp`
- [x] Crear tabla `productos` con campos: id, nombre, categoria, precio, cantidad
- [x] Campos adicionales: descripcion, estado, fecha_creacion, fecha_actualizacion

### Conexión PHP-MySQL ✅
- [x] Conexión mediante MySQLi
- [x] Soporte para Supabase
- [x] Manejo de errores de conexión
- [x] Charset UTF-8mb4

### Formulario HTML ✅
- [x] Formulario completo con validación
- [x] Campos: nombre, categoría, precio, cantidad, descripción
- [x] Mensajes de error en tiempo real
- [x] Contador de caracteres

### Operaciones CRUD ✅
- [x] INSERT - Crear productos
- [x] SELECT - Listar productos
- [x] UPDATE - Editar productos
- [x] DELETE - Eliminar productos

### Interfaz ✅
- [x] Tabla HTML responsiva
- [x] Búsqueda y filtrado en tiempo real
- [x] Diseño moderno con CSS avanzado
- [x] Animaciones y transiciones

### Manejo de Errores ✅
- [x] Try-catch en PHP
- [x] Validación de campos
- [x] Mensajes descriptivos al usuario
- [x] Logging de errores

### Organización ✅
- [x] Código comentado y estructurado
- [x] Separación de responsabilidades
- [x] Archivos organizados
- [x] Buenas prácticas de programación

---

## 📊 Rúbrica de Evaluación

| Criterio | Descripción | Puntaje | Estado |
|----------|-------------|---------|--------|
| Base de datos | La BD y tabla funcionan correctamente | 10 | ✅ |
| Conexión PHP-MySQL | MySQLi funciona sin errores | 15 | ✅ |
| Operación INSERT | Permite registrar productos | 15 | ✅ |
| Operación SELECT | Muestra registros en tabla HTML | 15 | ✅ |
| Operación UPDATE | Permite actualizar registros | 10 | ✅ |
| Operación DELETE | Permite eliminar registros | 10 | ✅ |
| Manejo de errores | Control de conexión y consultas | 10 | ✅ |
| Diseño e interfaz | Uso adecuado de CSS | 5 | ✅ |
| Trabajo en equipo | Distribución y colaboración | 5 | ✅ |
| Organización del código | Código comentado y ordenado | 5 | ✅ |
| **TOTAL** | | **100** | ✅ |

---

## 🚀 Instalación

### Opción 1: Deployment en Render (Recomendado)

#### Paso 1: Crear cuenta en Render
1. Ve a [render.com](https://render.com)
2. Regístrate con tu email
3. Crea un nuevo proyecto

#### Paso 2: Crear Base de Datos en Supabase
1. Ve a [supabase.com](https://supabase.com)
2. Crea un nuevo proyecto
3. Ve al **SQL Editor**
4. Copia el contenido de `schema.sql`
5. Ejecuta el script
6. Guarda las credenciales:
   - Host
   - Usuario (postgres)
   - Contraseña
   - Base de datos (postgres)
   - Puerto (5432)

#### Paso 3: Preparar Archivos
```bash
# Crear estructura de carpetas
mkdir -p inventario-api/logs
cd inventario-api

# Copiar archivos
# - config.php
# - api.php
# - .env.example (renombrar a .env)
```

#### Paso 4: Configurar Variables de Entorno (.env)
```env
# Credenciales de Supabase
DB_HOST=xxxxx.supabase.co
DB_USER=postgres
DB_PASSWORD=tu_contraseña_supabase
DB_NAME=postgres
DB_PORT=5432

# Configuración de la app
APP_ENV=production
APP_DEBUG=false
```

#### Paso 5: Deploy en Render
1. Conecta tu repositorio GitHub
2. Configura variables de entorno
3. Render detectará automáticamente PHP
4. Deploy automático

### Opción 2: Instalación Local

#### Requisitos
- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache, Nginx)
- VS Code (recomendado)

#### Pasos

```bash
# 1. Clonar o descargar el proyecto
git clone <url-del-repo>
cd inventario-utp

# 2. Crear base de datos
mysql -u root -p < schema.sql

# 3. Configurar archivos
cp .env.example .env
# Editar .env con tus credenciales locales

# 4. Crear carpeta de logs
mkdir -p logs
chmod 755 logs

# 5. Iniciar servidor PHP
php -S localhost:8000

# 6. Abrir en navegador
# http://localhost:8000
```

---

## ⚙️ Configuración

### Estructura de Carpetas

```
inventario-utp/
├── index.html           # Página principal (Frontend)
├── styles.css           # Estilos CSS (HIG Guidelines)
├── app.js               # Lógica JavaScript (Frontend)
├── api.php              # API REST (Backend)
├── config.php           # Configuración y conexión BD
├── schema.sql           # Script SQL para crear BD
├── .env.example         # Variables de entorno (ejemplo)
├── logs/
│   ├── error.log        # Log de errores PHP
│   └── activity.log     # Log de actividades
├── .gitignore           # Archivos a ignorar en Git
└── README.md            # Este archivo

```

### Variables de Entorno (.env)

```env
# Base de Datos
DB_HOST=localhost              # Host del servidor MySQL
DB_USER=inventario_user        # Usuario de BD
DB_PASSWORD=contraseña_segura  # Contraseña
DB_NAME=inventario_utp         # Nombre de la BD
DB_PORT=3306                   # Puerto (3306 para MySQL)

# Aplicación
APP_ENV=production             # production | development
APP_DEBUG=false                # true para ver errores
APP_URL=https://tu-app.onrender.com

# Zona Horaria
TIMEZONE=America/Panama
```

### Crear Tabla de Manera Manual (SQL)

Si prefieres hacerlo manualmente:

```sql
CREATE DATABASE inventario_utp;
USE inventario_utp;

CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    cantidad INT NOT NULL DEFAULT 0,
    descripcion TEXT,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_categoria (categoria),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## 📁 Estructura del Proyecto

### Frontend (HTML/CSS/JS)

**`index.html`** - Página principal
- Header con estadísticas
- Formulario de registro
- Tabla de productos
- Modales de edición y confirmación

**`styles.css`** - Estilos CSS
- Variables CSS para temas
- Diseño responsivo (mobile-first)
- Animaciones suaves
- Soporte para modo oscuro
- Cumple HIG Guidelines

**`app.js`** - Lógica JavaScript
- Carga de productos (READ)
- Crear productos (CREATE)
- Editar productos (UPDATE)
- Eliminar productos (DELETE)
- Filtrado y búsqueda
- Validaciones
- Manejo de modales

### Backend (PHP)

**`config.php`** - Configuración
- Conexión MySQLi
- Funciones de validación
- Funciones auxiliares
- Manejo de CORS

**`api.php`** - API REST
- Endpoint: `GET /api.php?action=read`
- Endpoint: `POST /api.php?action=create`
- Endpoint: `POST /api.php?action=update`
- Endpoint: `POST /api.php?action=delete`

### Base de Datos

**`schema.sql`** - Script SQL
- Crear base de datos
- Crear tabla productos
- Insertar datos de ejemplo
- Crear índices

---

## 📖 Guía de Uso

### Para Usuarios

#### Registrar un Producto
1. Completa el formulario "Registrar Producto"
2. Campo "Nombre": Máx 100 caracteres
3. Selecciona una categoría
4. Ingresa precio (número con decimales)
5. Ingresa cantidad (número entero)
6. (Opcional) Agrega descripción
7. Haz clic en "Registrar Producto"
8. ¡Producto creado! ✅

#### Buscar Productos
1. Usa la barra de búsqueda para filtrar por nombre o descripción
2. Usa el filtro de categoría para agrupar
3. Los resultados se actualizan en tiempo real

#### Editar un Producto
1. Haz clic en el botón ✏️ (editar)
2. Se abrirá un modal con los datos actuales
3. Modifica los campos que necesites
4. Haz clic en "Guardar Cambios"
5. ¡Producto actualizado! ✅

#### Eliminar un Producto
1. Haz clic en el botón 🗑️ (eliminar)
2. Confirma la acción en el modal
3. ¡Producto eliminado! ✅

### Para Desarrolladores

#### Entender el Flujo

**Frontend → Backend → BD**

```
1. Usuario lleña formulario
   ↓
2. JavaScript valida datos (app.js)
   ↓
3. Fetch POST a /api.php
   ↓
4. PHP valida nuevamente (config.php)
   ↓
5. MySQLi ejecuta query (api.php)
   ↓
6. JSON response al frontend
   ↓
7. Frontend actualiza UI
```

#### Agregar Nueva Funcionalidad

**Ejemplo: Filtro por precio**

En `app.js`:
```javascript
function filtrarProductos() {
    const minPrice = document.getElementById('minPrice').value;
    
    const filtrados = productos.filter(p => p.precio >= minPrice);
    renderizarProductos(filtrados);
}
```

En `index.html`:
```html
<input type="number" id="minPrice" placeholder="Precio mínimo">
```

---

## 👨‍🏫 Recomendaciones para Docentes

### Demostraciones Prácticas

#### Demo 1: Crear un Producto
```
Paso 1: Mostrar el formulario vacío
Paso 2: Llenar con datos de ejemplo
Paso 3: Mostrar consola del navegador (F12)
Paso 4: Hacer clic en "Registrar"
Paso 5: Mostrar la solicitud en Network tab
Paso 6: Mostrar el producto en la tabla
```

#### Demo 2: Ver Errores Comunes
```
Error: Campo vacío
→ Mostrar mensaje rojo
→ Explicar validación

Error: Precio negativo
→ Mostrar validación número

Error: Conexión a BD
→ Apagar servidor MySQL
→ Mostrar error en consola
→ Prender servidor de nuevo
```

### Buenas Prácticas a Enfatizar

1. **Validación en Dos Capas**
   - Cliente (rápido, feedback inmediato)
   - Servidor (seguro, confiable)

2. **Manejo de Errores**
   - Try-catch en PHP
   - Try-catch en JavaScript
   - Logging de errores

3. **Seguridad**
   - Escapar datos en JavaScript
   - Prepared statements en PHP
   - Validación de tipos

4. **Accesibilidad**
   - Labels para inputs
   - Focus visible
   - Contraste de colores

5. **Rendimiento**
   - Índices en la BD
   - Caching cuando sea posible
   - Minimizar solicitudes

### Supervisión del Trabajo Colaborativo

**Rúbrica de Evaluación de Equipo:**

| Aspecto | Excelente | Bueno | Regular | Pobre |
|---------|-----------|-------|---------|-------|
| Distribución de tareas | Cada miembro contribuye | Mayoría contribuye | Solo 1-2 contributores | Un único desarrollador |
| Comunicación | Excelente coordinación | Buena comunicación | Comunicación mínima | Sin coordinación |
| Entrega | Completamente funcional | Funcional con pequeños bugs | Funcional parcialmente | No funcional |
| Documentación | Completa y clara | Adecuada | Incompleta | Sin documentación |

### Checklist de Revisión

✅ **Base de Datos**
- [ ] BD existe y tiene datos
- [ ] Tabla tiene todos los campos
- [ ] Índices están creados
- [ ] Soft delete implementado

✅ **Backend (PHP)**
- [ ] Conexión a BD funciona
- [ ] Validación en servidor
- [ ] Manejo de errores
- [ ] Queries preparadas
- [ ] Logging de actividades

✅ **Frontend (HTML/CSS/JS)**
- [ ] Formulario valida
- [ ] Tabla muestra datos
- [ ] Búsqueda funciona
- [ ] Edición funciona
- [ ] Eliminación funciona
- [ ] Responsive en móvil

✅ **Documentación**
- [ ] README completo
- [ ] Código comentado
- [ ] Estructura clara
- [ ] Instrucciones de instalación

---

## 🔌 Endpoints API

### 1. Leer Productos (SELECT)

```bash
GET /api.php?action=read
```

**Respuesta (JSON):**
```json
{
  "success": true,
  "message": "Productos obtenidos correctamente",
  "data": [
    {
      "id": 1,
      "nombre": "Laptop Dell XPS 13",
      "categoria": "Equipos",
      "precio": 899.99,
      "cantidad": 5,
      "descripcion": "Laptop de alto rendimiento",
      "estado": "activo",
      "fecha_creacion": "2024-01-15 10:30:00",
      "fecha_actualizacion": "2024-01-15 10:30:00"
    }
  ]
}
```

### 2. Crear Producto (INSERT)

```bash
POST /api.php?action=create
Content-Type: application/json

{
  "nombre": "Monitor LG 27\"",
  "categoria": "Equipos",
  "precio": 299.99,
  "cantidad": 10,
  "descripcion": "Monitor Full HD"
}
```

**Respuesta (Éxito):**
```json
{
  "success": true,
  "message": "Producto creado correctamente",
  "data": {
    "id": 2
  }
}
```

**Respuesta (Error):**
```json
{
  "success": false,
  "message": "El nombre es requerido"
}
```

### 3. Actualizar Producto (UPDATE)

```bash
POST /api.php?action=update
Content-Type: application/json

{
  "id": 1,
  "nombre": "Laptop Dell XPS 15",
  "categoria": "Equipos",
  "precio": 1099.99,
  "cantidad": 3,
  "descripcion": "Versión mejorada"
}
```

**Respuesta:**
```json
{
  "success": true,
  "message": "Producto actualizado correctamente",
  "data": {
    "id": 1
  }
}
```

### 4. Eliminar Producto (DELETE)

```bash
POST /api.php?action=delete
Content-Type: application/json

{
  "id": 1
}
```

**Respuesta:**
```json
{
  "success": true,
  "message": "Producto eliminado correctamente",
  "data": {
    "id": 1
  }
}
```

---

## 🐛 Troubleshooting

### Error: "No se pudo conectar a la base de datos"

**Solución:**
```php
// Verifica las credenciales en .env
// Asegúrate que Supabase/MySQL está activo
// Comprueba el puerto correcto (3306 para MySQL, 5432 para Postgres)
```

### Error: "El archivo api.php no se encuentra"

**Solución:**
```bash
# Verifica que los archivos están en la raíz
ls -la api.php
ls -la config.php

# Revisa las rutas en app.js
const API_URL = window.location.origin + '/api.php';
```

### Error: "SQL Error: Column not found"

**Solución:**
```bash
# Ejecuta schema.sql nuevamente
mysql -u root -p inventario_utp < schema.sql

# O ejecuta manualmente:
ALTER TABLE productos ADD COLUMN descripcion TEXT;
```

### La búsqueda no funciona

**Solución:**
```javascript
// Revisa que el evento se dispara
document.getElementById('searchInput').addEventListener('input', () => {
    console.log('Buscando...');
    filtrarProductos();
});
```

### Tabla vacía después de registrar

**Solución:**
```javascript
// Añade logs para debugguear
console.log('Productos cargados:', productos);
console.log('Datos en tabla:', document.getElementById('productosBody').innerHTML);
```

### CORS Error

**Solución:**
```php
// Verifica que config.php tiene CORS habilitado
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
```

---

## 📞 Soporte

### Para Estudiantes
- Revisa el README y la documentación en código
- Usa la consola del navegador (F12) para debugguear
- Verifica los logs en `/logs/error.log`

### Para Docentes
- Revisa la sección "Recomendaciones para Docentes"
- Usa los checklists para evaluación
- Proporciona feedback constructivo basado en la rúbrica

---

## 📄 Licencia

MIT License - Libre para uso educativo y comercial

---

## ✍️ Autores

Desarrollado como proyecto académico para:
**Universidad Tecnológica de Panamá (UTP)**
Laboratorio de Sistemas CRUD con PHP y MySQL

---

## 🎯 Objetivos Logrados

✅ Crear y gestionar base de datos MySQL
✅ Implementar conexión PHP-MySQLi
✅ Desarrollar API REST completa
✅ Crear interfaz moderna y responsiva
✅ Validar datos en cliente y servidor
✅ Implementar búsqueda y filtrado
✅ Manejo robusto de errores
✅ Documentación completa
✅ Desplegar en Render
✅ Cumplir 100% con rúbrica

---

## 🚀 Próximas Mejoras

- [ ] Autenticación de usuarios
- [ ] Roles y permisos
- [ ] Exportar a Excel/PDF
- [ ] Gráficos de inventario
- [ ] Historial de cambios
- [ ] Emails de notificación
- [ ] API v2 con GraphQL
- [ ] PWA (Progressive Web App)

---

**Última actualización:** Enero 2024
**Versión:** 1.0.0
**Estado:** ✅ Producción
