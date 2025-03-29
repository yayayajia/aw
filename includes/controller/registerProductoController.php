<?php
session_start();
require_once __DIR__ . '/../Producto/sa/registerProductoSA.php';
require_once __DIR__ . '/../Producto/model/Producto.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreProducto = htmlspecialchars($_POST['nombreProducto'], ENT_QUOTES, 'UTF-8');
    $descripcionProducto = htmlspecialchars($_POST['descripcionProducto'], ENT_QUOTES, 'UTF-8');
    $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
    $categoriaProducto = htmlspecialchars($_POST['categoriaProducto'], ENT_QUOTES, 'UTF-8');

    if (!$nombreProducto || !$descripcionProducto || !$precio || !$categoriaProducto) {
        http_response_code(400); 
        echo "Error: Datos inválidos.";
        exit;
    }

    if (isset($_FILES['imagenProducto']) && $_FILES['imagenProducto']['error'] === UPLOAD_ERR_OK) {
        $extension = pathinfo($_FILES['imagenProducto']['name'], PATHINFO_EXTENSION);
        $nombreArchivo = bin2hex(random_bytes(8)) . '.' . $extension;
        $directorioDestino = __DIR__ . '/../../fotos/';
        $rutaArchivo = $directorioDestino . $nombreArchivo;
    
        // Crear el directorio si no existe
        if (!is_dir($directorioDestino)) {
            mkdir($directorioDestino, 0777, true);
        }
    
        // Mover el archivo subido al directorio de destino
        if (move_uploaded_file($_FILES['imagenProducto']['tmp_name'], $rutaArchivo)) {
            $rutaImagen = '/fotos/' . $nombreArchivo;
            echo "Imagen guardada en: " . $rutaImagen;
        } else {
            http_response_code(500);
            echo "Error al subir la imagen.";
            exit;
        }
    } else {
        http_response_code(400);
        echo "Error: Imagen no válida.";
        exit;
    }
    

    $producto = new Producto($nombreProducto, $descripcionProducto, $precio, $categoriaProducto, $_SESSION['userid'], $rutaImagen);
    
    $productoSA = new registerProductoSA();

    try {
        if ($productoSA->agregarProducto($producto)) {
            http_response_code(201); 
            echo "Producto registrado con éxito.";
        } else {
            http_response_code(409); 
            echo "El producto no se ha podido registrar";
        }
    } catch (Exception $e) {
        http_response_code(500); 
        echo "Error al registrar el producto: " . $e->getMessage();
    }
    exit;
}
?>