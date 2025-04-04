<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: /views/login.php");
    exit;
}

$usuario = unserialize($_SESSION['usuario']);
$tipo = $usuario['tipo'] ?? '';
$idCont = $usuario['id_cont'] ?? null;
?>

<div class="volver">
    <a href="javascript:cargar('#portada','/views/verfincas.php');"><button>Volver</button></a>
</div>

<div class="container_form">
    <h2 class="form-title"> Nueva finca </h2>

    <form action="/controllers/nfinca.php" method="POST" class="form">
        <div>
            <label for="localizacion">Localización:</label>
            <input placeholder="Localización" required="required" name="localizacion" type="text" id="localizacion">
        </div>
        <div>
            <label for="cultivo">Cultivo:</label>
            <input placeholder="Cultivo" required="required" name="cultivo" type="text" id="cultivo">
        </div>
        <div>
            <label for="hectarea">Tamaño en hectáreas:</label>
            <input placeholder="Héctareas" required="required" name="hectarea" type="text" id="hectarea">
        </div>
        <!-- Desplegable de contratistas -->
        <?php if ($tipo === 'admin'): ?>
            <!-- Mostrar selector de contratistas solo a administradores -->
            <div id="contratistaField">
                <label for="id_cont">Selecciona un contratista:</label>
                <select name="id_cont" id="id_cont">
                    <option value="">-- Seleccionar Contratista --</option>
                </select>
            </div>
        <?php else: ?>
            <!-- Para contratistas insertamos automáticamente su id -->
            <input type="hidden" name="id_cont" value="<?= $idCont ?>">
        <?php endif; ?>
        <input type="submit" value="Insertar" class="submit-btn">
    </form>
</div>
<script src="/assets/js/nueva_finca.js"></script>
