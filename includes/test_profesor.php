<?php
// Guarda este archivo como test_profesor.php en la raíz de tu proyecto

// Parámetros exactos del profesor
$bdHost = 'localhost';
$bdUser = 'ejercicio3';
$bdPass = 'ejercicio3';
$bd = 'ejercicio3';

// Intento de conexión con mysqli (la forma que usa el profesor)
echo "Intentando conectar exactamente como en el ejemplo del profesor...<br>";
$conn = new mysqli($bdHost, $bdUser, $bdPass, $bd);

if ($conn->connect_errno) {
    echo "Error de conexión: ({$conn->connect_errno}) {$conn->connect_error}<br>";
    echo "Comprobando si el usuario existe...<br>";
    
    // Intentar con root para verificar la existencia del usuario
    $rootConn = new mysqli($bdHost, 'root', '', null);
    if (!$rootConn->connect_errno) {
        $result = $rootConn->query("SELECT User FROM mysql.user WHERE User = 'ejercicio3'");
        if ($result) {
            if ($result->num_rows > 0) {
                echo "✓ El usuario 'ejercicio3' existe en MySQL<br>";
            } else {
                echo "✗ El usuario 'ejercicio3' NO existe en MySQL<br>";
            }
            $result->free();
        }
        
        // Verificar si la base de datos existe
        $result = $rootConn->query("SHOW DATABASES LIKE 'ejercicio3'");
        if ($result) {
            if ($result->num_rows > 0) {
                echo "✓ La base de datos 'ejercicio3' existe<br>";
            } else {
                echo "✗ La base de datos 'ejercicio3' NO existe<br>";
            }
            $result->free();
        }
        
        $rootConn->close();
    }
} else {
    echo "¡Conexión exitosa con los parámetros del profesor!<br>";
    $conn->close();
}