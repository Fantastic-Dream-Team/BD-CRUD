<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema CRUD de Inventario Académico | UTP</title>
    <link rel="stylesheet" href="frontend/styles.css">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='75' font-size='75' fill='%23007AFF'>📦</text></svg>">
</head>
<body>
    <div class="app-container">
        <header class="app-header">
            <div class="header-content">
                <div class="header-title">
                    <span class="logo-icon">📦</span>
                    <div>
                        <h1>Inventario Académico</h1>
                        <p class="subtitle">Universidad Tecnológica de Panamá</p>
                    </div>
                </div>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-label">Productos</span>
                        <span class="stat-value" id="totalProductos">0</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Valor Total</span>
                        <span class="stat-value" id="valorTotal">$0.00</span>
                    </div>
                </div>
            </div>
        </header>

        <main class="app-main">
            <section class="form-section">
                <div class="section-header">
                    <h2>➕ Registrar Producto</h2>
                    <p class="section-subtitle">Añade nuevos productos al inventario</p>
                </div>

                <form id="formProducto" class="product-form" autocomplete="off">
                    <div class="form-group">
                        <label for="nombre" class="form-label">Nombre del Producto</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Ej: Laptop Dell XPS 13" class="form-input" required maxlength="100">
                        <span class="form-error" id="errorNombre"></span>
                    </div>

                    <div class="form-group">
                        <label for="categoria" class="form-label">Categoría</label>
                        <select id="categoria" name="categoria" class="form-input" required>
                            <option value="">-- Selecciona una categoría --</option>
                            <option value="Equipos">Equipos Informáticos</option>
                            <option value="Accesorios">Accesorios</option>
                            <option value="Cables">Cables y Conectores</option>
                            <option value="Software">Software y Licencias</option>
                            <option value="Consumibles">Consumibles</option>
                        </select>
                        <span class="form-error" id="errorCategoria"></span>
                    </div>

                    <div class="form-group">
                        <label for="precio" class="form-label">Precio Unitario ($)</label>
                        <input type="number" id="precio" name="precio" placeholder="0.00" class="form-input" step="0.01" min="0" required>
                        <span class="form-error" id="errorPrecio"></span>
                    </div>

                    <div class="form-group">
                        <label for="cantidad" class="form-label">Cantidad Disponible</label>
                        <input type="number" id="cantidad" name="cantidad" placeholder="0" class="form-input" min="0" required>
                        <span class="form-error" id="errorCantidad"></span>
                    </div>

                    <div class="form-group">
                        <label for="descripcion" class="form-label">Descripción (Opcional)</label>
                        <textarea id="descripcion" name="descripcion" placeholder="Agrega detalles adicionales del producto..." class="form-input form-textarea" maxlength="500"></textarea>
                        <span class="char-count"><span id="charCount">0</span>/500</span>
                    </div>

                    <input type="hidden" id="productoId" name="productoId" value="">

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" id="btnEnviar">
                            <span class="btn-icon">➕</span>
                            <span class="btn-text">Registrar Producto</span>
                        </button>
                        <button type="button" class="btn btn-secondary" id="btnLimpiar">
                            <span class="btn-icon">🗑️</span>
                            <span class="btn-text">Limpiar Formulario</span>
                        </button>
                    </div>

                    <div id="formMessage" class="form-message"></div>
                </form>
            </section>

            <section class="table-section">
                <div class="section-header">
                    <h2>📋 Productos Registrados</h2>
                    <div class="table-controls">
                        <input type="text" id="searchInput" placeholder="🔍 Buscar producto..." class="search-input">
                        <select id="filterCategoria" class="filter-select">
                            <option value="">Todas las categorías</option>
                            <option value="Equipos">Equipos Informáticos</option>
                            <option value="Accesorios">Accesorios</option>
                            <option value="Cables">Cables y Conectores</option>
                            <option value="Software">Software y Licencias</option>
                            <option value="Consumibles">Consumibles</option>
                        </select>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table class="products-table" id="productosTable">
                        <thead>
                            <tr>
                                <th class="col-id">ID</th>
                                <th class="col-nombre">Nombre</th>
                                <th class="col-categoria">Categoría</th>
                                <th class="col-precio">Precio</th>
                                <th class="col-cantidad">Cantidad</th>
                                <th class="col-valor">Valor Total</th>
                                <th class="col-acciones">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="productosBody">
                            <tr class="empty-state">
                                <td colspan="7">
                                    <div class="empty-state-content">
                                        <span class="empty-icon">📦</span>
                                        <p>No hay productos registrados</p>
                                        <small>Añade tu primer producto usando el formulario anterior</small>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table-footer">
                    <span id="resultCount">0 productos</span>
                </div>
            </section>
        </main>

        <footer class="app-footer">
            <p>Sistema CRUD de Inventario Académico | UTP © 2024</p>
            <p class="footer-note">Desarrollado con PHP, MySQL y JavaScript moderno</p>
        </footer>
    </div>

    <div id="modalConfirm" class="modal">
        <div class="modal-content">
            <h3 id="modalTitle">Confirmar acción</h3>
            <p id="modalMessage"></p>
            <div class="modal-actions">
                <button id="modalCancel" class="btn btn-secondary">Cancelar</button>
                <button id="modalConfirmButton" class="btn btn-danger">Confirmar</button>
            </div>
        </div>
    </div>

    <div id="modalEdit" class="modal">
        <div class="modal-content modal-edit">
            <div class="modal-header">
                <h3>Editar Producto</h3>
                <button class="modal-close" id="closeModalEdit">&times;</button>
            </div>
            <form id="formEditProducto" class="product-form">
                <div class="form-group">
                    <label for="editNombre" class="form-label">Nombre</label>
                    <input type="text" id="editNombre" class="form-input" required maxlength="100">
                </div>
                <div class="form-group">
                    <label for="editCategoria" class="form-label">Categoría</label>
                    <select id="editCategoria" class="form-input" required>
                        <option value="Equipos">Equipos Informáticos</option>
                        <option value="Accesorios">Accesorios</option>
                        <option value="Cables">Cables y Conectores</option>
                        <option value="Software">Software y Licencias</option>
                        <option value="Consumibles">Consumibles</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editPrecio" class="form-label">Precio ($)</label>
                    <input type="number" id="editPrecio" class="form-input" step="0.01" min="0" required>
                </div>
                <div class="form-group">
                    <label for="editCantidad" class="form-label">Cantidad</label>
                    <input type="number" id="editCantidad" class="form-input" min="0" required>
                </div>
                <div class="form-group">
                    <label for="editDescripcion" class="form-label">Descripción</label>
                    <textarea id="editDescripcion" class="form-input form-textarea" maxlength="500"></textarea>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" id="cancelEdit">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>

    <script src="frontend/app.js"></script>
</body>
</html>
