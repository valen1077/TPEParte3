<?php
    require_once './api/model/resenia.model.php';
    require_once './api/view/json.view.php';

    class ReseniaApiController{
        private $model;
        private $view;

        public function __construct(){
            $this->model = new ReseniaModel();
            $this->view = new JSONView();
        }

        public function getAll($request, $response){
            $orderBy = false;
            $id_libro = false;
            $criterio = false;
            $items = false;
            $pagina = false;

            if(isset($request->getQuery()->id_libro)){
                $id_libro = $request->getQuery()->id_libro;
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

            $reseñas = $this->model->getReseñas($id_libro, $orderBy, $criterio, $items, $pagina);

            return $this->view->response($reseñas);
        }

        public function get($request, $response){
            $id = $request->getParams()->id;
            $reseña = $this->model->getReseña($id);
            
            if($reseña){
                return $this->view->response($reseña);
            }
            return $this->view->response("La reseña con el id $id no existe", 404);
        }

        public function delete($request, $response){
            if($response->getUser()!=null){
                $id = $request->getParams()->id;
                $reseña = $this->model->getReseña($id);
                if($reseña){
                    $this->model->deleteReseña($id);
                    return $this->view->response("La reseña con el id $id se elimino con exito.");
                }
                return $this->view->response("La reseña con el id $id no existe", 404);
            }
            return $this->view->response("Fallo la authorization", 401);
        }

        public function create($request, $response){
            if($response->getUser()!=null){
                $idAnterior = $this->model->getLastId();//Para verificar si agrega...
                $newReseña = $request->getBody();
                if( empty($newReseña->nombre) || empty($newReseña->id_libro) ||
                    empty($newReseña->apellido) || empty($newReseña->comentario)
                    ){
                    return $this->view->response("Faltan completar datos", 400);
                }
                
                
                $nombre = $newReseña->nombre;
                $apellido = $newReseña->apellido;
                $comentario = $newReseña->comentario;
                $id_libro = $newReseña->id_libro;

                $book = $this->model->getBook($id_libro);
                if(!$book){
                    return $this->view->response("No existe el id $id_libro", 404);
                }

                $this->model->addReseña($nombre,$apellido,$comentario,$id_libro);

                $idActual = $this->model->getLastId();//Para verificar si agrego...
                if($idAnterior<$idActual){
                    $reseña = $this->model->getReseña($idActual);//Busco ña reseña insertada para retornarlo.
                    return $this->view->response($reseña, 201);
                }
                return $this->view->response("Ocurrio un problema al agregar la reseña de'$nombre $apellido'", 500);
            }
            return $this->view->response("Fallo la authorization", 401);
        }

        public function update($request, $response){
            if($response->getUser()!=null){
                $id = $request->getParams()->id;
                $reseña = $this->model->getReseña($id);
                
                if(!$reseña){
                    return $this->view->response("La reseña con el id $id no existe", 404);
                }
                $newReseña = $request->getBody();
                if( empty($newReseña->nombre) || empty($newReseña->id_libro) ||
                    empty($newReseña->apellido) || empty($newReseña->comentario)
                    ){
                    return $this->view->response("Faltan completar datos", 400);
                }
                
                
                $nombre = $newReseña->nombre;
                $apellido = $newReseña->apellido;
                $comentario = $newReseña->comentario;
                $id_libro = $newReseña->id_libro;

                $book = $this->model->getBook($id_libro);
                if(!$book){
                    return $this->view->response("No existe el id $id_libro", 404);
                }

                $this->model->setReseña($id,$nombre,$apellido,$comentario,$id_libro);

                $reseña = $this->model->getReseña($id);
                if(! $nombre == $reseña->nombre && 
                    $apellido == $reseña->apellido &&
                    $comentario == $reseña->comentario &&
                    $id_libro == $reseña->id_libro ){

                    return $this->view->response("Ocurrio un problema al modificar la reseña de'$nombre $apellido'", 500);
                }

                return $this->view->response($reseña, 200);
            }
            return $this->view->response("Fallo la authorization", 401);
        }

    }