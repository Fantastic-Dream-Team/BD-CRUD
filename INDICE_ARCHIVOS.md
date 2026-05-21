# 📑 ÍNDICE DE ARCHIVOS DEL PROYECTO

## 🎯 Vista Rápida

Este archivo te ayuda a entender qué hace cada archivo del proyecto.

---

## 📁 ARCHIVOS DEL PROYECTO

### 🔴 ARCHIVOS CRÍTICOS (DEBE HABER 5)

#### 1️⃣ `index.html` (13 KB)
**Tipo:** Frontend - HTML
**Propósito:** Página principal de la aplicación
**Contiene:**
- Header con logo y estadísticas
- Formulario para registrar productos
- Tabla responsiva de productos
- Modales para edición y confirmación
- Footer

**Cómo se usa:**
```
Usuario abre https://tu-app.com/index.html
↓
Ve el formulario y la tabla
↓
Interactúa con los elementos
↓
JavaScript (app.js) maneja los eventos
```

---

#### 2️⃣ `styles.css` (19 KB)
**Tipo:** Frontend - CSS
**Propósito:** Estilos visuales de la aplicación
**Contiene:**
- Variables CSS (colores, espaciado, etc.)
- Estilos del header, formulario, tabla
- Animaciones suaves
- Responsive design (mobile/tablet/desktop)
- Modo oscuro automático
- Accesibilidad (WCAG 2.1 AA)

**Cumple:** Human Interface Guidelines (HIG)

**Clases principales:**
```css
.app-container       /* Contenedor principal */
.app-header          /* Encabezado */
.form-section        /* Sección del formulario */
.table-section       /* Sección de tabla */
.btn, .btn-primary   /* Botones */
.modal               /* Modales */
```

---

#### 3️⃣ `app.js` (18 KB)
**Tipo:** Frontend - JavaScript
**Propósito:** Lógica interactiva del frontend
**Contiene:**
- Carga de productos (READ)
- Crear productos (CREATE)
- Editar productos (UPDATE)
- Eliminar productos (DELETE)
- Búsqueda y filtrado
- Validación de formularios
- Manejo de modales
- Comunicación con API

**Funciones principales:**
```javascript
cargarProductos()           // GET /api.php?action=read
crearProducto(data)         // POST /api.php?action=create
actualizarProducto(id, data) // POST /api.php?action=update
eliminarProducto(id)        // POST /api.php?action=delete
filtrarProductos()          // Búsqueda en tiempo real
validarFormulario()         // Validación cliente
```

---

#### 4️⃣ `api.php` (11 KB)
**Tipo:** Backend - PHP
**Propósito:** API REST para operaciones CRUD
**Contiene:**
- Endpoint READ (obtener productos)
- Endpoint CREATE (crear producto)
- Endpoint UPDATE (actualizar producto)
- Endpoint DELETE (eliminar producto)
- Validación de datos
- Manejo de errores

**Endpoints:**
```php
GET  /api.php?action=read     → readProductos()
POST /api.php?action=create   → crearProducto()
POST /api.php?action=update   → actualizarProducto()
POST /api.php?action=delete   → eliminarProducto()
```

**Características:**
- Prepared statements (seguridad)
- Try-catch para errores
- Respuestas JSON
- Logging de actividades

---

#### 5️⃣ `config.php` (4.5 KB)
**Tipo:** Backend - PHP
**Propósito:** Configuración y conexión a base de datos
**Contiene:**
- Conexión MySQLi a BD
- Funciones de validación
- Funciones sanitización
- Headers CORS
- Funciones utilitarias

**Funciones principales:**
```php
mysqli()              // Conexión a BD
sanitize()            // Limpiar datos
validateRequired()    // Validar campos requeridos
validatePrice()       // Validar precios
validateQuantity()    // Validar cantidad
respondJSON()         // Responder en JSON
logActivity()         // Registrar actividades
```

---

### 🟡 ARCHIVOS DE BASE DE DATOS

#### 6️⃣ `schema.sql` (2.9 KB)
**Tipo:** Database - SQL
**Propósito:** Script para crear estructura de BD
**Contiene:**
- Crear base de datos `inventario_utp`
- Crear tabla `productos`
- Campos: id, nombre, categoria, precio, cantidad, descripcion, estado, timestamps
- Índices para búsquedas rápidas
- Datos de ejemplo (8 productos)

**Cómo usar:**
```bash
# Local
mysql -u root -p inventario_utp < schema.sql

# Supabase
1. SQL Editor
2. New Query
3. Pega contenido
4. Run
```

**Tabla productos:**
```sql
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    cantidad INT NOT NULL DEFAULT 0,
    descripcion TEXT,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
```

