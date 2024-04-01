<?php
include_once 'C:\xampp\htdocs\PHPVC\crud-animes\utils\Router.php';
include_once 'C:\xampp\htdocs\PHPVC\crud-animes\controllers\chapter.controller.php';

$router = new Router();

//Obiene todos los capitulos de un anime por su id
$router->get('/chapters', function () {
  ChapterController::getChapters();
});

$router->route($method, $uri);