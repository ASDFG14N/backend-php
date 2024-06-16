--==================================================================
--INSERTAR VALORES A LA TABLA ANIMES
--==================================================================
--agregar animes a la base de datos, tabla animes

INSERT INTO animes 
(
title, 
poster_url, 
synopsis, 
status, 
year, 
type
)
VALUES (
        "Boku no Kokoro no Yabai Yatsu Season 2", 
        "img1.png", 
        "Segunda temporada de Boku no Kokoro no Yabai Yatsu", 
        0, 
        2024,
        "TV"
        ),
        (
        "Kingdom 5th Season", 
        "img2.png", 
        "Quinta temporada de Kingdom.", 
        0, 
        2024,
        "Anime"
        );

--vizualiza la tabla animes
SELECT * FROM animes;
/*
+----------+----------------------------------------+------------+----------------------------------------------------+--------+------+-------+
| anime_id | title                                  | poster_url | synopsis                                           | status | year | type  |
+----------+----------------------------------------+------------+----------------------------------------------------+--------+------+-------+
|        1 | Boku no Kokoro no Yabai Yatsu Season 2 | img1.png   | Segunda temporada de Boku no Kokoro no Yabai Yatsu |      0 | 2024 | TV    |
|        2 | Kingdom 5th Season                     | img2.png   | Quinta temporada de Kingdom.                       |      0 | 2024 | Anime |
+----------+----------------------------------------+------------+----------------------------------------------------+--------+------+-------+
*/


--==================================================================
--INSERTAR VALORES A LOS GENEROS
--==================================================================

--agregar generos a la base de datos, tabla generos
-- Insertar géneros
INSERT INTO genres (name) 
VALUES ('Acción'),
       ('Artes Marciales'),
       ('Aventuras'),
       ('Carreras'),
       ('Ciencia Ficción'),
       ('Demencia'),
       ('Demonios'),
       ('Deportes'),
       ('Ecchi'),
       ('Escolares'),
       ('Espacial'),
       ('Fantasia'),
       ('Harem'),
       ('Histórico'),
       ('Infantil'),
       ('Juegos'),
       ('Magia'),
       ("Militar"),
       ("Misterio"),
       ("Musica"),
       ("Parodia"),
       ("Policía"),
       ("Psicológico"),
       ("Recuerdos de la vida"),
       ("Samurai"),
       ("Seisen"),
       ("Shoujo"),
       ("Superpoderes"),
       ("Suspenso"),
       ("Terror"),
       ("Vampiros"),
       ("Yuri");
--vizualizar la tabla
SELECT * FROM genres;
/*
+----------+----------------------+
| genre_id | name                 |
+----------+----------------------+
|        1 | Acción               |
|        2 | Artes Marciales      |
|        3 | Aventuras            |
|        4 | Carreras             |
|        5 | Ciencia Ficción      |
|        6 | Comedia              |
|        7 | Demencia             |
|        8 | Demonios             |
|        9 | Deportes             |
|       10 | Drama                |
|       11 | Ecchi                |
|       12 | Escolares            |
|       13 | Espacial             |
|       14 | Fantasia             |
|       15 | Harem                |
|       16 | Histórico            |
|       17 | Infantil             |
|       18 | Juegos               |
|       19 | Magia                |
|       20 | Militar              |
|       21 | Misterio             |
|       22 | Música               |
|       23 | Parodia              |
|       24 | Policía              |
|       25 | Psicológico          |
|       26 | Recuerdos de la vida |
|       27 | Romance              |
|       28 | Samurai              |
|       29 | Seisen               |
|       30 | Shoujo               |
|       31 | Sobrenatural         |
|       32 | Superpoderes         |
|       33 | Suspenso             |
|       34 | Terror               |
|       35 | Vampiros             |
|       36 | Yuri                 |
+----------+----------------------+
*/
--Se desea actualizar la tabla(solo para un dato)
UPDATE genres
SET name = "Yuri"
WHERE genre_id = 36;

--==================================================================
--RELACIONES
--==================================================================
--agregar relaciones a la base de datos, tabla relaciones

-- Asignar géneros a un anime específico
INSERT INTO anime_genres (fk_anime_id, fk_genre_id) VALUES (1, 1);  -- anime_id 1 tiene género Romance
INSERT INTO anime_genres (fk_anime_id, fk_genre_id) VALUES (1, 4);  -- anime_id 1 tiene género Comedia
/*
+----------------+-------------+-------------+
| anime_genre_id | fk_anime_id | fk_genre_id |
+----------------+-------------+-------------+
|              1 |           1 |           1 |
|              2 |           1 |           4 |
+----------------+-------------+-------------+
*/


--==================================================================
--CONSULTAS
--==================================================================

--ejecutar una consulta 
SELECT animes.*
FROM animes
JOIN anime_genres ON animes.anime_id = anime_genres.fk_anime_id
JOIN genres ON anime_genres.fk_genre_id = genres.genre_id
WHERE genres.name = 'Comedia'

-- +----------+----------------------------------------+------------+----------------------------------------------------+--------+------+------+
-- | anime_id | title                                  | poster_url | synopsis                                           | status | year | type |
-- +----------+----------------------------------------+------------+----------------------------------------------------+--------+------+------+
-- |        1 | Boku no Kokoro no Yabai Yatsu Season 2 | img1.png   | Segunda temporada de Boku no Kokoro no Yabai Yatsu |      0 | 2024 | TV   |
-- +----------+----------------------------------------+------------+----------------------------------------------------+--------+------+------+


--recuperar id por nombre 
SELECT anime_id FROM animes WHERE title="Boku no Kokoro no Yabai Yatsu Season 2"


--Recuperar generos por id
SELECT name FROM genres
RIGHT JOIN anime_genres
ON anime_genres.fk_genre_id = genres.genre_id
WHERE anime_genres.fk_anime_id = 5;


/*Traer los animes segun el tipo*/
select * from animes where type = 0;

/*Traer los animes segun el año*/
select * from animes where year = 2023;

/*Traer los animes segun el estado*/
select * from animes where status = 1;

/*Traer los animes segun los generos*/
SELECT ag1.fk_anime_id
FROM anime_genres ag1
JOIN anime_genres ag2 ON ag1.fk_anime_id = ag2.fk_anime_id
WHERE ag1.fk_genre_id = 6 AND ag2.fk_genre_id = 12;

SELECT * FROM animes WHERE title LIKE '%Kingd%';