# 🚀 Guía de Deployment en Render

## Paso 1: Preparar Supabase (Base de Datos)

### 1.1 Crear cuenta en Supabase
- Ve a https://supabase.com
- Haz clic en "Sign Up"
- Registrate con email o GitHub
- Verifica tu email

### 1.2 Crear proyecto
- Haz clic en "New Project"
- Nombre: `inventario-utp`
- Contraseña: Elige una contraseña fuerte
- Región: Panama (si está disponible) o us-east-1
- Haz clic en "Create new project"

### 1.3 Esperar a que el proyecto se cree (2-3 minutos)

### 1.4 Crear la base de datos

Una vez creado el proyecto:

1. Ve a **SQL Editor** en el menú lateral
2. Haz clic en **"New Query"**
3. Pega el contenido del archivo `schema.sql`
4. Haz clic en **"Run"**
5. ¡Listo! La BD está creada

### 1.5 Obtener credenciales

1. Ve a **Project Settings** (esquina inferior izquierda)
2. Haz clic en **Database**
3. Copia estas credenciales:

```
Host: [xxxx].supabase.co
Usuario: postgres
Contraseña: [tu contraseña]
Base de datos: postgres
Puerto: 5432
```

⚠️ **IMPORTANTE**: Guarda estas credenciales en un lugar seguro

---

## Paso 2: Preparar Código para GitHub

### 2.1 Crear repositorio GitHub

1. Ve a https://github.com/new
2. Nombre del repositorio: `inventario-utp`
3. Descripción: "Sistema CRUD de Inventario - UTP"
4. Privado (recomendado)
5. Haz clic en "Create repository"

### 2.2 Subir código a GitHub

#### Opción A: Usando Git (Recomendado)

```bash
# Navega a la carpeta del proyecto
cd inventario-utp

# Inicializa Git
git init

# Agrega todos los archivos
git add .

# Crea un commit
git commit -m "Initial commit: Sistema CRUD de Inventario"

# Cambia el nombre de la rama (si es necesario)
git branch -M main

# Agrega el repositorio remoto (reemplaza USERNAME)
git remote add origin https://github.com/USERNAME/inventario-utp.git

# Sube el código
git push -u origin main
```

#### Opción B: Usando GitHub Desktop

1. Descarga GitHub Desktop: https://desktop.github.com
2. Abre tu repositorio
3. Haz clic en "Add Local Repository"
4. Selecciona tu carpeta del proyecto
5. Haz clic en "Publish repository"

### 2.3 Verificar que está en GitHub

- Ve a https://github.com/USERNAME/inventario-utp
- Verifica que ves todos los archivos:
  - ✅ index.html
  - ✅ styles.css
  - ✅ app.js
  - ✅ api.php
  - ✅ config.php
  - ✅ schema.sql
  - ✅ .env.example
  - ✅ README.md

---

## Paso 3: Desplegar en Render

### 3.1 Crear cuenta en Render

1. Ve a https://render.com
2. Haz clic en "Get Started"
3. Regístrate con GitHub (recomendado)
4. Autoriza a Render a acceder a tus repositorios

### 3.2 Conectar repositorio

1. Haz clic en **"New +"**
2. Selecciona **"Web Service"**
3. Selecciona tu repositorio: `inventario-utp`
4. Haz clic en **"Connect"**

### 3.3 Configurar el servicio

Complete los siguientes campos:

```
Name: inventario-utp
Environment: PHP
Plan: Free (suficiente para laboratorio)
Build Command: mkdir -p logs && chmod 755 logs
Start Command: php -S 0.0.0.0:10000
```

### 3.4 Agregar variables de entorno

1. Desplázate hacia abajo hasta **"Environment"**
2. Haz clic en **"Add Environment Variable"**
3. Agrega cada variable:

```
DB_HOST = xxxx.supabase.co
DB_USER = postgres
DB_PASSWORD = [tu contraseña de Supabase]
DB_NAME = postgres
DB_PORT = 5432
APP_ENV = production
APP_DEBUG = false
TIMEZONE = America/Panama
```

