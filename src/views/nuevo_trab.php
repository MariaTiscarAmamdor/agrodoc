<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: /app/login");
    exit;
}
$usuario = unserialize($_SESSION['usuario']);
$tipo = $usuario['tipo'] ?? '';
$idProv = $usuario['id_prov'] ?? null;
?>

<div class="volver">
    <a href="javascript:cargar('#portada','/views/vertrabajadores.php');"><button>Volver</button></a>
</div>

<div class="container_form">
    <h2 class="form-title"> Nuevo trabajador </h2>

    <form action="/controllers/ntrabajador.php" method="POST">
        <div>
            <label for="nombre">Nombre:</label>
            <input placeholder="Nombre" required="required" name="nombre" type="text" id="nombre">
        </div>

        <div>
            <label for="apellidos">Apellidos:</label>
            <input placeholder="Apellidos" required="required" name="apellidos" type="text" id="apellidos">
        </div>

        <div>
            <label for="dni">DNI:</label>
            <input placeholder="DNI" required="required" name="dni" type="text" id="dni">
        </div>

        <div>
            <label for="email">Correo Electrónico:</label>
            <input placeholder="Email" required="required" name="email" type="email" id="email">
        </div>

        <div>
            <label for="telefono">Teléfono:</label>
            <input placeholder="Teléfono" required="required" name="telefono" type="text" id="telefono">
        </div>

        <div>
            <label for="direccion">Dirección:</label>
            <input placeholder="Dirección" required="required" name="direccion" type="text" id="direccion">
        </div>

        <div>
            <label for="documentos">Tiene documentos:</label>
            <select name="documentos" id="documentos">
                <option value="1">Sí</option>
                <option value="0">No</option>
            </select>
        </div>

        <!-- Desplegable de proveedores -->
        <?php if ($tipo === 'admin'): ?>
        <div id="proveedorField">
            <label for="id_prov">Selecciona un proveedor:</label>
            <select name="id_prov" id="id_prov">
                <option value="">-- Seleccionar Proveedor --</option>
            </select>
        </div>
        <?php else: ?>
             <!-- insertamos automáticamente su id -->
            <input type="hidden" name="id_prov" value="<?= $idProv ?>">
        <?php endif; ?>

        <input type="submit" value="Insertar" class="submit-btn">
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="/assets/js/nuevo_trab.js"></script>