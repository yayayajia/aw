<?php
require_once __DIR__.'/../includes/config.php';

$tituloPagina = 'Subastas';

$contenidoPrincipal = <<<EOS
    <section class="presentacion">
        <h2>Subastas</h2>
        <p>¡Próximamente! Estamos trabajando en un emocionante sistema de subastas para MercaSwapp.</p>
        <div class="destacado">
            <p>Características en desarrollo:</p>
            <ul>
                <li>Subastas en tiempo real</li>
                <li>Sistema de pujas automáticas</li>
                <li>Notificaciones instantáneas</li>
            </ul>
        </div>
    </section>
EOS;

require __DIR__.'/../includes/vistas/plantillas/plantilla.php';
?>