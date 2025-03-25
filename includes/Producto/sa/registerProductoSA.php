<?php
namespace es\ucm\fdi\aw;

class RegisterProductoSA {
    private $productoDAO;

    public function __construct() {
        $this->productoDAO = new ProductoDAO();
    }

    public function agregarProducto(Producto $producto): bool {
        return $this->productoDAO->agregarProducto($producto);
    }
    
}

?>
