<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: /views/login.php");
    exit;
}

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
            <th>Modificar</th>
            <th>Eliminar</th>
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
                <td>
                    <button class="editar">Modificar</button>
                    <button class="guardar" style="display:none;">Guardar</button>
                </td>
                <td>
                    <button class="eliminar" onclick="eliminarContratista(<?= $contratista['id_cont'] ?>)">Eliminar</button>
                </td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Botón para crear usuario -->
<div class="enlace_crear">
    <a href="javascript:cargar('#portada','/views/nuevo_cont.php');">
        <button>Crear contratista</button>
    </a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="/assets/js/contratistas.js"></script>
<script src="/assets/js/modificar_cont.js"></script>