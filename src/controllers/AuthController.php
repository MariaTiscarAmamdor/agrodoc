<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();  
}
include_once(__DIR__ . '/../models/basededatos.php');

class AuthController {
    private $bd;

    public function __construct() {
        $this->bd = new basededatos();
    }

    public function login($usuario, $clave) {
        $datosdeusuario = $this->bd->comprobarUsuario($usuario, $clave);
        return $datosdeusuario;
    }
}
?>
