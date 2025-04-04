<?php
session_start();
if (isset($_SESSION['usuario'])) {
    $datosdeusuario = @unserialize($_SESSION['usuario']); 

    if ($datosdeusuario === false || !is_array($datosdeusuario)) {
        echo "Error: Sesión no válida.";
        var_dump($_SESSION['usuario']);
        exit; 
    }

    if (isset($datosdeusuario['nombre'])) {
        $nombre = $datosdeusuario['nombre'];
    } else {
        $nombre = "Usuario desconocido";
    }
} else {
    $nombre = "Sesión no iniciada";
}
?>
<div id="menuHamburguesa">&#9776</div>
<nav id="nav" role="navigation">
    <div class="container_nav">      
                <?php   
                echo '<div class="container-selector">';        
                    echo '<a href="javascript:cargar(\'#portada\',\'/views/verusuarios.php\');" id="soporteLink">Usuarios</a>';
                    echo '</div>'; 

                    echo '<div class="container-selector">';        
                    echo '<a href="javascript:cargar(\'#portada\',\'/views/vercontratistas.php\');" id="soporteLink">Contratistas</a>';
                    echo '</div>'; 

                    echo '<div class="container-selector">';        
                    echo '<a href="javascript:cargar(\'#portada\',\'/views/verfincas.php\');" id="soporteLink">Fincas</a>';
                    echo '</div>';

                    echo '<div class="container-selector">';        
                    echo '<a href="javascript:cargar(\'#portada\',\'/views/verproyectos.php\');" id="soporteLink">Campañas</a>';
                    echo '</div>'; 

                    echo '<div class="container-selector">';        
                    echo '<a href="javascript:cargar(\'#portada\',\'/views/verproveedores.php\');" id="soporteLink">Proveedores</a>';
                    echo '</div>'; 
                    echo '<div class="container-selector">';        
                    echo '<a href="javascript:cargar(\'#portada\',\'/views/vertrabajadores.php\');" id="soporteLink">Trabajadores</a>';
                    echo '</div>';                                 
                ?>
    </div>
    <div class="usuario">
        <span id="nom"><?php echo $nombre; ?></span>
        <div class="loging">
            <a href="/app/logout">
                <i class="fa-solid fa-right-from-bracket usuario"></i> Salir
            </a>
        </div>
    </div>
</nav>