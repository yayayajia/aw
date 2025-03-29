<?php

require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/../config.php';

/**
 * Formulario para registrar un nuevo producto.
 */
class FormularioProducto extends Formulario
{
    /**
     * Construye el formulario.
     */
    public function __construct()
    {
        parent::__construct('formProducto', ['urlRedireccion' => RUTA_APP . '/view/micatalogo_pantalla.php', 'enctype' => 'multipart/form-data']);
    }

    /**
     * Genera los campos del formulario.
     */
    protected function generaCamposFormulario(&$datos)
    {
        // Se reutilizan los datos si existen o se les da valor por defecto
        $nombreProducto = $datos['nombreProducto'] ?? '';
        $descripcionProducto = $datos['descripcionProducto'] ?? '';
        $precio = $datos['precio'] ?? '';
        $categoriaProducto = $datos['categoriaProducto'] ?? '';

        // Se generan los mensajes de error si existen
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores, 'errores-generales');
        $erroresCampos = self::generaErroresCampos(['nombreProducto', 'descripcionProducto', 'precio', 'categoriaProducto', 'imagenProducto'], $this->errores, 'span', ['class' => 'error']);

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error
        $html = <<<EOF
        <div class="form-group">
            <label for="nombreProducto">Nombre producto:</label>
            <input id="nombreProducto" type="text" name="nombreProducto" value="$nombreProducto" required class="form-control">
            {$erroresCampos['nombreProducto']}
        </div>
        <div class="form-group">
            <label for="descripcionProducto">Descripción producto:</label>
            <input id="descripcionProducto" type="text" name="descripcionProducto" value="$descripcionProducto" required class="form-control">
            {$erroresCampos['descripcionProducto']}
        </div>
        <div class="form-group">
            <label for="precio">Precio:</label>
            <input id="precio" type="number" step="0.01" name="precio" value="$precio" required class="form-control">
            {$erroresCampos['precio']}
        </div>
        <div class="form-group">
            <label for="categoriaProducto">Categoría del Producto:</label>
            <select id="categoriaProducto" name="categoriaProducto" required class="form-control">
                <option value="">Seleccione una categoría</option>
                <option value="computadora" $categoriaProducto == 'computadora' ? 'selected' : ''>Computadora</option>
                <option value="auriculares" $categoriaProducto == 'auriculares' ? 'selected' : ''>Auriculares</option>
                <option value="juegos" $categoriaProducto == 'juegos' ? 'selected' : ''>Juegos</option>
                <option value="ratón" $categoriaProducto == 'ratón' ? 'selected' : ''>Ratón</option>
                <option value="teclado" $categoriaProducto == 'teclado' ? 'selected' : ''>Teclado</option>
                <option value="pantalla" $categoriaProducto == 'pantalla' ? 'selected' : ''>Pantalla</option>
                <option value="impresora" $categoriaProducto == 'impresora' ? 'selected' : ''>Impresora</option>
                <option value="altavoces" $categoriaProducto == 'altavoces' ? 'selected' : ''>Altavoces</option>
            </select>
            {$erroresCampos['categoriaProducto']}
        </div>
        <div class="form-group">
            <label for="imagenProducto">Imagen del Producto:</label>
            <input id="imagenProducto" type="file" name="imagenProducto" required class="form-control">
            {$erroresCampos['imagenProducto']}
        </div>
        $htmlErroresGlobales
        <div class="form-group">
            <button type="submit" class="btn">Registrar producto</button>
        </div>
        EOF;
        return $html;
    }

    /**
     * Procesa los datos del formulario.
     */
    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        // Verificar si el usuario ha iniciado sesión
        if (!isset($_SESSION['userid'])) {
            $this->errores[] = "Debes iniciar sesión para registrar un producto.";
            return;
        }

        // Validación del nombre del producto
        $nombreProducto = trim($datos['nombreProducto'] ?? '');
        $nombreProducto = filter_var($nombreProducto, FILTER_SANITIZE_SPECIAL_CHARS);
        if (!$nombreProducto || empty($nombreProducto)) {
            $this->errores['nombreProducto'] = 'El nombre del producto no puede estar vacío';
        }

        // Validación de la descripción del producto
        $descripcionProducto = trim($datos['descripcionProducto'] ?? '');
        $descripcionProducto = filter_var($descripcionProducto, FILTER_SANITIZE_SPECIAL_CHARS);
        if (!$descripcionProducto || empty($descripcionProducto)) {
            $this->errores['descripcionProducto'] = 'La descripción del producto no puede estar vacía';
        }

        // Validación del precio
        $precio = trim($datos['precio'] ?? '');
        $precio = filter_var($precio, FILTER_VALIDATE_FLOAT);
        if (!$precio || $precio <= 0) {
            $this->errores['precio'] = 'El precio debe ser un número positivo';
        }

        // Validación de la categoría
        $categoriaProducto = trim($datos['categoriaProducto'] ?? '');
        $categoriaProducto = filter_var($categoriaProducto, FILTER_SANITIZE_SPECIAL_CHARS);
        if (!$categoriaProducto || empty($categoriaProducto)) {
            $this->errores['categoriaProducto'] = 'Debes seleccionar una categoría';
        }

        // Validación de la imagen
        if (!isset($_FILES['imagenProducto']) || $_FILES['imagenProducto']['error'] !== UPLOAD_ERR_OK) {
            $this->errores['imagenProducto'] = 'Debes seleccionar una imagen para el producto';
        } else {
            // Procesar la imagen
            $extension = pathinfo($_FILES['imagenProducto']['name'], PATHINFO_EXTENSION);
            $nombreArchivo = bin2hex(random_bytes(8)) . '.' . $extension;
            $directorioDestino = __DIR__ . '/../../fotos/';
            $rutaArchivo = $directorioDestino . $nombreArchivo;
            $rutaImagen = '/fotos/' . $nombreArchivo;

            // Crear el directorio si no existe
            if (!is_dir($directorioDestino)) {
                if (!mkdir($directorioDestino, 0777, true)) {
                    $this->errores['imagenProducto'] = 'Error al crear el directorio para guardar la imagen';
                    return;
                }
            }

            // Mover el archivo subido al directorio de destino
            if (!move_uploaded_file($_FILES['imagenProducto']['tmp_name'], $rutaArchivo)) {
                $this->errores['imagenProducto'] = 'Error al subir la imagen';
                return;
            }
        }

        if (count($this->errores) === 0) {
            require_once __DIR__ . '/../Producto/dao/ProductoDAO.php';
            require_once __DIR__ . '/../Producto/model/Producto.php';
            require_once __DIR__ . '/../Producto/sa/registerProductoSA.php';
            
            $producto = new Producto(
                $nombreProducto,
                $descripcionProducto,
                $precio,
                $categoriaProducto,
                $_SESSION['userid'],
                $rutaImagen
            );
            
            $productoSA = new RegisterProductoSA();
            
            if (!$productoSA->agregarProducto($producto)) {
                $this->errores[] = "Error al registrar el producto";
            }
        }
    }
}