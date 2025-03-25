<?php
require_once __DIR__.'/../includes/config.php';

$tituloPagina = 'Login';

// Definir el contenido principal que se mostrará en la plantilla
$contenidoPrincipal = <<<EOS
    <section class="presentacion">
        <h2>Iniciar Sesión en MercaSwapp</h2>
        <form id="loginForm" action="../includes/controller/loginUsuarioController.php" method="POST" class="form">
            <div class="form-group">
                <label for="userid">Usuario:</label>
                <input type="text" id="userid" name="userid" required class="form-control"><br>
            </div>

            <div class="form-group">
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required class="form-control"><br>
            </div>

            <div id="message" class="message"></div>

            <input type="hidden" name="action" value="login">
            <button type="submit" class="btn">Iniciar Sesión</button>
        </form>

        <p>¿No tienes cuenta? <a href="register_pantalla.php">Regístrate aquí</a></p>

        <script src="../JS/loginJS.js"></script>
    </section>
EOS;

// Si hay un error, mostrarlo en la pantalla
if (isset($_GET['error'])) {
    $contenidoPrincipal .= "<p style='color:red;'>⚠️ " . htmlspecialchars($_GET['error']) . "</p>";
}

// Incluir la plantilla para que se muestre correctamente
require __DIR__.'/../includes/vistas/plantillas/plantilla.php';
?>
