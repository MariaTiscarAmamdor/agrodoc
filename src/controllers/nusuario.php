<?php 
include_once(__DIR__ . '/../controllers/UserController.php'); 

$bloque = array(); 
$bloque[0] = $_POST["usuario"] ?? null; 
$bloque[1] = $_POST["clave"] ?? null; 
$bloque[2] = $_POST["nombre"] ?? null;  
$bloque[3] = $_POST["tipo"] ?? null; 
$bloque[4] = isset($_POST["id_cont"]) && $_POST["tipo"] === "contratista" ? $_POST["id_cont"] : null;  
$bloque[5] = isset($_POST["id_prov"]) && $_POST["tipo"] === "proveedor" ? $_POST["id_prov"] : null;

$datosSerializados = serialize($bloque); 

$controller = new UserController();
$controller->setUsuario($datosSerializados);

//Si todo está bien, redirigimos al panel de administración
header("Location: /views/app_admin.php?opcion=1"); 
exit();







