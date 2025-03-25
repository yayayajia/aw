<?php
require_once __DIR__.'/includes/config.php';

//Doble seguridad: unset + destroy
unset($_SESSION['login']);
unset($_SESSION['esAdmin']);
unset($_SESSION['nombre']);

session_destroy();

$tituloPagina = 'Logout';

header("Location: login_pantalla.php");

$contenidoPrincipal = <<<EOS
<h1>Hasta pronto!</h1>
EOS;

exit;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';

?>
