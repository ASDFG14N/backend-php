<?php
include_once 'C:\xampp\htdocs\PHPVC\crud-animes\controllers\userController.php';
include_once 'C:\xampp\htdocs\PHPVC\crud-animes\utils\Router.php';
require_once 'C:\xampp\htdocs\PHPVC\crud-animes\middlewares\validateToken.php';

$router = new Router();

/**
 * Realiza la acción de inicio de sesión utilizando el método POST.
 */
$router->post('/login', function () {
  UserController::login();
});

/**
 * Realiza la acción de registro de usuario utilizando el método POST.
 */
$router->post('/register', function () {
  UserController::register();
});

/**
 * Realiza la acción de cierre de sesión utilizando el método POST.
 */
$router->post('/logout', function () {
  UserController::logout();
});


$router->get('/profile', function () {
  $res = authRequired();
  if ($res[0]) {
    UserController::profile($res[1]);
  }
});


$router->route($method, $uri);