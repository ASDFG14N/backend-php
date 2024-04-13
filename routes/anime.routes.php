<?php
include_once 'C:\xampp\htdocs\PHPVC\crud-animes\utils\Router.php';
include_once 'C:\xampp\htdocs\PHPVC\crud-animes\controllers\animeController.php';

$router = new Router();

$router->get('/animes', function () {
  AnimeController::getAnimes();
});
$router->get('/anime/{id}', function ($id) {
  AnimeController::getAnime($id);
});
$router->post('/animes', function () {
  AnimeController::store();
  //AnimeController::getAnimes();
});
$router->put('/anime/{id}', function ($id) {
  AnimeController::update();
  //AnimeController::getAnimes();
});
$router->delete('/anime/{id}', function ($id) {
  AnimeController::destroy($id);
  AnimeController::getAnimes();
});

$router->route($method, $uri);