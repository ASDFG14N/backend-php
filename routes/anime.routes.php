<?php
include_once 'C:\xampp\htdocs\PHPVC\crud-animes\utils\Router.php';
include_once 'C:\xampp\htdocs\PHPVC\crud-animes\controllers\anime.controller.php';

$router = new Router();

$router->get('/animes', function () {
  AnimeController::getAnimes();
});
$router->get('/anime', function () {
  AnimeController::getAnime();
});
$router->post('/animes', function () {
  AnimeController::createAnime();
  AnimeController::getAnimes();
});
$router->put('/anime', function () {
  AnimeController::updateAnime();
  AnimeController::getAnimes();
});
$router->delete('/animesdel', function () {
  $anime = new AnimeController();
  $anime->deleteAnime();
  $anime->getAnimes();
});

$router->route($method, $uri);