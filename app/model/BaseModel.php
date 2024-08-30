<?php

class BaseModel {
    protected $db;

    public function __construct() {
        date_default_timezone_set('America/Lima');
        $host = 'localhost';
        $dbname = 'gestion';
        $username = 'root';
        $password = '';

        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            exit;
        }
    }
}

?>
