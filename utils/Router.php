<?php
class Router
{
  private $routes = [];

  public function get($url, $callback)
  {
    $this->routes['GET'][$url] = $callback;
  }

  public function post($url, $callback)
  {
    $this->routes['POST'][$url] = $callback;
  }
  public function put($url, $callback)
  {
    $this->routes['PUT'][$url] = $callback;
  }
  public function delete($url, $callback)
  {
    $this->routes['DELETE'][$url] = $callback;
  }

  public function route($method, $url)
  {
    $uriArray = explode("/", $url);
    $uriArray = array_filter($uriArray);
    $newUrl = "/" . $uriArray[4];
    $parsedUrl = parse_url($newUrl);
    $newUrl = $parsedUrl['path'];
    if (isset($this->routes[$method][$newUrl])) {
      $callback = $this->routes[$method][$newUrl];
      call_user_func($callback);
    } else {
      echo "$newUrl 404 Not Found";
    }
  }
}
