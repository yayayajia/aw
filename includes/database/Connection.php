<?php
class DB {
    public $db;

    public function __construct() {
        try {
            // Parámetros de conexión
            $host = BD_HOST;
            $dbname = BD_NAME;
            $username = BD_USER;
            $password = BD_PASS;

            // Crear conexión con MySQL
            $this->db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            
            // Configurar el modo de error para PDO
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function getBD(){
        return $this->db;
    }
}
?>