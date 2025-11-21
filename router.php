<?php
        require_once './libs/router.php';
        require_once './api/controller/resenia.api.controller.php';
        require_once './api/controller/libro.api.controller.php';
        require_once './api/controller/auth.api.controller.php';
        require_once './api/middlewares/jwt.auth.middleware.php';
        
        $router = new Router();
        $router->addMiddleware(new JWTAuthMiddleware());

        #                 endpoint      verbo           controller              metodo
        $router->addRoute('user/token', 'GET',          'AuthApiController',    'getToken');
        $router->addRoute('libros',     'GET',          'LibroApiController',   'getAll');
        $router->addRoute('libros/:id', 'GET',          'LibroApiController',   'get');
        $router->addRoute('libros/:id', 'DELETE',       'LibroApiController',   'delete');
        $router->addRoute('libros',     'POST',         'LibroApiController',   'create');
        $router->addRoute('libros/:id', 'PUT',          'LibroApiController',   'update');

        $router->addRoute('reseñas',     'GET',          'ReseniaApiController',   'getAll');
        $router->addRoute('reseñas/:id', 'GET',          'ReseniaApiController',   'get');
        $router->addRoute('reseñas/:id', 'DELETE',       'ReseniaApiController',   'delete');
        $router->addRoute('reseñas',     'POST',         'ReseniaApiController',   'create');
        $router->addRoute('reseñas/:id', 'PUT',          'ReseniaApiController',   'update');

        $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
