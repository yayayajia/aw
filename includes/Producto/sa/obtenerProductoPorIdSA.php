<?php
namespace es\ucm\fdi\aw;

class obtenerProductoPorIdSA {
    private $productoDAO;

    public function __construct() {
        $this->productoDAO = new ProductoDAO();
    }

    public function obtenerProductoPorId(string $id): ?Producto {
        return $this->productoDAO->obtenerProductoPorId($id);
    }
    
}

?>
