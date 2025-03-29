<?php
// Guarda este archivo como test_aplicacion.php en la raíz de tu proyecto

require_once '../includes/config.php';

// Obtener la instancia de la aplicación
$app = Aplicacion::getInstance();

// Intentar obtener una conexión
try {
    $conn = $app->getConexionBd();
    if ($conn) {
        echo "La conexión a través de la clase Aplicacion funciona correctamente!<br>";
        
        // Probar una consulta simple
        $result = $conn->query("SELECT * FROM Usuarios LIMIT 1");
        if ($result) {
            echo "La consulta a la tabla Usuarios fue exitosa.<br>";
            $result->free();
        } else {
            echo "Error en la consulta: " . $conn->error . "<br>";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}