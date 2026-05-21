/**
 * Sistema CRUD de Inventario Académico
 * Frontend - JavaScript
 * 
 * Maneja todas las interacciones del usuario y comunicación con el API PHP
 */

// ============================================
// CONFIGURACIÓN
// ============================================
const API_URL = 'backend/api.php';
let productos = [];
let productoEnEdicion = null;

// ============================================
// INICIALIZACIÓN
// ============================================
document.addEventListener('DOMContentLoaded', () => {
    console.log('✅ Aplicación iniciada');
    
    // Cargar productos
    cargarProductos();
    
    // Event Listeners del Formulario
    document.getElementById('formProducto').addEventListener('submit', handleFormSubmit);
    document.getElementById('btnLimpiar').addEventListener('click', limpiarFormulario);
    
    // Event Listeners de Búsqueda y Filtrado
    document.getElementById('searchInput').addEventListener('input', filtrarProductos);
    document.getElementById('filterCategoria').addEventListener('change', filtrarProductos);
    
    // Event Listeners de Modales
    document.getElementById('modalCancel').addEventListener('click', cerrarModal);
    document.getElementById('modalConfirmButton').addEventListener('click', handleConfirmarAccion);
    
    // Modal de Edición
    document.getElementById('closeModalEdit').addEventListener('click', cerrarModalEdit);
    document.getElementById('cancelEdit').addEventListener('click', cerrarModalEdit);
    document.getElementById('formEditProducto').addEventListener('submit', handleEditSubmit);
    
    // Contador de caracteres
    document.getElementById('descripcion').addEventListener('input', updateCharCount);
    document.getElementById('editDescripcion').addEventListener('input', updateCharCountEdit);
    
    // Cerrar modal al hacer clic fuera
    document.getElementById('modalConfirm').addEventListener('click', (e) => {
        if (e.target.id === 'modalConfirm') cerrarModal();
    });
    
    document.getElementById('modalEdit').addEventListener('click', (e) => {
        if (e.target.id === 'modalEdit') cerrarModalEdit();
    });
});

// ============================================
// CARGAR PRODUCTOS
// ============================================
/**
 * Obtener todos los productos del servidor
 */
async function cargarProductos() {
    try {
        mostrarCargando(true);
        
        const response = await fetch(`${API_URL}?action=read`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            productos = data.data || [];
            console.log(`✅ ${productos.length} productos cargados`);
            renderizarProductos(productos);
            actualizarEstadisticas();
        } else {
            mostrarError(data.message || 'Error al cargar productos');
        }
    } catch (error) {
        console.error('❌ Error al cargar productos:', error);
        mostrarError('Error de conexión. Verifica que el servidor está en línea.');
    } finally {
        mostrarCargando(false);
    }
}

// ============================================
// ENVIAR FORMULARIO (CREATE o UPDATE)
// ============================================
/**
 * Manejar el envío del formulario
 */
async function handleFormSubmit(event) {
    event.preventDefault();
    
    try {
        // Validar y obtener datos
        const formData = validarFormulario('formProducto');
        if (!formData) return;
        
        const productoId = document.getElementById('productoId').value;
        const isEditing = productoId !== '';
        
        if (isEditing) {
            // Actualizar producto existente
            await actualizarProducto(parseInt(productoId), formData);
        } else {
            // Crear producto nuevo
            await crearProducto(formData);
        }
    } catch (error) {
        console.error('❌ Error:', error);
        mostrarError(error.message);
    }
}

/**
 * Crear un nuevo producto
 */
