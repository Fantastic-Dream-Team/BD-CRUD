<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Inventario UTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                📦 Inventario UTP - Laboratorio
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Registrar Producto</h5>
                    </div>
                    <div class="card-body">
                        <form action="registrar.php" method="POST">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre del Producto</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej. Laptop Dell" required>
                            </div>
                            <div class="mb-3">
                                <label for="categoria" class="form-label">Categoría</label>
                                <input type="text" class="form-control" id="categoria" name="categoria" placeholder="Ej. Electrónica" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="precio" class="form-label">Precio ($)</label>
                                    <input type="number" step="0.01" class="form-control" id="precio" name="precio" placeholder="0.00" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cantidad" class="form-label">Cantidad</label>
                                    <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="0" required>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">📦 Guardar Producto</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h5 class="card-title mb-0">Lista de Productos en Existencia</h5>
                    </div>
                    <div class="card-body">
                        
                        <?php include 'listar.php'; ?>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal para Edición -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="editar.php" method="POST">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="modalEditarLabel">✏️ Editar Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label for="edit_nombre" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_categoria" class="form-label">Categoría</label>
                            <input type="text" class="form-control" id="edit_categoria" name="categoria" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_precio" class="form-label">Precio ($)</label>
                                <input type="number" step="0.01" class="form-control" id="edit_precio" name="precio" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_cantidad" class="form-label">Cantidad</label>
                                <input type="number" class="form-control" id="edit_cantidad" name="cantidad" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Script para cargar datos en el Modal
        const modalEditar = document.getElementById('modalEditar');
        if (modalEditar) {
            modalEditar.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                
                // Extraer info de los atributos data-*
                document.getElementById('edit_id').value = button.getAttribute('data-id');
                document.getElementById('edit_nombre').value = button.getAttribute('data-nombre');
                document.getElementById('edit_categoria').value = button.getAttribute('data-categoria');
                document.getElementById('edit_precio').value = button.getAttribute('data-precio');
                document.getElementById('edit_cantidad').value = button.getAttribute('data-cantidad');
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
