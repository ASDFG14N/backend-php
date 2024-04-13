<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");


$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];


if (strpos($uri, '/animes') or strpos($uri, '/anime')) {
  include './routes/anime.routes.php';
} else if (strpos($uri, '/login') or strpos($uri, '/register') or strpos($uri, '/profile') ) {
  include './routes/auth.routes.php';
} else if(strpos($uri, '/chapters')) {
  include './routes/chapters.routes.php';
}