async function crearProducto(data) {
    try {
        mostrarCargando(true);
        
        const response = await fetch(`${API_URL}?action=create`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (result.success) {
            mostrarExito('✅ Producto registrado correctamente');
            limpiarFormulario();
            await cargarProductos();
        } else {
            mostrarError(result.message);
        }
    } catch (error) {
        console.error('❌ Error al crear producto:', error);
        mostrarError('Error al crear producto');
    } finally {
        mostrarCargando(false);
    }
}

/**
 * Actualizar un producto existente
 */
async function actualizarProducto(id, data) {
    try {
        mostrarCargando(true);
        
        const response = await fetch(`${API_URL}?action=update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id, ...data })
        });
        
        const result = await response.json();
        
        if (result.success) {
            mostrarExito('✅ Producto actualizado correctamente');
            limpiarFormulario();
            cerrarModalEdit();
            await cargarProductos();
        } else {
            mostrarError(result.message);
        }
    } catch (error) {
        console.error('❌ Error al actualizar producto:', error);
        mostrarError('Error al actualizar producto');
    } finally {
        mostrarCargando(false);
    }
}

// ============================================
// EDICIÓN DE PRODUCTOS
// ============================================
/**
 * Abrir modal para editar producto
 */
function abrirModalEditar(producto) {
    productoEnEdicion = producto;
    
    // Llenar formulario con datos actuales
    document.getElementById('editNombre').value = producto.nombre;
    document.getElementById('editCategoria').value = producto.categoria;
    document.getElementById('editPrecio').value = producto.precio;
    document.getElementById('editCantidad').value = producto.cantidad;
    document.getElementById('editDescripcion').value = producto.descripcion || '';
    
    // Mostrar modal
    document.getElementById('modalEdit').classList.add('show');
}

/**
 * Manejar envío del formulario de edición
 */
async function handleEditSubmit(event) {
    event.preventDefault();
    
    try {
        const formData = {
            nombre: document.getElementById('editNombre').value.trim(),
            categoria: document.getElementById('editCategoria').value,
            precio: parseFloat(document.getElementById('editPrecio').value),
            cantidad: parseInt(document.getElementById('editCantidad').value),
            descripcion: document.getElementById('editDescripcion').value.trim()
        };
        
        await actualizarProducto(productoEnEdicion.id, formData);
    } catch (error) {
        console.error('❌ Error:', error);
        mostrarError(error.message);
    }
}

/**
 * Cerrar modal de edición
 */
function cerrarModalEdit() {
    document.getElementById('modalEdit').classList.remove('show');
    productoEnEdicion = null;
}

// ============================================
// ELIMINAR PRODUCTOS
// ============================================
/**
 * Confirmar eliminación
 */
function abrirConfirmacionEliminar(id, nombre) {
    document.getElementById('modalTitle').textContent = 'Eliminar Producto';
    document.getElementById('modalMessage').textContent = 
        `¿Estás seguro de que deseas eliminar "${nombre}"? Esta acción no se puede deshacer.`;
    
    const confirmButton = document.getElementById('modalConfirmButton');
    confirmButton.dataset.action = 'delete';
    confirmButton.dataset.id = id;
    
    document.getElementById('modalConfirm').classList.add('show');
}

/**
 * Manejar confirmación de acción
 */
async function handleConfirmarAccion() {
    const action = this.dataset.action;
    const id = parseInt(this.dataset.id);
    
    if (action === 'delete') {
        await eliminarProducto(id);
    }
    
    cerrarModal();
}

/**
 * Eliminar un producto
 */
async function eliminarProducto(id) {
    try {
        mostrarCargando(true);
        
        const response = await fetch(`${API_URL}?action=delete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id })
        });
        
        const result = await response.json();
        
        if (result.success) {
            mostrarExito('✅ Producto eliminado correctamente');
            await cargarProductos();
        } else {
            mostrarError(result.message);
        }
    } catch (error) {
        console.error('❌ Error al eliminar producto:', error);
        mostrarError('Error al eliminar producto');
    } finally {
        mostrarCargando(false);
    }
}

// ============================================
// VALIDACIÓN DE FORMULARIO
// ============================================
/**
 * Validar datos del formulario
 */
