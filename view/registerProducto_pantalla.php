<?php
require_once __DIR__.'/../includes/config.php';

session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['userid'])) {
    header("Location: login_pantalla.php?error=Debes iniciar sesión para registrar un producto.");
    exit;
}

$tituloPagina = 'Registro de Producto';


$contenidoPrincipal = <<<EOS
    <section class="presentacion">
        <h2 class="form-title">Registrar Nuevo Producto</h2>
        <form id="productForm" action="../includes/controller/registerProductoController.php" method="POST" class="form" enctype="multipart/form-data">
            <div class="form-group">
                <label for="id">ID Producto:</label>
                <input type="text" id="id" name="id" placeholder="Ej. PRD001" required class="form-control"><br>
            </div>

            <div class="form-group">
                <label for="nombre">Nombre del Producto:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ej. Teclado Logitech G Pro" required class="form-control"><br>
            </div>

            <div class="form-group">
                <label for="precio">Precio (€):</label>
                <input type="number" id="precio" name="precio" step="0.01" min="0" placeholder="Ej. 49.99" required class="form-control"><br>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" placeholder="Describe tu producto aquí..." required class="form-control"></textarea><br>
            </div>

            <div class="form-group">
                <label for="estado">Estado:</label>
                <select id="estado" name="estado" required class="form-control">
                    <option value="">Selecciona un estado</option>
                    <option value="Nuevo">Nuevo</option>
                    <option value="Como nuevo">Como nuevo</option>
                    <option value="Buen estado">Buen estado</option>
                    <option value="Aceptable">Aceptable</option>
                    <option value="Para piezas">Para piezas</option>
                </select><br>
            </div>

            <div class="form-group">
                <label for="imagen">Imagen del Producto:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" required class="form-control"><br>
            </div>

            <div id="message" class="message"></div>

            <input type="hidden" name="userid" value="{$_SESSION['userid']}" />
            <input type="hidden" name="action" value="register" />
            <button type="submit" class="btn">Registrar Producto</button>
        </form>
    </section>
    <script src="../JS/registerProductoJS.js"></script>
<?php
EOS;

require __DIR__.'/../includes/vistas/plantillas/plantilla.php';
?>