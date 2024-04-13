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
    $uriArray = array_filter(explode("/", $url));
    switch (count($uriArray)) {
      case 4:
        $parsedUrl = parse_url("/" . $uriArray[4]);
        $newUrl = $parsedUrl['path'];
        if (isset($this->routes[$method][$newUrl])) {
          $callback = $this->routes[$method][$newUrl];
          call_user_func($callback);
        } else {
          echo "$newUrl 404 Not Found";
        }
        break;
      case 5:
        $parsedUrl = parse_url("/" . $uriArray[4] . "/{id}");
        $newUrl = $parsedUrl['path'];
        if (isset($this->routes[$method][$newUrl])) {
          $callback = $this->routes[$method][$newUrl];
          call_user_func($callback, $uriArray[5]);
        } else {
          echo "$newUrl 404 Not Found";
        }
        break;
    }
  }
}
