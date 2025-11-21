<?php
    class JSONView{
        public function response($body, $status = 200){
            header("Content-Type: Aplication/json");
            $statusText = $this->_requestStatus($status);
            header("HTTP/1.1 $status $statusText");
            echo json_encode($body,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            
        }

        private function _requestStatus($code){
            $status = array(
                200 => "Ok",
                201 => "Created",
                202 => "Acepted",
                204 => "No content",
                301 => "Moved permanently",
                302 => "Found",
                400 => "Bad request",
                401 => "Unauthorized",
                403 => "Forbidden",
                404 => "Not fund",
                410 => "Gone",
                500 => "Internal server error",
                503 => "Service Unavailable"
            );
            return (isset($status[$code])) ? $status[$code] : $status[500];
        }
    }