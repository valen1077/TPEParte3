<?php
    class Response{
        private $user;

        public function __construct(){
            $this->user = null;
        }
        
        public function getUser(){
            return $this->user;
        }

        public function setUser($user){
            $this->user = $user;
        }
    }