function validarFormulario(formId) {
    const form = document.getElementById(formId);
    const nombre = document.getElementById('nombre').value.trim();
    const categoria = document.getElementById('categoria').value;
    const precio = parseFloat(document.getElementById('precio').value);
    const cantidad = parseInt(document.getElementById('cantidad').value);
    
    // Limpiar errores previos
    document.querySelectorAll('.form-error').forEach(el => {
        el.classList.remove('show');
        el.textContent = '';
    });
    
    let tieneError = false;
    
    // Validar nombre
    if (!nombre) {
        mostrarErrorCampo('errorNombre', 'El nombre es requerido');
        tieneError = true;
    } else if (nombre.length > 100) {
        mostrarErrorCampo('errorNombre', 'El nombre no puede exceder 100 caracteres');
        tieneError = true;
    }
    
    // Validar categoría
    if (!categoria) {
        mostrarErrorCampo('errorCategoria', 'Selecciona una categoría');
        tieneError = true;
    }
    
    // Validar precio
    if (isNaN(precio) || precio < 0) {
        mostrarErrorCampo('errorPrecio', 'Ingresa un precio válido');
        tieneError = true;
    }
    
    // Validar cantidad
    if (isNaN(cantidad) || cantidad < 0 || !Number.isInteger(cantidad)) {
        mostrarErrorCampo('errorCantidad', 'La cantidad debe ser un número entero positivo');
        tieneError = true;
    }
    
    if (tieneError) return null;
    
    return {
        nombre,
        categoria,
        precio,
        cantidad,
        descripcion: document.getElementById('descripcion').value.trim()
    };
}

/**
 * Mostrar error en campo específico
 */
function mostrarErrorCampo(elementId, mensaje) {
    const elemento = document.getElementById(elementId);
    if (elemento) {
        elemento.textContent = mensaje;
        elemento.classList.add('show');
    }
}

// ============================================
// RENDERIZAR TABLA
// ============================================
/**
 * Renderizar productos en la tabla
 */
