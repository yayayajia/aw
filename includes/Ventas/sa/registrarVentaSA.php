<?php
namespace es\ucm\fdi\aw;

class RegistroSA {
    private $ventaDAO;

    public function __construct() {
        $this->ventaDAO = new UsuarioDAO();
    }

    public function registrarUsuario(Venta $venta): bool {
        return $this->ventaDAO->agregarUsuario($venta);
    }
    
}

?>
