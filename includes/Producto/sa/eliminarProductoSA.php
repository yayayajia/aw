<?php
namespace es\ucm\fdi\aw;

class eliminarProductoSA {
    private $productoDAO;

    public function __construct() {
        $this->productoDAO = new ProductoDAO();
    }

    public function eliminarProducto(string $nombreProducto, string $idVendedor) {
        return $this->productoDAO->eliminarProducto($nombreProducto, $idVendedor);
    }
    
}

?>
