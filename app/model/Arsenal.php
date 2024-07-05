<?php

require_once 'BaseModel.php';

class Arsenal extends BaseModel {
    public function getBienes() {
        $stmt = $this->db->query("SELECT * FROM bienes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getConsumibles() {
        $stmt = $this->db->query("SELECT * FROM consumibles");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBienById($id) {
        $stmt = $this->db->prepare("SELECT * FROM bienes WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getConsumibleById($id) {
        $stmt = $this->db->prepare("SELECT * FROM consumibles WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createBien($nombre, $descripcion) {
        $stmt = $this->db->prepare("INSERT INTO bienes (nombre, descripcion) VALUES (:nombre, :descripcion)");
        return $stmt->execute(['nombre' => $nombre, 'descripcion' => $descripcion]);
    }

    public function createConsumible($nombre, $descripcion) {
        $stmt = $this->db->prepare("INSERT INTO consumibles (nombre, descripcion) VALUES (:nombre, :descripcion)");
        return $stmt->execute(['nombre' => $nombre, 'descripcion' => $descripcion]);
    }

    public function updateBien($id, $nombre, $descripcion) {
        $stmt = $this->db->prepare("UPDATE bienes SET nombre = :nombre, descripcion = :descripcion WHERE id = :id");
        return $stmt->execute(['id' => $id, 'nombre' => $nombre, 'descripcion' => $descripcion]);
    }

    public function updateConsumible($id, $nombre, $descripcion) {
        $stmt = $this->db->prepare("UPDATE consumibles SET nombre = :nombre, descripcion = :descripcion WHERE id = :id");
        return $stmt->execute(['id' => $id, 'nombre' => $nombre, 'descripcion' => $descripcion]);
    }

    public function deleteBien($id) {
        $stmt = $this->db->prepare("DELETE FROM bienes WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function deleteConsumible($id) {
        $stmt = $this->db->prepare("DELETE FROM consumibles WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
?>
