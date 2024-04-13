<?php
require_once 'C:\xampp\htdocs\PHPVC\crud-animes\vendor\autoload.php';
require_once 'C:\xampp\htdocs\PHPVC\crud-animes\config\config.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function authRequired(): array
{
  if (isset($_SERVER['HTTP_COOKIE'])) {
    $token = str_replace('token=', '', $_SERVER['HTTP_COOKIE']);
    try {
      $decoded = JWT::decode($token, new Key(TOKEN_KEY, 'HS256'));
      return array(true, $decoded->id);
    } catch (Exception $e) {
    }
  }
  http_response_code(401);
  echo json_encode(['message' => 'Token inválido, acceso denegado']);
  return array(false);
}