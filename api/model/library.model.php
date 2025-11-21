<?php
require_once './api/model/model.php';

class LibreriaModel extends Model {

    public function getLibraries() {
        $query = $this->db->prepare("SELECT * FROM libreria");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getLibrary($id) {
        $query = $this->db->prepare("SELECT * FROM libreria WHERE id_libreria = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function insertLibrary($nombre, $direccion) {
        $query = $this->db->prepare("INSERT INTO libreria (nombre, direccion) VALUES (?, ?)");
        $query->execute([$nombre, $direccion]);
    }
    
    public function updateLibrary($id, $nombre, $direccion) {
        $query = $this->db->prepare("UPDATE libreria SET nombre = ?, direccion = ? WHERE id_libreria = ?");
        $query->execute([$nombre, $direccion, $id]);
    }

    private function deleteBooksByLibrary($libraryId) {
        $query = $this->db->prepare("DELETE FROM libros WHERE id_libreria = ?");
        $query->execute([$libraryId]);
        return $query->rowCount();
    }

    public function deleteLibrary($id) {
        
        $this->deleteBooksByLibrary($id);
        
        $query = $this->db->prepare("DELETE FROM libreria WHERE id_libreria = ?");
        $query->execute([$id]);
        return $query->rowCount();
    }

    public function getBooksByLibrary($id_libreria) {
        $query = $this->db->prepare("SELECT * FROM libros WHERE id_libreria = ?");
        $query->execute([$id_libreria]);
        return $query->fetchAll(PDO::FETCH_OBJ); 
    }
}