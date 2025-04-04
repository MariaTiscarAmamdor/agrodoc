<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: /views/login.php");
    exit;
}

$usuario = unserialize($_SESSION['usuario']);
$tipo = $usuario['tipo'] ?? '';
include_once('../controllers/ContController.php');

$controller = new ContController();
$datos = $controller->getContratistas();
?>

<div class="volver">
    <a href="javascript:cargar('#portada','/views/app_admin.php');"><button>Volver</button></a>
</div>

<h2> Lista de Contratistas </h2>
<table id="contratistasTabla">
    <thead>
        <tr>
            <th>id</th>
            <th>Nombre</th>
            <th>CIF</th>
            <th>Correo</th>
            <th>Telefono</th>
            <th>Dirección</th>
            <?php if ($tipo === 'admin'): ?>
                <th>Modificar</th>
                <th>Eliminar</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($datos as $contratista): ?>
            <tr data-id="<?= $contratista['id_cont'] ?>">
                <td><?= $contratista['id_cont'] ?></td>
                <td class='editable'><?= $contratista['nombre'] ?></td>
                <td class='editable'><?= $contratista['cif'] ?></td>
                <td class='editable'><?= $contratista['email'] ?></td>
                <td class='editable'><?= $contratista['telefono'] ?></td>
                <td class='editable'><?= $contratista['direccion'] ?></td>
                <?php if ($tipo === 'admin'): ?>
                    <td>
                        <button class="editar">Modificar</button>
                        <button class="guardar" style="display:none;">Guardar</button>
                    </td>
                    <td>
                        <button class="eliminar" onclick="eliminarProveedor(<?= $proveedor['id_prov'] ?>)">Eliminar</button>
                    </td>
                <?php endif; ?>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Botón para crear usuario -->
<?php if ($tipo === 'admin'): ?>
    <!-- Botón para crear proveedor solo si es administrador -->
    <div class="enlace_crear">
        <a href="javascript:cargar('#portada','/views/nuevo_cont.php');">
            <button>Crear proveedor</button>
        </a>
    </div>
<?php endif; ?>
<?php if ($tipo === 'proveedor'): ?>
    <div class="enlace_crear">
        <a href="javascript:cargar('#portada','/views/vercontratistas_proveedor.php');">
            <button>Ver contratistas con los que trabajas</button>
        </a>
    </div>
<?php endif; ?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="/assets/js/contratistas.js"></script>
<script src="/assets/js/modificar_cont.js"></script>