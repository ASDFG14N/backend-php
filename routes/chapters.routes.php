<?php
include_once 'C:\xampp\htdocs\PHPVC\crud-animes\utils\Router.php';
include_once 'C:\xampp\htdocs\PHPVC\crud-animes\controllers\chapterController.php';

$router = new Router();

//Obiene todos los capitulos de un anime por su id
$router->get('/chapters/{id}', function ($id) {
  ChapterController::getChapters($id);
});

$router->route($method, $uri);