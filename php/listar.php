<?php
include 'conexion.php';

// ── Consulta SELECT ──────────────────────────────
$sql = "SELECT * FROM productos ORDER BY id DESC";
$resultado = mysqli_query($conexion, $sql);

// ── Error en la consulta ─────────────────────────
if (!$resultado): ?>
    <div class="alert alert-danger" role="alert">
        <strong>Error en la consulta:</strong> <?= mysqli_error($conexion) ?>
    </div>
<?php return; endif; ?>

<!-- ── Alertas de acciones ── -->
<?php if (isset($_GET['msg'])):
    $mensajes = [
        'creado'    => ['texto' => '✅ Producto registrado correctamente.',  'clase' => 'alert-success'],
        'editado'   => ['texto' => '✏️ Producto actualizado correctamente.', 'clase' => 'alert-primary'],
        'eliminado' => ['texto' => '🗑️ Producto eliminado correctamente.',   'clase' => 'alert-warning'],
        'error'     => ['texto' => '❌ Ocurrió un error. Intenta de nuevo.', 'clase' => 'alert-danger'],
    ];
    $msg = $_GET['msg'];
    if (array_key_exists($msg, $mensajes)): ?>
        <div class="alert <?= $mensajes[$msg]['clase'] ?> alert-dismissible fade show" role="alert">
            <?= $mensajes[$msg]['texto'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif;
endif; ?>

<!-- ── Tabla de productos ──────────────────────── -->
<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered align-middle mb-0">

        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php if (mysqli_num_rows($resultado) > 0): ?>

                <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td class="text-muted small"><?= $fila['id'] ?></td>
                    <td class="fw-medium"><?= htmlspecialchars($fila['nombre']) ?></td>
                    <td>
                        <span class="badge bg-secondary">
                            <?= htmlspecialchars($fila['categoria']) ?>
                        </span>
                    </td>
                    <td>$<?= number_format($fila['precio'], 2) ?></td>
                    <td>
                        <?php if ($fila['cantidad'] <= 5): ?>
                            <span class="text-danger fw-bold"><?= $fila['cantidad'] ?></span>
                            <span class="badge bg-danger ms-1">Bajo</span>
                        <?php else: ?>
                            <?= $fila['cantidad'] ?>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <button type="button" 
                           class="btn btn-warning btn-sm me-1"
                           data-bs-toggle="modal" 
                           data-bs-target="#modalEditar"
                           data-id="<?= $fila['id'] ?>"
                           data-nombre="<?= htmlspecialchars($fila['nombre']) ?>"
                           data-categoria="<?= htmlspecialchars($fila['categoria']) ?>"
                           data-precio="<?= $fila['precio'] ?>"
                           data-cantidad="<?= $fila['cantidad'] ?>">
                            ✏️ Editar
                        </button>
                        <a href="eliminar.php?id=<?= $fila['id'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('¿Seguro que deseas eliminar este producto?')">
                            🗑️ Eliminar
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>

            <?php else: ?>
                <!-- Sin productos registrados -->
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <div class="fs-1">📦</div>
                        <p class="mb-0">No hay productos registrados aún.</p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>

    </table>
</div>

<!-- ── Contador de registros ─────────────────── -->
<?php if (mysqli_num_rows($resultado) > 0): ?>
    <p class="text-muted small text-end mt-2 mb-0">
        <?= mysqli_num_rows($resultado) ?> producto(s) encontrado(s)
    </p>
<?php endif; ?>