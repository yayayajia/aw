<?php
require_once __DIR__ . '/../dao/UsuarioDAO.php';
require_once __DIR__ . '/../model/Usuario.php';

class UsuarioSA {
    private $usuarioDAO;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function loginUsuario(string $userid, string $contrasena): bool {
        // Depuración adicional
        error_log("DEBUG: Intentando login para usuario: " . $userid);
        
        if ($this->usuarioDAO->existeUsuario($userid)) {
            $resultado = $this->usuarioDAO->comprobarContrasena($userid, $contrasena);
            error_log("DEBUG: Resultado de comprobación de contraseña: " . ($resultado ? "true" : "false"));
            return $resultado;
        }
        error_log("DEBUG: Usuario no encontrado");
        return false;
    }
}

?>