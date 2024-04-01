<?php
include_once 'C:\xampp\htdocs\PHPVC\crud-animes\controllers\auth.controller.php';
include_once 'C:\xampp\htdocs\PHPVC\crud-animes\utils\Router.php';
require_once 'C:\xampp\htdocs\PHPVC\crud-animes\middlewares\validateToken.php';

$router = new Router();

/**
 * Realiza la acción de inicio de sesión utilizando el método POST.
 */
$router->post('/login', function () {
  AuthController::login();
});

/**
 * Realiza la acción de registro de usuario utilizando el método POST.
 */
$router->post('/register', function () {
  AuthController::register();
});

/**
 * Realiza la acción de cierre de sesión utilizando el método POST.
 */
$router->post('/logout', function () {
  AuthController::logout();
});

/**
 * Realiza la acción de mostrar la página de inicio utilizando el método GET.
 * Verifica si la autenticación es requerida antes de mostrar la página.
 */
$router->get('/home', function () {
  if (authRequired()) {
    AuthController::home();
  }
});


$router->route($method, $uri);