function renderizarProductos(items) {
    const tbody = document.getElementById('productosBody');
    
    if (!items || items.length === 0) {
        tbody.innerHTML = `
            <tr class="empty-state">
                <td colspan="7">
                    <div class="empty-state-content">
                        <span class="empty-icon">📦</span>
                        <p>No hay productos registrados</p>
                        <small>Añade tu primer producto usando el formulario anterior</small>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = items.map(producto => `
        <tr>
            <td class="col-id">${producto.id}</td>
            <td class="col-nombre">
                <strong>${escapeHtml(producto.nombre)}</strong>
                ${producto.descripcion ? `<br><small style="color: var(--color-neutral-400);">${escapeHtml(producto.descripcion)}</small>` : ''}
            </td>
            <td class="col-categoria">
                <span class="badge badge-category">${escapeHtml(producto.categoria)}</span>
            </td>
            <td class="col-precio">$${formatearNumero(producto.precio, 2)}</td>
            <td class="col-cantidad">
                <span class="badge ${obtenerBadgeStock(producto.cantidad)}">${producto.cantidad}</span>
            </td>
            <td class="col-valor">$${formatearNumero(producto.precio * producto.cantidad, 2)}</td>
            <td class="col-acciones">
                <div class="table-actions">
                    <button class="btn btn-small btn-primary btn-edit" data-producto='${JSON.stringify(producto).replace(/'/g, '&#039;')}' title="Editar">
                        ✏️
                    </button>
                    <button class="btn btn-small btn-danger btn-delete" data-id="${producto.id}" data-nombre="${escapeHtml(producto.nombre)}" title="Eliminar">
                        🗑️
                    </button>
                </div>
            </td>
        </tr>
    `).join('');

    tbody.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', () => {
            const producto = JSON.parse(button.dataset.producto);
            abrirModalEditar(producto);
        });
    });

    tbody.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', () => {
            abrirConfirmacionEliminar(parseInt(button.dataset.id, 10), button.dataset.nombre);
        });
    });
    
    // Actualizar contador
    document.getElementById('resultCount').textContent = 
        `${items.length} producto${items.length !== 1 ? 's' : ''}`;
}

/**
 * Obtener badge según cantidad en stock
 */
function obtenerBadgeStock(cantidad) {
    if (cantidad === 0) return 'badge-low';
    if (cantidad < 5) return 'badge-low';
    if (cantidad < 20) return 'badge-medium';
    return 'badge-medium';
}

// ============================================
// FILTRADO Y BÚSQUEDA
// ============================================
/**
 * Filtrar productos
 */
function filtrarProductos() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const categoria = document.getElementById('filterCategoria').value;
    
    const filtrados = productos.filter(producto => {
        const coincideNombre = producto.nombre.toLowerCase().includes(searchTerm) ||
                              producto.descripcion?.toLowerCase().includes(searchTerm);
        const coincideCategoria = !categoria || producto.categoria === categoria;
        
        return coincideNombre && coincideCategoria;
    });
    
    renderizarProductos(filtrados);
}

// ============================================
// ESTADÍSTICAS
// ============================================
/**
 * Actualizar estadísticas del header
 */
function actualizarEstadisticas() {
    const total = productos.length;
    const valorTotal = productos.reduce((sum, p) => sum + (p.precio * p.cantidad), 0);
    
    document.getElementById('totalProductos').textContent = total;
    document.getElementById('valorTotal').textContent = `$${formatearNumero(valorTotal, 2)}`;
}

// ============================================
// UTILITARIOS
// ============================================
/**
 * Formatear números
 */
function formatearNumero(valor, decimales = 0) {
    return parseFloat(valor).toLocaleString('es-PA', {
        minimumFractionDigits: decimales,
        maximumFractionDigits: decimales
    });
}

/**
 * Escapar caracteres especiales HTML
 */
function escapeHtml(texto) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return texto.replace(/[&<>"']/g, m => map[m]);
}

/**
 * Mostrar mensaje de éxito
 */
function mostrarExito(mensaje) {
    const el = document.getElementById('formMessage');
    el.textContent = mensaje;
    el.className = 'form-message success';
    
    setTimeout(() => {
        el.className = 'form-message';
    }, 3000);
}

/**
 * Mostrar mensaje de error
 */
function mostrarError(mensaje) {
    const el = document.getElementById('formMessage');
    el.textContent = '❌ ' + mensaje;
    el.className = 'form-message error';
}

/**
 * Mostrar/ocultar indicador de carga
 */
function mostrarCargando(estado) {
    const btn = document.getElementById('btnEnviar');
    if (estado) {
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner"></span> <span class="btn-text">Procesando...</span>';
    } else {
        btn.disabled = false;
        btn.innerHTML = '<span class="btn-icon">➕</span> <span class="btn-text">Registrar Producto</span>';
    }
}

/**
 * Limpiar formulario
 */
function limpiarFormulario() {
    document.getElementById('formProducto').reset();
    document.getElementById('productoId').value = '';
    document.getElementById('btnEnviar').innerHTML = '<span class="btn-icon">➕</span> <span class="btn-text">Registrar Producto</span>';
    
    // Limpiar errores
    document.querySelectorAll('.form-error').forEach(el => {
        el.classList.remove('show');
        el.textContent = '';
    });
    
    // Limpiar mensaje
    document.getElementById('formMessage').className = 'form-message';
    document.getElementById('charCount').textContent = '0';
}

/**
 * Actualizar contador de caracteres
 */
function updateCharCount() {
    const length = document.getElementById('descripcion').value.length;
    document.getElementById('charCount').textContent = length;
}

/**
 * Actualizar contador de caracteres (modal)
 */
function updateCharCountEdit() {
    const length = document.getElementById('editDescripcion').value.length;
    // Aquí puedríamos mostrar el contador en el modal también
}

/**
 * Cerrar modal de confirmación
 */
function cerrarModal() {
    document.getElementById('modalConfirm').classList.remove('show');
}

// ============================================
// LOG DE ACTIVIDAD
// ============================================
console.log('%c🎓 Sistema CRUD de Inventario Académico', 'color: #007AFF; font-size: 14px; font-weight: bold;');
console.log('%cDesarrollado para Universidad Tecnológica de Panamá', 'color: #5AC8FA; font-size: 12px;');
