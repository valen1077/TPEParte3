<?php
    require_once './api/model/model.php';

    class LibroModel extends Model{
        
        public function getBooks($id_libreria = false, $orderBy = false, $criterio = false, $items = false, $pagina = false){
            $sql = 'SELECT * FROM `libros` ';
            if($id_libreria){
                $sql .= ' WHERE `id_libreria` = ?';
            }

            if($orderBy){
                switch ($orderBy) {
                    case 'id_libro':
                        $sql .= ' ORDER BY `id_libro`';
                        break;
                    case 'nombre_libro':
                        $sql .= ' ORDER BY `nombre_libro`';
                        break;
                    case 'genero':
                    $sql .= ' ORDER BY `genero`';
                        break;  
                    case 'editorial':
                        $sql .= ' ORDER BY `editorial`';
                        break;
                    case 'id_libreria':
                        $sql .= ' ORDER BY `id_libreria`';
                        break;       
                    default:
                        break;
                }
            }

            if($orderBy){
                if($criterio == "DESC"){
                    $sql.= ' DESC';
                }
            }
            
            if($items && $pagina){
                if($items > 0 && $pagina > 0){
                    $items = (int)$items;
                    $pagina = (int)($pagina - 1) * $items;
                    $sql.= " LIMIT $pagina,$items";
                }
            }

            
            $query = $this->db->prepare($sql);

            if($id_libreria){
                $query ->execute([$id_libreria]);
            }else{
                $query ->execute();
            }

            $libros = $query->fetchAll(PDO::FETCH_OBJ);
            return $libros;
        }

        public function getBook($id){
            $query = $this->db->prepare("SELECT * FROM `libros` WHERE `id_libro` = ?");
            $query ->execute([$id]);
            $libro = $query->fetch(PDO::FETCH_OBJ);
            return $libro;
        }

        /* public function deleteBook($id){
            $query = $this->db->prepare("DELETE FROM `libros` WHERE `id_libro` = ?");
            $query ->execute([$id]);
            return $query;
        } */

        public function addBook($nombre,$genero,$editorial,$id_libreria){
            $query = $this->db->prepare("INSERT INTO libros (nombre_libro,genero,editorial,id_libreria) VALUES (?,?,?,?)");
            $query->execute([$nombre,$genero,$editorial,$id_libreria]);
            return $query;
        }

        public function setBook($id,$nombre,$genero,$editorial,$id_libreria){
            $query = $this->db->prepare("UPDATE libros SET nombre_libro = ?,genero = ?,editorial = ?,id_libreria = ? WHERE id_libro = ?");
            $query->execute([$nombre,$genero,$editorial,$id_libreria, $id]);
            return $query;
        }

        public function getBookByLibrary($id){
            $query = $this->db->prepare("SELECT * FROM `libros` WHERE `id_libreria` = ?");
            $query ->execute([$id]);
            $libros = $query->fetchAll(PDO::FETCH_OBJ);
            return $libros;
        }

        public function getLastId(){
            $query = $this->db->prepare("SELECT * FROM `libros` ORDER BY id_libro DESC LIMIT 1");
            $query ->execute();
            $libro = $query->fetch(PDO::FETCH_OBJ);
            return $libro->id_libro;
        }

        public function deleteBook($id) {
            $this->deleteReseñasByLibro($id);
            
            $query = $this->db->prepare("DELETE FROM libros WHERE id_libro = ?");
            $query->execute([$id]);
            return $query->rowCount();
        }

        public function deleteReseñasByLibro($libroId) {
            $query = $this->db->prepare("DELETE FROM reseñas WHERE id_libro = ?");
            $query->execute([$libroId]);
            return $query->rowCount();
        }

    }