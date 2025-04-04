<?php 
include_once(__DIR__ . '/../controllers/FincasController.php'); 
session_start();

$bloque = array(); 
$bloque[0]=$_POST["localizacion"]; 
$bloque[1]=$_POST["cultivo"]; 
$bloque[2]=$_POST["hectarea"];  
$bloque[3]=$_POST["id_cont"];  

$datosSerializados = serialize($bloque); 

$controller = new FincasController();
$controller->setFinca($datosSerializados);

// Redirigimos según el tipo de usuario
$tipo = $_SESSION['usuario'] ? unserialize($_SESSION['usuario'])['tipo'] : null;

if ($tipo === 'admin') {
    header("Location: /views/app_admin.php?opcion=3");
} else {

    header("Location: /views/app_contratista.php?opcion=1");
}
exit();









