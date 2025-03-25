<?php
namespace es\ucm\fdi\aw;

class RegistroSA {
    private $usuarioDAO;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function registrarUsuario(Usuario $usuario): bool {
        if ($this->usuarioDAO->existeUsuario($usuario->getUserid())) {
            return false; 
        }
        return $this->usuarioDAO->agregarUsuario($usuario);
    }
    
}

?>
