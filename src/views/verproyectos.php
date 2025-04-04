<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: /app/login");
    exit;
}

$usuario = unserialize($_SESSION['usuario']);
$tipo = $usuario['tipo'] ?? '';

include_once('../controllers/ProyecController.php');

$controller = new ProyecController();

if ($tipo === 'contratista') {
    $idCont = $usuario['id_cont'];
    $datos = $controller->getProyectosPorContratista($idCont);
} else {
   
    $datos = $controller->getProyectos();
}

?>
<div id="datosUsuario" 
     data-tipo="<?= $tipo ?>" 
     data-id-cont="<?= $usuario['id_cont'] ?? '' ?>">
</div>
<h2>Lista de Campañas</h2>

<table id="proyectosTabla">
    <thead>
        <tr>
            <th>ID Campaña</th>
            <th>Finca</th>            
            <th>Contratista</th>
            <th>Proveedor</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>            
            <th>Modificar</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($datos as $proyecto): ?>
            <tr data-id="<?= $proyecto['id_proyec'] ?>">
                <td><?= $proyecto['id_proyec'] ?></td>
                <td><?= $proyecto['localizacion_finca'] ?? 'No disponible' ?></td>                
                <td><?= $proyecto['nombre_contratista'] ?? 'No disponible' ?></td>
                <td><?= $proyecto['nombre_proveedor'] ?? 'No disponible' ?></td>
                <td class='editable'><?= $proyecto['fecha_inicio'] ?></td>
                <td class='editable'><?= $proyecto['fecha_fin'] ?></td>                
                <td>
                    <button class="editar">Modificar</button>
                    <button class="guardar" style="display:none;">Guardar</button>
                </td> 
                <td>
                    <button class="eliminar" onclick="eliminarProyecto(<?= $proyecto['id_proyec'] ?>)">Eliminar</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="enlace_crear">
    <a href="javascript:cargar('#portada','/views/nuevo_proyec.php');">
        <button>Crear campaña</button>
    </a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="/assets/js/proyectos.js"></script>
<script src="/assets/js/modificar_proyec.js"></script>