<?php
include_once 'C:\xampp\htdocs\PHPVC\crud-animes\utils\Router.php';
include_once 'C:\xampp\htdocs\PHPVC\crud-animes\controllers\animeController.php';

$router = new Router();

$router->get('/animes', function () {
  AnimeController::getAnimes();
});
$router->get('/movies', function () {
  AnimeController::getMovies();
});
$router->get('/anime/{id}', function ($id) {
  AnimeController::getAnime($id);
});
$router->post('/animes', function () {
  AnimeController::store();
});
$router->put('/anime/{id}', function ($id) {
  AnimeController::update();
});
$router->delete('/anime/{id}', function ($id) {
  AnimeController::destroy($id);
});

//private endopoints---------------------------
$router->get('/status/{id}', function ($state) {
  AnimeController::getAnimesByStatus($state);
});
$router->get('/genres', function () {
  AnimeController::getAnimesByGenre();
});
//---------------------------------------------
$router->route($method, $uri);