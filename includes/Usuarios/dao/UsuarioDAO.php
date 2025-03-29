<?php
require_once __DIR__ . '/../../database/Connection.php';
require_once __DIR__ . '/../model/Usuario.php';
require_once __DIR__ . '/../../Aplicacion.php';

class UsuarioDAO {
    private $db;

    public function __construct() {
        $this->db = Aplicacion::getInstance()->getConexionBd();
    }

    public function listarUsuarios(): array {
        try {
            $sql = "SELECT * FROM Usuarios";
            $result = $this->db->query($sql);

            $usuarios = [];
            while ($row = $result->fetch_assoc()) {
                $usuarios[] = new Usuario(
                    $row['userid'],
                    $row['contrasena'],
                    $row['email'],
                    $row['nombre'],
                    $row['apellidos'],
                    (int)$row['edad'],
                    $row['rol']
                );
            }
            return $usuarios;
        } catch (Exception $e) {
            error_log("Error al listar usuarios: " . $e->getMessage());
            return [];
        }
    }

    public function existeUsuario(string $userid): bool {
        try {
            $sql = "SELECT COUNT(*) as count FROM Usuarios WHERE userid = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param('s', $userid);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            return ($row && $row['count'] > 0);
        } catch (Exception $e) {
            error_log("Error al verificar existencia de usuario: " . $e->getMessage());
            return false;
        }
    }

    public function agregarUsuario(Usuario $usuario): bool {
        try {
            $sql = "INSERT INTO Usuarios (userid, contrasena, email, nombre, apellidos, edad, rol) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->db->prepare($sql);
            $userid = $usuario->getUserid();
            $password = password_hash($usuario->getContrasena(), PASSWORD_BCRYPT);
            $email = $usuario->getEmail();
            $nombre = $usuario->getNombre();
            $apellidos = $usuario->getApellidos();
            $edad = (int)$usuario->getEdad();
            $rol = $usuario->getRol();
            
            $stmt->bind_param('sssssss', $userid, $password, $email, $nombre, $apellidos, $edad, $rol);
            
            $result = $stmt->execute();
            if (!$result) {
                error_log("Error al ejecutar la consulta: " . $stmt->error);
            }
            return $result;
        } catch (Exception $e) {
            error_log("Error al agregar usuario: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerUsuario(string $userid): ?Usuario {
        try {
            $sql = "SELECT * FROM Usuarios WHERE userid = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param('s', $userid);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row) {
                return new Usuario(
                    $row['userid'],
                    $row['contrasena'],
                    $row['email'],
                    $row['nombre'],
                    $row['apellidos'],
                    (int)$row['edad'],
                    $row['rol']
                );
            }
            return null;
        } catch (Exception $e) {
            error_log("Error al obtener usuario: " . $e->getMessage());
            return null;
        }
    }

    public function comprobarContrasena(string $userid, string $contrasena): bool {
        try {
            error_log("DEBUG: Comprobando contraseña para: " . $userid);
            
            $sql = "SELECT contrasena FROM Usuarios WHERE userid = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param('s', $userid);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            error_log("DEBUG: Hash almacenado: " . ($row ? $row['contrasena'] : 'No encontrado'));
            
            if ($row) {
                $verificado = password_verify($contrasena, $row['contrasena']);
                error_log("DEBUG: Resultado de password_verify: " . ($verificado ? 'true' : 'false'));
                return $verificado;
            }
            
            error_log("DEBUG: No se encontró el usuario");
            return false;
        } catch (Exception $e) {
            error_log("ERROR en comprobarContrasena: " . $e->getMessage());
            return false;
        }
    }
}
?>