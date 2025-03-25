<?php
namespace es\ucm\fdi\aw;

/**
 * Clase base para la conexión a la base de datos
 */
class DB {
    protected $db;

    public function __construct($dbname = 'database/database.db') {
        $rutaDB = __DIR__ . '/../' . $dbname;
        try {
            $this->db = new \PDO("sqlite:" . $rutaDB);
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Libera los recursos del statement
     */
    public function liberarRecursos($stmt) {
        if ($stmt) {
            $stmt->closeCursor();
        }
    }
}