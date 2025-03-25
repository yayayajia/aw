<?php
namespace es\ucm\fdi\aw;

class listarProductosSA {
    private $productoDAO;

    public function __construct() {
        $this->productoDAO = new ProductoDAO();
    }

    public function listarProductos(): array {
        return $this->productoDAO->listarProductos();
    }

    public function listarProductosUser(): array {
        return $this->productoDAO->listarMisProductos();
    }
}
?>