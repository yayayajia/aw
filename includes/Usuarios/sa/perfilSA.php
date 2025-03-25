<?php

namespace es\ucm\fdi\aw;

class PerfilSA {
    private $usuarioDAO;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function obtenerUsuarioPorId($idUsuario) {
        return $this->usuarioDAO->obtenerUsuario($idUsuario);
    }
}
?>