---

### 🟢 ARCHIVOS DE CONFIGURACIÓN

#### 7️⃣ `.env.example` (422 bytes)
**Tipo:** Configuración
**Propósito:** Plantilla de variables de entorno
**Contiene:**
- DB_HOST
- DB_USER
- DB_PASSWORD
- DB_NAME
- DB_PORT
- APP_ENV
- APP_DEBUG
- TIMEZONE

**Cómo usar:**
```bash
# Copiar
cp .env.example .env

# Editar con tus datos
nano .env
```

**En Render:**
Las variables se configuran en el dashboard (no necesitas .env)

---

#### 8️⃣ `.gitignore` (653 bytes)
**Tipo:** Configuración
**Propósito:** Archivos a ignorar en Git
**Contiene:**
- .env (variables sensibles)
- logs/ (archivos de log)
- node_modules/
- .vscode/
- .DS_Store

**Por qué es importante:**
No queremos subir a GitHub archivos sensibles como contraseñas

---

#### 9️⃣ `render.yaml` (972 bytes)
**Tipo:** Configuración
**Propósito:** Configuración para desplegar en Render
**Contiene:**
- Environment: PHP
- Start command
- Variables de entorno
- Health check
- Port

**Cómo usa Render:**
1. Lee render.yaml
2. Configura automáticamente
3. Deploy

---

### 📚 ARCHIVOS DE DOCUMENTACIÓN

#### 🔟 `README.md` (17 KB)
**Tipo:** Documentación
**Propósito:** Documentación completa del proyecto
**Contiene:**
- Descripción del proyecto
- Requisitos del laboratorio
- Rúbrica de evaluación
- Instrucciones de instalación
- Configuración
- Estructura del proyecto
- Guía de uso
- Recomendaciones para docentes
- Endpoints API
- Troubleshooting

**Público:** Estudiantes, Docentes, Usuarios
**Lectura recomendada:** PRIMERO

---

#### 1️⃣1️⃣ `DEPLOYMENT_RENDER.md` (6.6 KB)
**Tipo:** Documentación
**Propósito:** Guía paso a paso para desplegar en Render
**Contiene:**
- Crear cuenta Supabase
- Crear base de datos
- Crear repositorio GitHub
- Desplegar en Render
- Configurar variables
- Verificar funcionamiento
- Troubleshooting
- URLs de producción

**Público:** Docentes, estudiantes que despliegan
**Lectura recomendada:** Antes de desplegar

---

#### 1️⃣2️⃣ `RESUMEN_EJECUTIVO.md` (9.4 KB)
**Tipo:** Documentación
**Propósito:** Resumen visual del proyecto
**Contiene:**
- Visión general
- Archivos generados
- Deployment en 5 minutos
- Rúbrica cumplida
- Características implementadas
- Endpoints API
- Responsive design
- Recomendaciones cumplidas
- Estadísticas de código
- Seguridad implementada

**Público:** Docentes, directores
**Lectura recomendada:** Para evaluación rápida

---

#### 1️⃣3️⃣ `INDICE_ARCHIVOS.md` (Este archivo)
**Tipo:** Documentación
**Propósito:** Explicar qué hace cada archivo
**Contiene:**
- Descripción de cada archivo
- Propósito y contenido
- Cómo se usa
- Funciones principales

**Público:** Todos
**Lectura recomendada:** Para entender la estructura

---

### 📁 CARPETAS

#### `logs/` (creada en runtime)
**Propósito:** Almacenar archivos de log
**Contiene:**
- `error.log` - Errores PHP
- `activity.log` - Actividades de usuarios

**Se crea automáticamente** cuando se ejecuta `config.php`

---

## 🔄 FLUJO DE DATOS

```
USUARIO                FRONTEND              BACKEND              BASE DE DATOS
   │                      │                      │                      │
   ├─ llena formulario ──→ │                      │                      │
   │                      │                      │                      │
   ├─ hace click ────────→ app.js valida         │                      │
   │                      │                      │                      │
   ├─ (validación OK) ───→ │                      │                      │
   │                      │                      │                      │
   │                      ├─ fetch POST ────────→ api.php               │
   │                      │                      │                      │
   │                      │                      ├─ config.php valida   │
   │                      │                      │                      │
   │                      │                      ├─ prepara query ──────→ MySQL
   │                      │                      │                      │
   │                      │                      │                      ├─ ejecuta
   │                      │                      │                      │
   │                      │                      │ ← JSON response ──────┤
   │                      │                      │                      │
   │                      │ ← JSON response ────→│                      │
   │                      │                      │                      │
   ├─ actualiza UI ←──────┤                      │                      │
   │                      │                      │                      │
   ├─ ve resultado ◄──────┤                      │                      │
   │                      │                      │                      │
```

