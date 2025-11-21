<?php
    require_once './api/model/model.php';

    class ReseniaModel extends Model{
        
        public function getReseñas($id_libro = false, $orderBy = false, $criterio = false, $items = false, $pagina = false){
            $sql = 'SELECT * FROM `reseñas` ';
            if($id_libro){
                $sql .= ' WHERE `id_libro` = ?';
            }

            if($orderBy){
                switch ($orderBy) {
                    case 'id':
                        $sql .= ' ORDER BY `id`';
                        break;
                    case 'nombre':
                        $sql .= ' ORDER BY `nombre`';
                        break;
                    case 'apellido':
                    $sql .= ' ORDER BY `apellido`';
                        break;  
                    case 'comentario':
                        $sql .= ' ORDER BY `comentario`';
                        break;
                    case 'id_libro':
                        $sql .= ' ORDER BY `id_libro`';
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

            if($id_libro){
                $query ->execute([$id_libro]);
            }else{
                $query ->execute();
            }

            $reseñas = $query->fetchAll(PDO::FETCH_OBJ);
            return $reseñas;
        }

        public function getReseña($id){
            $query = $this->db->prepare("SELECT * FROM `reseñas` WHERE `id` = ?");
            $query ->execute([$id]);
            $reseña = $query->fetch(PDO::FETCH_OBJ);
            return $reseña;
        }

        public function deleteReseña($id){
            $query = $this->db->prepare("DELETE FROM `reseñas` WHERE `id` = ?");
            $query ->execute([$id]);
            return $query;
        }

        public function addReseña($nombre,$apellido,$comentario,$id_libro){
            $query = $this->db->prepare("INSERT INTO reseñas (nombre,apellido,comentario,id_libro) VALUES (?,?,?,?)");
            $query->execute([$nombre,$apellido,$comentario,$id_libro]);
            return $query;
        }

        public function setReseña($id,$nombre,$apellido,$comentario,$id_libro){
            $query = $this->db->prepare("UPDATE reseñas SET nombre = ?,apellido = ?,comentario = ?,id_libro = ? WHERE id = ?");
            $query->execute([$nombre,$apellido,$comentario,$id_libro, $id]);
            return $query;
        }

        public function getLastId(){
            $query = $this->db->prepare("SELECT * FROM `reseñas` ORDER BY id DESC LIMIT 1");
            $query ->execute();
            $reseña = $query->fetch(PDO::FETCH_OBJ);
            if($reseña){
                return $reseña->id;
            }
            return $reseña;
        }

        public function getBook($id){
            $query = $this->db->prepare("SELECT * FROM `libros` WHERE `id_libro` = ?");
            $query ->execute([$id]);
            $libro = $query->fetch(PDO::FETCH_OBJ);
            return $libro;
        }

    }