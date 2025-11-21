<?php
    require_once './db/config.php';
    class Model {
        protected $db;

        public function __construct() {
            $this->crearDb();
            $this->db = new PDO(
                'mysql:host='. MYSQL_HOST .
                ';dbname='. MYSQL_DB .
                ';charset=utf8', MYSQL_USER, MYSQL_PASS
            );
            $this->deploy();
        }

        private function deploy(){
            $query = $this->db->query('SHOW TABLES');
            $tables = $query->fetchAll();
            if(count($tables) == 0) {
                $password = '$2y$10$J.JBLIWqkmxWPcLpiu/.e.yK00UeY5wQO0cIKebWfvsMaOOcgH.Oa';
                $sql =<<<END
                --
                -- Estructura de tabla para la tabla `libreria`
                --

                CREATE TABLE `libreria` (
                `id_libreria` int(11) NOT NULL,
                `nombre` varchar(70) NOT NULL,
                `direccion` varchar(100) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

                --
                -- Volcado de datos para la tabla `libreria`
                --

                INSERT INTO `libreria` (`id_libreria`, `nombre`, `direccion`) VALUES
                (12, 'Librería Tandil Centro', 'Av. Colón 123'),
                (13, 'El Rincón del Libro', 'Calle Belgrano 456'),
                (14, 'Libros y Más', 'Calle Alem 789'),
                (15, 'Tandil Bookstore', 'Av. España 101'),
                (16, 'El Estante Mágico', 'Calle Mitre 202'),
                (17, 'La Pluma Dorada', 'Calle Sarmiento 303');

                -- --------------------------------------------------------

                --
                -- Estructura de tabla para la tabla `libros`
                --

                CREATE TABLE `libros` (
                `id_libro` int(11) NOT NULL,
                `nombre_libro` varchar(70) NOT NULL,
                `genero` varchar(50) NOT NULL,
                `editorial` varchar(70) NOT NULL,
                `id_libreria` int(11) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

                --
                -- Volcado de datos para la tabla `libros`
                --

                INSERT INTO `libros` (`id_libro`, `nombre_libro`, `genero`, `editorial`, `id_libreria`) VALUES
                (4, '1984', 'Ciencia ficción', 'Secker & Warburg', 15),
                (5, 'Crimen y castigo', 'Ficción', 'Penguin Classics', 16),
                (6, 'Don Quijote de la Mancha', 'Clásico', 'Francisco de Robles', 17),
                (7, 'El Gran Gatsby', 'Ficción', 'Scribner', 12),
                (8, 'Orgullo y prejuicio', 'Romántico', 'T. Egerton', 13),
                (9, 'El retrato de Dorian Gray', 'Ficción', 'Lippincott\s Monthly Magazine', 14),
                (10, 'La sombra del viento', 'Ficción', 'Planeta', 15);

                -- --------------------------------------------------------

                --
                -- Estructura de tabla para la tabla `reseñas`
                --

                CREATE TABLE `reseñas` (
                `id` int(11) NOT NULL,
                `nombre` varchar(80) NOT NULL,
                `apellido` varchar(80) NOT NULL,
                `comentario` varchar(255) NOT NULL,
                `id_libro` int(11) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                --
                -- Volcado de datos para la tabla `reseñas`
                --

                INSERT INTO `reseñas` (`id`, `nombre`, `apellido`, `comentario`, `id_libro`) VALUES
                (31, 'Marcelo', 'Clavar', 'Muy buen libro.', 4),
                (32, 'Marcelo', 'Clavar', 'Muy buen libro.', 4),
                (33, 'Marcelo', 'Clavar', 'Muy buen libro.', 4),
                (34, 'Marcelo', 'Clavar', 'Muy buen libro.', 4),
                (35, 'Marcelo', 'Clavar', 'Muy buen libro.', 5),
                (36, 'Marcelo', 'Clavar', 'Muy buen libro.', 5),
                (37, 'Marcelo', 'Clavar', 'Muy buen libro.', 5),
                (38, 'Marcelo', 'Clavar', 'Muy buen libro.', 5);

                -- --------------------------------------------------------

                --
                -- Estructura de tabla para la tabla `user`
                --

                CREATE TABLE `user` (
                `id` int(4) NOT NULL,
                `mail` varchar(100) NOT NULL,
                `password` char(60) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                --
                -- Volcado de datos para la tabla `user`
                --

                INSERT INTO `user` (`id`, `mail`, `password`) VALUES
                (1, 'webadmin', '$password');

                --
                -- Índices para tablas volcadas
                --

                --
                -- Indices de la tabla `libreria`
                --
                ALTER TABLE `libreria`
                ADD PRIMARY KEY (`id_libreria`);

                --
                -- Indices de la tabla `libros`
                --
                ALTER TABLE `libros`
                ADD PRIMARY KEY (`id_libro`),
                ADD KEY `id_libreria` (`id_libreria`);

                --
                -- Indices de la tabla `reseñas`
                --
                ALTER TABLE `reseñas`
                ADD PRIMARY KEY (`id`),
                ADD KEY `id_libro` (`id_libro`);

                --
                -- Indices de la tabla `user`
                --
                ALTER TABLE `user`
                ADD PRIMARY KEY (`id`),
                ADD UNIQUE KEY `mail` (`mail`);

                --
                -- AUTO_INCREMENT de las tablas volcadas
                --

                --
                -- AUTO_INCREMENT de la tabla `libreria`
                --
                ALTER TABLE `libreria`
                MODIFY `id_libreria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

                --
                -- AUTO_INCREMENT de la tabla `libros`
                --
                ALTER TABLE `libros`
                MODIFY `id_libro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

                --
                -- AUTO_INCREMENT de la tabla `reseñas`
                --
                ALTER TABLE `reseñas`
                MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

                --
                -- AUTO_INCREMENT de la tabla `user`
                --
                ALTER TABLE `user`
                MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

                --
                -- Restricciones para tablas volcadas
                --

                --
                -- Filtros para la tabla `libros`
                --
                ALTER TABLE `libros`
                ADD CONSTRAINT `libros_ibfk_1` FOREIGN KEY (`id_libreria`) REFERENCES `libreria` (`id_libreria`);

                --
                -- Filtros para la tabla `reseñas`
                --
                ALTER TABLE `reseñas`
                ADD CONSTRAINT `reseñas_ibfk_1` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id_libro`);
                COMMIT;
                END;
                $this->db->query($sql);
            }

        }

        private function crearDb(){
            $nombreDb = MYSQL_DB;
            $pdo = new PDO('mysql:host =' .MYSQL_HOST.';charset = utf8', MYSQL_USER, MYSQL_PASS);
            $query = "CREATE DATABASE IF NOT EXISTS $nombreDb";
            $pdo->exec($query);
        }

    }
