<?php
if (!function_exists('mostrarSaludo')) {
    function mostrarSaludo() {
        if (isset($_SESSION['login'])) {
            echo "<div class='saludo'>Bienvenido, ". $_SESSION['nombre'] .". <a href='".RUTA_VIEW."/logout_pantalla.php'>Cerrar sesión</a></div>";
        } else {
            echo "<div class='saludo'>Usuario desconocido. <a href='".RUTA_VIEW."/login_pantalla.php'>Login</a></div>";
        }
    }
}
?>

<header>
    <h1>MercaSwapp</h1>
    <p class="tagline">Tecnología Circular • Subastas Dinámicas • Trueque Inteligente</p>
    <img src="<?= RUTA_IMGS ?>/logo-mercaswapp.png" alt="Logo MercaSwapp" class="logo">
    <nav id="barUnderHeader">
    </nav>
</header>