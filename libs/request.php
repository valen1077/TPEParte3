<?php

    class Request{
        private $body = null; #{'Nombre' : 'Camilo', 'Descripcion' : 'Almacenero'}
        private $params = null; # /api/libros/4
        private $query = null; # ?id_libreria=14

        public function __construct(){
            try {
                # file_get_contents('php://input') Lee el body de la request
                $this->body = json_decode(file_get_contents('php://input'));
            } catch (Exception $e) {
                $this->body = null;
            }
            $this->query = (object) $_GET;
        }

        public function setParams($params){
            $this->params = $params;
        }

        public function getParams(){
            return $this->params;
        }

        public function getQuery(){
            return $this->query;
        }

        public function getBody(){
            return $this->body;
        }
    }