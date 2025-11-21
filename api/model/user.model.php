<?php
    require_once './api/model/model.php';

    class UserModel extends Model{

        public function gerUserByMail($mail){
            $query = $this->db->prepare("SELECT * FROM `user` WHERE `mail` = ?");
            $query ->execute([$mail]);
            $user = $query->fetch(PDO::FETCH_OBJ);
            return $user;
        }
    }