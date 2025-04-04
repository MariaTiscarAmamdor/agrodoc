<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "Acceso no autorizado a la página de administración.";
    exit;
}

$datos = unserialize($_SESSION['usuario']); 
$tipo = $datos['tipo'] ?? '';

switch ($tipo) {
    case 'admin':
        include __DIR__ . '/../views/app_admin.php';
        break;
    case 'contratista':
        include __DIR__ . '/../views/app_contratista.php';
        break;
    case 'proveedor':
        include __DIR__ . '/../views/app_proveedor.php';
        break;
    default:
        echo "Acceso no autorizado.";
        break;
}
