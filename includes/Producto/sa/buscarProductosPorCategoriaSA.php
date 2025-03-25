<?php
namespace es\ucm\fdi\aw;

class buscarProductosPorCategoriaSA {
    private $productoDAO;

    public function __construct() {
        $this->productoDAO = new ProductoDAO();
    }

    public function buscarProductosPorCategoria(string $categoria): array{
        return $this->productoDAO->buscarProductosPorCategoria($categoria);
    }
    
}

?>