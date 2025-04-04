<?php 
include_once(__DIR__ . '/../controllers/ProvController.php'); 

$bloque = array(); 
$bloque[0]=$_POST["nombre"]; 
$bloque[1]=$_POST["apellidos"]; 
$bloque[2]=$_POST["cif"]; 
$bloque[3]=$_POST["email"];  
$bloque[4]=$_POST["telefono"]; 
$bloque[5]=$_POST["direccion"]; 

$datosSerializados = serialize($bloque); 

$controller = new ProvController();
$controller->setProveedor($datosSerializados);

//Si todo está bien, redirigimos al panel de administración
header("Location: /views/app_admin.php?opcion=5"); 
exit();







