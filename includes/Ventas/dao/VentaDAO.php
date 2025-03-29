<?php
// VentaDAO.php
require_once __DIR__ . '/../../database/Connection.php';
require_once __DIR__ . '/../model/Venta.php';
require_once __DIR__ . '/../../application.php';

class VentaDAO {
    private $db;

    public function __construct() {
        $this->db = application::getInstance()->getConexionBd();
    }

    public function registrarVenta(Venta $venta): bool {
        try {
            $sql = "INSERT INTO Ventas (producto_id, user_id, fechaVenta, comprador_id, precio) 
                    VALUES (:producto_id, :user_id, :fechaVenta, :comprador_id, :precio)";

            $stmt = $this->db->prepare($sql);

            // Asignar los valores a las variables
            $producto_id = $venta->getProductoId();
            $user_id = $venta->getUserId();
            $fechaVenta = $venta->getFechaVenta();
            $comprador_id = $venta->getCompradorId();
            $precio = $venta->getPrecio();

            // Pasar las variables a bindParam
            $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
            $stmt->bindParam(':fechaVenta', $fechaVenta, PDO::PARAM_STR);
            $stmt->bindParam(':comprador_id', $comprador_id, PDO::PARAM_STR);
            $stmt->bindParam(':precio', $precio, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al registrar la venta: " . $e->getMessage());
            return false;
        }
    }
    
    public function listarVentas(): array {
        try {
            $sql = "SELECT v.*, p.nombreProducto, u1.nombre as vendedor_nombre, u2.nombre as comprador_nombre
                    FROM Ventas v
                    JOIN Productos p ON v.producto_id = p.id
                    JOIN Usuarios u1 ON v.user_id = u1.userid
                    JOIN Usuarios u2 ON v.comprador_id = u2.userid
                    ORDER BY v.fechaVenta DESC";
            
            $stmt = $this->db->query($sql);
            $ventas = [];
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $ventas[] = [
                    'id' => $row['id'],
                    'producto_id' => $row['producto_id'],
                    'nombreProducto' => $row['nombreProducto'],
                    'user_id' => $row['user_id'],
                    'vendedor_nombre' => $row['vendedor_nombre'],
                    'fechaVenta' => $row['fechaVenta'],
                    'comprador_id' => $row['comprador_id'],
                    'comprador_nombre' => $row['comprador_nombre'],
                    'precio' => $row['precio']
                ];
            }
            
            return $ventas;
        } catch (PDOException $e) {
            error_log("Error al listar ventas: " . $e->getMessage());
            return [];
        }
    }
    
    public function obtenerVentasPorUsuario($userId): array {
        try {
            $sql = "SELECT v.*, p.nombreProducto 
                    FROM Ventas v
                    JOIN Productos p ON v.producto_id = p.id
                    WHERE v.user_id = :userId
                    ORDER BY v.fechaVenta DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
            $stmt->execute();
            
            $ventas = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $ventas[] = [
                    'id' => $row['id'],
                    'producto_id' => $row['producto_id'],
                    'nombreProducto' => $row['nombreProducto'],
                    'fechaVenta' => $row['fechaVenta'],
                    'comprador_id' => $row['comprador_id'],
                    'precio' => $row['precio']
                ];
            }
            
            return $ventas;
        } catch (PDOException $e) {
            error_log("Error al obtener ventas por usuario: " . $e->getMessage());
            return [];
        }
    }
    
    public function obtenerComprasPorUsuario($userId): array {
        try {
            $sql = "SELECT v.*, p.nombreProducto, u.nombre as vendedor_nombre
                    FROM Ventas v
                    JOIN Productos p ON v.producto_id = p.id
                    JOIN Usuarios u ON v.user_id = u.userid
                    WHERE v.comprador_id = :userId
                    ORDER BY v.fechaVenta DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
            $stmt->execute();
            
            $compras = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $compras[] = [
                    'id' => $row['id'],
                    'producto_id' => $row['producto_id'],
                    'nombreProducto' => $row['nombreProducto'],
                    'user_id' => $row['user_id'],
                    'vendedor_nombre' => $row['vendedor_nombre'],
                    'fechaVenta' => $row['fechaVenta'],
                    'precio' => $row['precio']
                ];
            }
            
            return $compras;
        } catch (PDOException $e) {
            error_log("Error al obtener compras por usuario: " . $e->getMessage());
            return [];
        }
    }
}