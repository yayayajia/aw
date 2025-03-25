<?php
namespace es\ucm\fdi\aw;

/**
 * Clase DAO para operaciones con usuarios en la base de datos
 */
class UsuarioDAO extends DB {

    public function listarUsuarios(): array {
        $usuarios = [];
        try {
            $sql = "SELECT * FROM Usuarios";
            $stmt = $this->db->query($sql);

            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
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
            // Liberar recursos
            $this->liberarRecursos($stmt);
        } catch (\PDOException $e) {
            error_log("Error al listar usuarios: " . $e->getMessage());
        }
        return $usuarios;
    }

    public function existeUsuario(string $userid): bool {
        try {
            $sql = "SELECT COUNT(*) as count FROM Usuarios WHERE userid = :userid";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':userid', $userid, \PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            // Liberar recursos
            $this->liberarRecursos($stmt);
            
            return ($result && $result['count'] > 0);
        } catch (\PDOException $e) {
            error_log("Error al verificar existencia de usuario: " . $e->getMessage());
            return false;
        }
    }

    public function agregarUsuario(Usuario $usuario): bool {
        try {
            $sql = "INSERT INTO Usuarios (userid, contrasena, email, nombre, apellidos, edad, rol) 
                    VALUES (:userid, :contrasena, :email, :nombre, :apellidos, :edad, :rol)";
            
            $stmt = $this->db->prepare($sql);
            $hashedPassword = password_hash($usuario->getContrasena(), PASSWORD_BCRYPT);
            
            $stmt->bindValue(':userid', $usuario->getUserid(), \PDO::PARAM_STR);
            $stmt->bindValue(':contrasena', $hashedPassword, \PDO::PARAM_STR);
            $stmt->bindValue(':email', $usuario->getEmail(), \PDO::PARAM_STR);
            $stmt->bindValue(':nombre', $usuario->getNombre(), \PDO::PARAM_STR);
            $stmt->bindValue(':apellidos', $usuario->getApellidos(), \PDO::PARAM_STR);
            $stmt->bindValue(':edad', (int)$usuario->getEdad(), \PDO::PARAM_INT);
            $stmt->bindValue(':rol', $usuario->getRol(), \PDO::PARAM_STR);

            $result = $stmt->execute();
            
            // Liberar recursos
            $this->liberarRecursos($stmt);
            
            if (!$result) {
                error_log("Error al ejecutar la consulta: " . implode(", ", $stmt->errorInfo()));
            }
            return $result;
        } catch (\PDOException $e) {
            error_log("Error al agregar usuario: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerUsuario(string $userid): ?Usuario {
        try {
            $sql = "SELECT * FROM Usuarios WHERE userid = :userid";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':userid', $userid, \PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            // Liberar recursos
            $this->liberarRecursos($stmt);
            
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
        } catch (\PDOException $e) {
            error_log("Error al obtener usuario: " . $e->getMessage());
            return null;
        }
    }

    public function comprobarContrasena(string $userid, string $contrasena): bool {
        try {
            $sql = "SELECT contrasena FROM Usuarios WHERE userid = :userid";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':userid', $userid, \PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            // Liberar recursos
            $this->liberarRecursos($stmt);
            
            if ($row && password_verify($contrasena, $row['contrasena'])) {
                return true;
            }
            return false;
        } catch (\PDOException $e) {
            error_log("Error al comprobar contraseña: " . $e->getMessage());
            return false;
        }
    }
}