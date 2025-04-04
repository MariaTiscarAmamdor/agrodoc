<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$datos = unserialize($_SESSION['usuario']);
$nombre = $datos['nombre'] ?? 'Contratista';
$id = $datos['id_cont'];
?>
<div id="menuHamburguesa">&#9776;</div>
<nav id="nav" role="navigation">
    <div class="container_nav">
        <div class="container-selector">
            <a href="javascript:cargar('#portada','/views/verfincas.php?id=<?php echo $id; ?>');">Fincas</a>
        </div>
        <div class="container-selector">
            <a href="javascript:cargar('#portada','/views/verproyectos.php?id=<?php echo $id; ?>');">Campañas</a>
        </div>
        <div class="container-selector">
            <a href="javascript:cargar('#portada','/views/verproveedores.php');">Proveedores</a>
        </div>
    </div>
    <div class="usuario">
        <span><?php echo $nombre; ?></span>
        <div class="loging">
            <a href="/app/logout"><i class="fa-solid fa-right-from-bracket"></i> Salir</a>
        </div>
    </div>
</nav>
