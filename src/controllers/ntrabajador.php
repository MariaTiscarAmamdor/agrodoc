<?php 
include_once(__DIR__ . '/../controllers/TrabController.php'); 

$bloque = array(); 
$bloque[0]=$_POST["nombre"]; 
$bloque[1]=$_POST["apellidos"]; 
$bloque[2]=$_POST["dni"];  
$bloque[3]=$_POST["email"]; 
$bloque[4]=$_POST["telefono"]; 
$bloque[5]=$_POST["direccion"];
$bloque[6]=$_POST["documentos"]; 
$bloque[7]=$_POST["id_prov"];  

$datosSerializados = serialize($bloque); 

$controller = new TrabController();
$controller->setTrabajador($datosSerializados);

//Si todo está bien, redirigimos al panel de administración
header("Location: /views/app_admin.php?opcion=6"); 
exit();







