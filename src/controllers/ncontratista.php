<?php 
include_once(__DIR__ . '/../controllers/ContController.php'); 

$bloque = array(); 
$bloque[0]=$_POST["nombre"]; 
$bloque[1]=$_POST["cif"]; 
$bloque[2]=$_POST["email"];  
$bloque[3]=$_POST["telefono"]; 
$bloque[4]=$_POST["direccion"]; 

$datosSerializados = serialize($bloque); 

$controller = new ContController();
$controller->setContratista($datosSerializados);

//Si todo está bien, redirigimos al panel de administración
header("Location: /views/app_admin.php?opcion=2"); 
exit();







