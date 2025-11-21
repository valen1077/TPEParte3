<?php
require './api/model/library.model.php'; 

    class LibreriaController {
        private $model;
        private $view;

        public function __construct() {
            $this->model = new LibreriaModel(); 
            $this->view = null;
        }


        public function getLibraries(){
            return $this->model->getLibraries(); 
        }

        public function showLibraries($res) {
            $librerias = $this->model->getLibraries(); 
            //$this->view->showLibraries($librerias,$res); 
        }

        public function addLibrary($res) {
            if(!empty($res)){
                if (!empty($_POST['nombre']) && !empty($_POST['direccion'])) {
                    $nombre = $_POST['nombre'];
                    $direccion = $_POST['direccion'];
                    $this->model->insertLibrary($nombre, $direccion);
                    header("Location: librerias"); 
                } 
            }else {
                //$this->view->showError("Error: Todos los campos son obligatorios.",$res); 
            }
        }

        public function showAddLibraryForm($res) {
            //$this->view->addLibrary($res); 
        }

        public function modifyLibrary($id,$res) {
            $libreria = $this->model->getLibrary($id); 
            if ($libreria) {
                //$this->view->modifyLibrary($libreria,$res); 
            } else {
            // $this->view->showError("Librería no encontrada.",$res);
            }
        }

        public function updateLibrary($res) {
            if (!empty($_POST['id_libreria']) && !empty($_POST['nombre']) && !empty($_POST['direccion'])) {
                $id = $_POST['id_libreria'];
                $nombre = $_POST['nombre'];
                $direccion = $_POST['direccion'];
                $this->model->updateLibrary($id, $nombre, $direccion); 
                header("Location: librerias"); 
            } else {
                //$this->view->showError("Error: Todos los campos son obligatorios.",$res); 
            }
        }

        public function deleteLibrary($id, $res) {
            if (!empty($id) && is_numeric($id)) { 
                if ($this->model->deleteLibrary($id)) {
                    header("Location: librerias"); 
                    exit(); 
                } else {
                    //$this->view->showError("Error al eliminar la librería. Puede que no exista o ya haya sido eliminada.",$res);
                }
            } else {
            //$this->view->showError("Libreria eliminada.", $res);
            }
        }

        public function getLibrary($id) {
            $libreria = $this->model->getLibrary($id); 
            return $libreria;
        }

        public function showBooksByLibrary($id_libreria, $res) {
            $libros = $this->model->getBooksByLibrary($id_libreria);
            $libreria = $this->model->getLibrary($id_libreria);
            if ($libros && $libreria) {
                //$this->view->showBooksByLibrary($libros, $libreria, $res); 
            } else {
                //$this->view->showError("No se encontraron libros para esta librería.", $res);
            }
        }
        
    }

?>