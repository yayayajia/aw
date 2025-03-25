<?php
namespace es\ucm\fdi\aw;

/**
 * Clase de servicio para la gestión de usuarios
 */
class UsuarioSA {
    private $usuarioDAO;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }

    /**
     * Verifica las credenciales de un usuario
     * 
     * @param string $userid Identificador del usuario
     * @param string $contrasena Contraseña del usuario
     * @return bool True si las credenciales son correctas, false en caso contrario
     */
    public function loginUsuario(string $userid, string $contrasena): bool {
        if ($this->usuarioDAO->existeUsuario($userid)) {
            return $this->usuarioDAO->comprobarContrasena($userid, $contrasena);
        }
        return false;
    }
    
    /**
     * Obtiene un usuario por su ID
     * 
     * @param string $userid Identificador del usuario
     * @return Usuario|null Usuario encontrado o null si no existe
     */
    public function obtenerUsuario(string $userid): ?Usuario {
        return $this->usuarioDAO->obtenerUsuario($userid);
    }
    
    /**
     * Registra un nuevo usuario
     * 
     * @param Usuario $usuario Datos del usuario a registrar
     * @return bool True si se registró correctamente, false en caso contrario
     */
    public function registrarUsuario(Usuario $usuario): bool {
        if ($this->usuarioDAO->existeUsuario($usuario->getUserid())) {
            return false;
        }
        return $this->usuarioDAO->agregarUsuario($usuario);
    }
}