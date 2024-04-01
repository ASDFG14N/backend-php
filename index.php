<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");


$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$uriArray = explode("/", $uri);
$uriArray = array_filter($uriArray);
$newUrl = "/" . $uriArray[4];
$parsedUrl = parse_url($newUrl);
$newUrl = $parsedUrl['path'];

if ($newUrl == '/animes' or $newUrl == '/anime' or $newUrl == '/animesdel') {
  include './routes/anime.routes.php';
} else if ($newUrl == '/login' or $newUrl == '/register') {
  include './routes/auth.routes.php';
} else {
  include './routes/chapters.routes.php';
}