⚠️ **IMPORTANTE**: 
- Los valores deben coincidir exactamente con tus credenciales de Supabase
- `DB_PASSWORD` debe ser tu contraseña segura

### 3.5 Deploy

1. Desplázate al final
2. Haz clic en **"Create Web Service"**
3. Render comenzará a desplegar (toma 2-5 minutos)

### 3.6 Verificar deployment

Cuando veas **"Live"** en verde, tu aplicación está activa:

1. Haz clic en el enlace de tu servicio (ej: `https://inventario-utp.onrender.com`)
2. ¡Deberías ver tu aplicación! 🎉

---

## Paso 4: Verificar que todo funciona

### 4.1 Prueba básica

1. Abre tu sitio en Render
2. El formulario debe verse correctamente
3. Intenta registrar un producto
4. La tabla debe actualizarse
5. Intenta editar y eliminar

### 4.2 Si hay errores

**Error: "No se pudo conectar a la base de datos"**
- Verifica las credenciales en Variables de Entorno
- Asegúrate que Supabase está activo
- Revisa que `DB_PORT` es 5432 (no 3306)

**Error: 404 en api.php**
- Verifica que `api.php` está en la raíz
- Los archivos deben estar en GitHub
- Re-deploy: haz un pequeño cambio y sube a GitHub

**Error: Tabla vacía**
- Verifica que ejecutaste `schema.sql` en Supabase
- Revisa en Supabase SQL Editor que la tabla `productos` existe

### 4.3 Revisar logs

En el dashboard de Render:
1. Ve a tu servicio
2. Haz clic en **"Logs"**
3. Busca errores PHP
4. Si hay errores, corrígelos y sube nuevamente

---

## Paso 5: Updates y Mantenimiento

### Actualizar código

Si necesitas hacer cambios:

```bash
# Realiza cambios en tus archivos locales
# Luego:

git add .
git commit -m "Descripción del cambio"
git push origin main
```

**Render auto-deploy** automáticamente cuando hagas push

### Revisar base de datos

Para ver los datos en Supabase:

1. Ve a https://app.supabase.com
2. Selecciona tu proyecto
3. Ve a **"SQL Editor"** o **"Table Editor"**
4. Abre la tabla `productos`
5. Verás todos los registros

---

## Troubleshooting de Deployment

### El sitio muestra "Application Error"

```
Solución:
1. Ve a Render Dashboard
2. Haz clic en "Logs"
3. Busca el mensaje de error
4. Verifica las variables de entorno
5. Haz un re-deploy
```

### El API no responde

```
Solución:
1. Verifica que api.php está en la raíz
2. Revisa que config.php también está
3. Comprueba las credenciales de BD
4. Ejecuta: curl https://tu-site.onrender.com/api.php?action=read
```

### Base de datos no se conecta

```
Solución:
1. Ve a Supabase: https://app.supabase.com
2. Verifica que el proyecto está "Running"
3. Copia nuevamente las credenciales
4. Actualiza variables en Render
5. Haz re-deploy
```

---

## Información Importante

### URLs después del Deployment

- **Frontend**: `https://inventario-utp.onrender.com`
- **API**: `https://inventario-utp.onrender.com/api.php`

### Límites del Plan Free

- CPU: Compartida
- RAM: 512 MB
- Base de datos: 100 MB en Supabase (suficiente para este laboratorio)
- Inactividad: El servicio se pausa después de 15 min sin uso

Para producción, upgrade a plan pagado.

### Backups

Supabase hace backups automáticos. Para descargar:

1. Ve a Supabase Dashboard
2. Project Settings → Backups
3. Descarga cuando sea necesario

---

## Contacto y Soporte

- Render Support: https://render.com/support
- Supabase Docs: https://supabase.com/docs
- GitHub Help: https://docs.github.com

---

**¡Tu aplicación está lista para producción! 🚀**
