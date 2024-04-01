<?php
function authRequired(): bool
{
  if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookieString = $_SERVER['HTTP_COOKIE'];
    $cookieValue = str_replace('token=', '', $cookieString);
    echo "Valor de la cookie: " . $cookieValue;
    return true;
  } else {
    http_response_code(401);
    echo "No autorizado";
  }
  return false;
}