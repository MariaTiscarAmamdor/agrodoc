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
} else if($tipo === 'proveedor'){
    $idProv = $usuario['id_prov'];
    $datos = $controller->getProyectosPorProveedor($idProv);
}
else {
   
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
            <th>Ver en mapa</th> 
            <th>Tipo de cultivo</th>           
            <th>Contratista</th>
            <th>Proveedor</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>            
            <?php if ($tipo === 'admin' || $tipo === 'contratista'): ?>
                <th>Modificar</th>
                <th>Eliminar</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($datos as $proyecto): ?>
            <tr data-id="<?= $proyecto['id_proyec'] ?>">
                <td><?= $proyecto['id_proyec'] ?></td>
                <td id="localizacion"><?= $proyecto['localizacion_finca'] ?? 'No disponible' ?></td> 
                <td><a href="javascript:void(0);" class="enlace_mapa">Ver en mapa</a></td> 
                <td><?= $proyecto['tipo_cultivo'] ?? 'No disponible' ?></td>              
                <td><?= $proyecto['nombre_contratista'] ?? 'No disponible' ?></td>
                <td><?= $proyecto['nombre_proveedor'] ?? 'No disponible' ?></td>
                <td class='editable'><?= $proyecto['fecha_inicio'] ?></td>
                <td class='editable'><?= $proyecto['fecha_fin'] ?></td>                
                <?php if ($tipo === 'admin' || $tipo === 'contratista'): ?>
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
<div id="mapContainer">
    <div id="map"></div> 
    <button class="cerrar_mapa" onclick="cerrarMapa()">✖</button>   
</div>
<?php if ($tipo === 'admin' || $tipo === 'contratista'): ?>
    <div class="enlace_crear">
    <a href="javascript:cargar('#portada','/views/nuevo_proyec.php');">
        <button>Nueva campaña</button>
        </a>
    </div>
<?php endif; ?>

<?php if ($tipo === 'proveedor'): ?>
    <div class="enlace_crear">
        <a href="javascript:cargar('#portada','/views/vertrabajadores_proyecto.php');">
            <button>Ver trabajadores por campaña</button>
        </a>
    </div>
<?php endif; ?>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="/assets/js/proyectos.js"></script>
<script src="/assets/js/modificar_proyec.js"></script>
<script src="/assets/js/ver_mapa.js"></script>