---

## 🎯 PROPÓSITO DE CADA CAPA

### Frontend (Presentación)
```
Archivos: index.html, styles.css, app.js

Responsabilidades:
- Mostrar interfaz visual
- Validar datos localmente
- Comunicar con API
- Actualizar UI en tiempo real
- Manejar eventos del usuario
```

### Backend (Lógica)
```
Archivos: api.php, config.php

Responsabilidades:
- Validar datos del servidor
- Ejecutar queries SQL
- Manejar errores
- Loguear actividades
- Responder en JSON
```

### Base de Datos (Datos)
```
Archivos: schema.sql

Responsabilidades:
- Almacenar datos
- Indexar para búsquedas rápidas
- Mantener integridad
- Permitir transacciones
```

---

## 📊 TAMAÑO DE ARCHIVOS

| Archivo | Tamaño | Descripción |
|---------|--------|-------------|
| index.html | 13 KB | Frontend |
| styles.css | 19 KB | Estilos |
| app.js | 18 KB | Lógica Frontend |
| api.php | 11 KB | API REST |
| config.php | 4.5 KB | Configuración |
| schema.sql | 2.9 KB | Base de datos |
| README.md | 17 KB | Documentación |
| **TOTAL** | **~85 KB** | **Muy liviano** |

---

## 🔐 ARCHIVOS A PROTEGER

### ⚠️ NO SUBIR A GITHUB
- `.env` (credenciales)
- `logs/` (información sensible)
- Archivos de backup de BD

### ✅ SUBIR A GITHUB
- Código fuente (*.php, *.js, *.html, *.css)
- `.gitignore` (para proteger archivos)
- Documentación
- `.env.example` (plantilla)

---

## 🚀 ORDEN DE LECTURA RECOMENDADO

### Para Estudiantes
1. **RESUMEN_EJECUTIVO.md** (5 min) - Overview
2. **README.md** (20 min) - Documentación completa
3. **index.html** (10 min) - Ver estructura HTML
4. **styles.css** (10 min) - Entender estilos
5. **app.js** (15 min) - Entender lógica JavaScript
6. **api.php** (10 min) - Entender backend
7. **config.php** (5 min) - Entender configuración

### Para Docentes
1. **RESUMEN_EJECUTIVO.md** (5 min) - Evaluar completitud
2. **README.md** - Rúbrica de evaluación (3 min)
3. **Código fuente** - Revisar (30 min)
4. **DEPLOYMENT_RENDER.md** (5 min) - Si van a desplegar

### Para Deployment
1. **DEPLOYMENT_RENDER.md** (20 min) - Paso a paso
2. **schema.sql** (2 min) - Crear BD
3. **Crear repositorio GitHub** (5 min)
4. **Configurar Render** (5 min)

---

## 💡 CASOS DE USO

### "Necesito entender la estructura"
→ Lee: `INDICE_ARCHIVOS.md` (este archivo)

### "Necesito ver el código"
→ Lee: Archivos de código (.php, .js, .html, .css)

### "Necesito desplegar a producción"
→ Lee: `DEPLOYMENT_RENDER.md`

### "Necesito evaluar completitud"
→ Lee: `RESUMEN_EJECUTIVO.md` y `README.md`

### "Necesito hacer cambios"
→ Lee: Código comentado + `README.md`

---

## ✅ CHECKLIST DE VERIFICACIÓN

- [ ] Todos los 5 archivos críticos existen
- [ ] Base de datos está creada
- [ ] Formulario funciona
- [ ] Tabla muestra datos
- [ ] Búsqueda funciona
- [ ] Edición funciona
- [ ] Eliminación funciona
- [ ] Errores son validados
- [ ] Código está comentado
- [ ] Documentación es completa

---

## 📞 ¿DÓNDE ENCONTRAR...?

| Qué | Dónde |
|-----|-------|
| Formulario HTML | `index.html` |
| Estilos CSS | `styles.css` |
| Lógica JavaScript | `app.js` |
| Endpoints API | `api.php` |
| Validaciones PHP | `config.php` |
| Base de datos SQL | `schema.sql` |
| Instrucciones instalación | `README.md` |
| Guía deployment | `DEPLOYMENT_RENDER.md` |
| Resumen evaluación | `RESUMEN_EJECUTIVO.md` |
| Información sensible | `.env` (no incluido) |

---

**¡Ahora sabes qué hace cada archivo! 🎉**

Próximo paso: Leer `README.md` para entender el proyecto completo.
