<?php
    require_once './api/model/libro.model.php';
    require_once './api/view/json.view.php';
    require_once './api/controller/library.controller.php';
    class LibroApiController{
        private $model;
        private $view;
        private $controllerLibreria;

        public function __construct(){
            $this->model = new LibroModel();
            $this->view = new JSONView();
            $this->controllerLibreria = new LibreriaController();
        }

        public function getAll($request, $response){
            $orderBy = false;
            $id_libreria = false;
            $criterio = false;
            $items = false;
            $pagina = false;

            if(isset($request->getQuery()->id_libreria)){
                $id_libreria = $request->getQuery()->id_libreria;
            }

            if(isset($request->getQuery()->orderBy)){
                $orderBy = $request->getQuery()->orderBy;
            }
            
            if(isset($request->getQuery()->criterio)){
                $criterio = $request->getQuery()->criterio;
            }

            if(isset($request->getQuery()->pagina)){
                if(is_numeric($request->getQuery()->pagina)){
                    $pagina = $request->getQuery()->pagina;
                }
            }

            if(isset($request->getQuery()->items)){
                if(is_numeric($request->getQuery()->items)){
                    $items = $request->getQuery()->items;
                }
            }

            $books = $this->model->getBooks($id_libreria, $orderBy, $criterio, $items, $pagina);

            return $this->view->response($books);
        }

        public function get($request, $response){
            $id = $request->getParams()->id;
            $book = $this->model->getBook($id);
            
            if($book){
                return $this->view->response($book);
            }
            return $this->view->response("El libro con el id $id no existe", 404);
        }

        public function delete($request, $response){
            if($response->getUser()!=null){
                $id = $request->getParams()->id;
                $reseña = $this->model->getBook($id);
                if($reseña){
                    $this->model->deleteBook($id);
                    return $this->view->response("El libro con el id $id se elimino con exito.");
                }
                return $this->view->response("El libro con el id $id no existe", 404);
            }
            return $this->view->response("Fallo la authorization", 401);
        }

        public function create($request, $response){
            if($response->getUser()!=null){
                $idAnterior = $this->model->getLastId();//Para verificar si agrega...
                $newBook = $request->getBody();
                if( empty($newBook->nombre_libro) || empty($newBook->id_libreria) ||
                    empty($newBook->genero) || empty($newBook->editorial)
                    ){
                    return $this->view->response("Faltan completar datos", 400);
                }
                
                
                $nombre = $newBook->nombre_libro;
                $genero = $newBook->genero;
                $editorial = $newBook->editorial;
                $id_libreria = $newBook->id_libreria;

                $libreria = $this->controllerLibreria->getLibrary($id_libreria);
                if(!$libreria){
                    return $this->view->response("No existe el id $id_libreria", 404);
                }

                $this->model->addBook($nombre,$genero,$editorial,$id_libreria);

                $idActual = $this->model->getLastId();//Para verificar si agrego...
                if($idAnterior<$idActual){
                    $book = $this->model->getBook($idActual);//Busco el libro insertado para retornarlo.
                    return $this->view->response($book, 201);
                }
                return $this->view->response("Ocurrio un problema al agregar el libro '$nombre'", 500);
            }
            return $this->view->response("Fallo la authorization", 401);
        }

        public function update($request, $response){
            if($response->getUser()!=null){
                $id = $request->getParams()->id;
                $book = $this->model->getBook($id);
                
                if(!$book){
                    return $this->view->response("El libro con el id $id no existe", 404);
                }
                $newBook = $request->getBody();
                if( empty($newBook->nombre_libro) || empty($newBook->id_libreria) ||
                    empty($newBook->genero) || empty($newBook->editorial)
                ){
                    return $this->view->response("Faltan completar datos", 400);
                }
                
                
                $nombre = $newBook->nombre_libro;
                $genero = $newBook->genero;
                $editorial = $newBook->editorial;
                $id_libreria = $newBook->id_libreria;

                $libreria = $this->controllerLibreria->getLibrary($id_libreria);
                if(!$libreria){
                    return $this->view->response("No existe el id $id_libreria", 404);
                }

                $this->model->setBook($id,$nombre,$genero,$editorial,$id_libreria);

                $book = $this->model->getBook($id);
                if(! $nombre == $book->nombre_libro && 
                    $genero == $book->genero &&
                    $editorial == $book->editorial &&
                    $id_libreria == $book->id_libreria ){

                    return $this->view->response("Ocurrio un problema al modificar el libro '$nombre'", 500);
                }

                return $this->view->response($book, 200);
            }
            return $this->view->response("Fallo la authorization", 401);
        }
    }
?>