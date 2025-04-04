<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: /views/login.php");
    exit;
}

include_once('../controllers/TrabController.php');

$controller = new TrabController();
$datos = $controller->getTrabajadores();
?>

<div class="volver">
    <a href="javascript:cargar('#portada','/views/app_admin.php');"><button>Volver</button></a>
</div>

<h2>Lista de Trabajadores</h2>

<table id="trabajadoresTabla">
    <thead>
    <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>DNI</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Documentos</th>
                <th>Empresa</th>
                <th>Modificar</th>
                <th>Eliminar</th>
            </tr>
    </thead>
    <tbody>
        <?php foreach ($datos as $trabajador): ?>
            <tr data-id="<?= $trabajador['id_trab'] ?>">
                <td><?= $trabajador['id_trab'] ?></td>
                <td class='editable'><?= $trabajador['nombre'] ?></td>
                <td class='editable'><?= $trabajador['apellidos'] ?></td>
                <td class='editable'><?= $trabajador['dni'] ?></td>
                <td class='editable'><?= $trabajador['email'] ?></td>
                <td class='editable'><?= $trabajador['telefono'] ?></td>
                <td class='editable'><?= $trabajador['direccion'] ?></td>
                <td class='editable'><?= $trabajador['documentos'] ? 'Sí' : 'No' ?></td>
                <td><?= $trabajador['nombre_proveedor'] ?? 'No disponible' ?></td>
                <td>
                    <button class="editar">Modificar</button>
                    <button class="guardar" style="display:none;">Guardar</button>
                </td>
                <td>
                    <button class="eliminar" onclick="eliminarTrabajador(<?= $trabajador['id_trab'] ?>)">Eliminar</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="enlace_crear">
    <a href="javascript:cargar('#portada','/views/nuevo_trab.php');">
        <button>Crear trabajador</button>
    </a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="/assets/js/trabajadores.js"></script>
<script src="/assets/js/modificar_trab.js"></script>
