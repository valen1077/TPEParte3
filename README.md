# Libreria

## Indice

- [Integrante](#integrante)
- [Despliegue](#despliegue)
- [Requisitos Previos](#requisitos-previos)
- [Pasos para Desplegar](#pasos-para-desplegar)
- [ENDPOINTS LIBROS](#endpoints-libros)
  - [Solicitar todos los libros](#1-solicitar-todos-los-libros)
  - [Solicitar un libro](#2-solicitar-un-libro)
  - [Borrar un libro](#3-borrar-un-libro)
  - [Editar un libro](#4-editar-un-libro)
  - [Agregar un libro](#5-agregar-un-libro)
- [ENDPOINTS RESEÑAS](#endpoints-reseñas)
  - [Solicitar todas las reseñas](#1-solicitar-todas-las-reseñas)
  - [Solicitar una reseña](#2-solicitar-una-reseña)
  - [Borrar una reseña](#3-borrar-una-reseña)
  - [Editar una reseña](#4-editar-una-reseña)
  - [Agregar una reseña](#5-agregar-una-reseña)
- [TOKEN Endpoint](#token-endpoint)
- [Diagrama de Relación](#der)

## Integrante:
 * Valentino Salerno (43258242)

## Descripción

Desarrollé una Api RESTful para gestionar las entidades de una cadena de librerias, de manera de que cualquier dispositivo pueda consumirla.

## Despliegue

Para desplegar la api en un servidor con Apache y MySQL, sigue estos pasos:

### Requisitos Previos

- Tener instalado XAMPP.
- Asegurarse de que el servidor esté en funcionamiento.

### Pasos para Desplegar

1. **Descargar el Repositorio**
Clona el repositorio en tu máquina local o descarga los archivos ZIP y descomprímelos en tu computadora.

2. **Mover archivos**
Copia la carpeta del proyecto a C:\xampp\htdocs\ .

3. **Configurar Conexión**
Edita config.php para ajustar las credenciales de la base de datos.

4. **Configurar Conexión**
Acceder al Sitio: Visita http://localhost/api_web2 .

## ENDPOINTS LIBROS

Para consumir la API podemos utilizar los siguientes endpoints.

### 1. **Solicitar todos los libros**
A. Para esto vamos a utilizar el metodo GET y la siguiente url: 

- localhost/api_web2/api/libros

B. En este enpoint se puede filtrar por el id de cada libreria de la siguiente manera:

- localhost/api_web2/api/libros?id_libreria=12

Donde "12" es el id de la libreria que queres solicitar.

C. Los libros solicitados tambien pueden ordenarse de manera ascendente o desendente mediente orderBy:

- localhost/api_web2/api/libros?orderBy=id_libro

id_libro no es el unico campo de ordenamiento, se puede ordenar por cualquiera de sus campos.

---

- localhost/api_web2/api/libros?orderBy=nombre_libro

**Para ordenar por titulo.**

---

- localhost/api_web2/api/libros?orderBy=genero

**Para ordenar por genero.**

---

- localhost/api_web2/api/libros?orderBy=editorial

**Para ordenar por editorial.**

---

- localhost/api_web2/api/libros?orderBy=id_libreria

**Para ordenar por el id de la libreria.**

---

**De forma predeterminada ordena ascendentemente**

D. Para ordenar de forma Descendente lo hacemos a travez de: **criterio=DESC**

localhost/api_web2/api/libros?orderBy=id_libro&criterio=DESC
Esto organizara todos los libros de forma descendente segun el id del libro.

E. Si en nuestra solicitud tenemos demaciados articulos, podemos paginarlos de la siguiente manera.

localhost/api_web2/api/libros?pagina=1&items=5
Lo que estamos especificando la cantidad de items que deseamos traer por pagina.
A la pagina vamos a setearle el numero de pagina en el que queremos posicionarnos.
items y pagina siembre van juntos, de lo contrario no hay paginacion.

F. Cualquiera de todos los anteriores puede acumularse a travez de el simbolo & en cualquier orden.
localhost/api_web2/api/libros?criterio=DESC&pagina=1&items=5&id_libreria=13&orderBy=id_libro

---

### 2. **Solicitar un libro**
Para esto vamos a usar el metodo GET y la siguiente url:

-localhost/api_web2/api/libros/4
Donde 4 es el id del libro que solicitamos.

---

### 3. **Borrar un libro**
Es necesario la autenticacion con un token.
Para eliminar un libro lo haremos a travez del metodo DELETE y la siguiente url.

-localhost/api_web2/api/libros/4
Donde 4 es el id del libro que deseamos eliminar.

---

### 4. **Editar un libro**
Es necesario la autenticacion con un token.
Para editar un libro lo haremos a travez del metodo PUT y la siguiente url.

- localhost/api_web2/api/libros/4
Donde 4 es el id del libro que deseamos editar.
Tambien debemos pasarle al body los siguientes campos.

{
    "nombre_libro": "El Alquimista",
    "genero": "Ficción",
    "editorial": "Planeta",
    "id_libreria": 21
}

Tener en cuenta es que todos los campos son obligatorios.

---

### 5. **Agregar un libro**
Es necesario la autenticacion con un token.
Para crear un nuevo libro es necesario utilizar el metodo POST y la siguiente url.

- localhost/api_web2/api/libros/
Tambien es necesario enviarle al body los siguientes campos.

{
    "nombre_libro": "Nuevo nombre",
    "genero": "Genero del libro",
    "editorial": "Editorial del libro",
    "id_libreria": 1112
}

## ENDPOINTS RESEÑAS

###  1. **Solicitar todas las reseñas**
A. Para esto vamos a utilizar el método GET y la siguiente URL:

- localhost/api_web2/api/reseñas

B. En este endpoint se puede filtrar por el ID del libro de la siguiente manera:

- localhost/api_web2/api/reseñas?id_libro=5
Donde "5" es el ID del libro cuyas reseñas quieres solicitar.

C. Las reseñas solicitadas también pueden ordenarse de manera ascendente o descendente mediante orderBy:

- localhost/api_web2/api/reseñas?orderBy=nombre

**Para ordenar por nombre.**


- localhost/api_web2/api/reseñas?orderBy=apellido

**Para ordenar por apellido.**

- localhost/api_web2/api/reseñas?orderBy=comentario

**Para ordenar por comentario.**

- localhost/api_web2/api/reseñas?orderBy=id_libro

**Para ordenar por ID del libro.**

**De forma predeterminada, ordena ascendentemente.**

D. Para ordenar de forma descendente lo hacemos a través de: criterio=DESC

- localhost/api_web2/api/reseñas?orderBy=nombre&criterio=DESC
Esto organizará todas las reseñas de forma descendente según el campo nombre.

E. Si en nuestra solicitud tenemos demasiados elementos, podemos paginarlos de la siguiente manera:

- localhost/api_web2/api/reseñas?pagina=1&items=10

Estamos especificando la cantidad de elementos por página. A la página le asignamos el número en el que queremos posicionarnos.
Nota: Los parámetros items y pagina siempre van juntos; de lo contrario, no hay paginación.

F. Todos los parámetros anteriores pueden acumularse mediante el símbolo & en cualquier orden:

- localhost/api_web2/api/reseñas?criterio=DESC&pagina=1&items=10&id_libro=5&orderBy=nombre

---

###  2. **Solicitar una reseña**
Para esto vamos a usar el método GET y la siguiente URL:

- localhost/api_web2/api/reseñas/3
Donde "3" es el ID de la reseña que solicitamos.

---

### 3. **Borrar una reseña**
Es necesaria la autenticación con un token.
Para eliminar una reseña, usaremos el método DELETE y la siguiente URL:

- localhost/api_web2/api/reseñas/3
Donde "3" es el ID de la reseña que queremos eliminar.

---

### 4. **Editar una reseña**
Es necesaria la autenticación con un token.
Para editar una reseña, usaremos el método PUT y la siguiente URL:

- localhost/api_web2/api/reseñas/3
Donde "3" es el ID de la reseña que queremos editar.
Debemos pasarle al body los siguientes campos:

{
    "nombre": "Juan",
    "apellido": "Pérez",
    "comentario": "Excelente libro",
    "id_libro": 5
}

Nota: Todos los campos son obligatorios.

---

### 5. **Agregar una reseña**
Es necesaria la autenticación con un token.
Para crear una nueva reseña, usaremos el método POST y la siguiente URL:

- localhost/api_web2/api/reseñas
También es necesario enviarle al body los siguientes campos:

{
    "nombre": "Carla",
    "apellido": "Gómez",
    "comentario": "Recomendado 100%",
    "id_libro": 7
}

## TOKEN ENDPOINT

Para este punto es necesario conectarse con un usuario y contraseña.
Para esto vamos al apartado Authorization y seleccionamos Basic Auth.

-Usuario: webadmin

-Contraseña: admin

A travez del metodo GET y la url.

- localhost/api_web2/api/user/token
Si hiciste todo bien, este devolvera un codigo similar el siguiente.

"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImVtYWlsIjoiQ2FybGl0b3MiLCJyb2xlIjoiRG9taW5ndWVybyIsImlhdCI6MTczMTcyMDc1OSwiZXhwIjoxNzMxNzI0MzU5LCJTYWx1ZGlsbG8gQ29tcGHDsWVybyI6IkVzcGVyYWJhIG1hcyJ9.MceB7onEz3X1TZh2qOVavaE5shWwsHbxCLRhUmD9o8I"

Este codigo vamos a utilizarlo para la authorization.
Seleccionamos Bearer Token y pegamos el codigo anterior sin comillas.
De esta manera podemos utilizar los enpoints con authoriation.

- [Volver al inicio](#Libreria)

## DER

![Diagrama Entidad Relación](/der.png)
