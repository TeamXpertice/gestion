<?php

class BaseModel {
    protected $db;

    public function __construct() {
        $host = 'localhost';
        $dbname = 'gestion';
        $username = 'root';
        $password = '';

        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error al conectar con la base de datos: " . $e->getMessage());
        }
    }
}
?>
