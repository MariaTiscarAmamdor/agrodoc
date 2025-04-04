<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: /views/login.php");
    exit;
}
?>

<div class="volver">
    <a href="javascript:cargar('#portada','/views/verusuarios.php');"><button>Volver</button></a>
</div>

<div class="container_form">
    <h2 class="form-title"> Nuevo usuario </h2>

    <form action="/controllers/nusuario.php" method="POST">
        <div>
            <label for="usuario">Usuario:</label>
            <input placeholder="Usuario" required name="usuario" type="text" id="usuario">
        </div>
        <div>
            <label for="clave">Clave:</label>
            <input placeholder="Clave" required name="clave" type="password" id="clave">
        </div>
        <div>
            <label for="nombre">Nombre:</label>
            <input placeholder="Nombre" required name="nombre" type="text" id="nombre">
        </div>
        <div>
            <label for="tipo">Tipo:</label>
            <select name="tipo" id="tipo" required>
                <option value="admin">Administrador</option>
                <option value="contratista">Contratista</option>
                <option value="proveedor">Proveedor</option>
            </select>
        </div>

        <!-- Desplegable de contratistas -->
        <div id="contratistaField" style="display: none;">
            <label for="id_cont">Selecciona un contratista:</label>
            <select name="id_cont" id="id_cont">
                <option value="">-- Seleccionar Contratista --</option>
            </select>
        </div>

        <!-- Desplegable de proveedores -->
        <div id="proveedorField" style="display: none;">
            <label for="id_prov">Selecciona un proveedor:</label>
            <select name="id_prov" id="id_prov">
                <option value="">-- Seleccionar Proveedor --</option>
            </select>
        </div>

        <input type="submit" value="Insertar" class="submit-btn">
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="/assets/js/nuevo_usu.js"></script>
 <!-- <script src="/assets/js/usuarios.js"></script> -->
