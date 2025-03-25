<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Plataforma innovadora para compraventa sostenible de tecnología de segunda mano">
    <title>MercaSwapp - <?= $tituloPagina ?? 'Tecnología Sostenible' ?></title>
    <link id="estilo" rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/estilos.css" />
    <link rel="stylesheet" media="print" href="<?= RUTA_CSS ?>/estilos.css" />
</head>

<body>
    <div id="contenedor">
        <?php
            require(RAIZ_APP.'/vistas/comun/cabecera.php');
            require(RAIZ_APP.'/vistas/comun/barUnderHeader.php');
        ?>
        
        <?php
        // Mostrar mensajes de atributos de petición si existen
        $app = es\ucm\fdi\aw\Aplicacion::getInstance();
        $mensaje = $app->getAtributoPeticion('mensaje');
        $mensaje2 = $app->getAtributoPeticion('mensaje2');
        
        if (isset($mensaje) || isset($mensaje2)) {
            echo '<div class="mensajes">';
            if (isset($mensaje)) {
                echo '<p class="mensaje">'.$mensaje.'</p>';
            }
            if (isset($mensaje2)) {
                echo '<p class="mensaje">'.$mensaje2.'</p>';
            }
            echo '</div>';
        }
        ?>

        <main>
            <article>
                <?= $contenidoPrincipal ?? "Contenido no disponible." ?>
            </article>
        </main>

        <?php
            require(RAIZ_APP.'/vistas/comun/pie.php');
        ?>
    </div>
</body>
</html>