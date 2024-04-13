<?php
include_once 'C:\xampp\htdocs\PHPVC\crud-animes\models\User.php';
require_once 'C:\xampp\htdocs\PHPVC\crud-animes\config\config.php';
require_once 'C:\xampp\htdocs\PHPVC\crud-animes\vendor\autoload.php';
use Firebase\JWT\JWT;

class UserController
{
  public static function register()
  {
    $dataArray = json_decode(file_get_contents('php://input'), true);
    try {
      $user = new User();
      $findUser = $user->findByEmail(['email' => trim($dataArray['email'])]);
      if ($findUser) {
        print_r(json_encode([
          'message' => "El correo ya está en uso",
        ]));
        return;
      }
      $newUser = new User();
      $newUser->create([
        "username" => trim($dataArray['username']),
        "email" => trim($dataArray['email']),
        "password" => hash('sha512', $dataArray['password'])
      ]);
      $user = new User();
      $findUser = $user->findOne([
        'email' => trim($dataArray['email']),
        'password' => hash('sha512', $dataArray['password'])
      ]);
      $token = JWT::encode(
        [
          'exp' => time() + (60 * 60 * 24),
          "id" => trim($findUser['user_id'])
        ],
        TOKEN_KEY,
        'HS256'
      );
      setcookie('token', $token, time() + (60 * 60 * 24), '/');
      print_r(json_encode([
        "id" => $findUser['user_id'],
        "username" => trim($dataArray['username']),
        'message' => "Usuario creado con éxito",
        'status' => 200
      ]));
    } catch (\Throwable $th) {
      http_response_code(500);
      print_r(json_encode([
        'message' => "Al parecer hubo un problema, detalles: $th",
      ]));
    }
  }


  public static function login()
  {
    $dataArray = json_decode(file_get_contents('php://input'), true);
    try {
      $user = new User();
      $findUser = $user->findOne([
        'email' => trim($dataArray['emailUsername']),
        'password' => hash('sha512', $dataArray['password'])
      ]);
      if (!$findUser) {
        http_response_code(401);
        print_r(json_encode([
          'message' => "La cuenta o la contraseña es incorrecta",
        ]));
        return;
      }
      $token = JWT::encode(
        [
          'exp' => time() + (60 * 60 * 24),
          "id" => trim($findUser['user_id'])
        ],
        TOKEN_KEY,
        'HS256'
      );
      setcookie('token', $token, time() + (60 * 60 * 24), '/');
      print_r(json_encode([
        "id" => $findUser['user_id'],
        "username" => $findUser['username'],
        "email" => trim($dataArray['emailUsername']),
        'message' => "Inicio de sessión correcto",
        'status' => 200
      ]));
    } catch (\Throwable $th) {
      http_response_code(500);
      print_r(json_encode([
        'message' => "Al parecer hubo un problema, detalles: $th",
      ]));
    }
  }

  public static function logout()
  {
    $path = '/';

    if (isset($_COOKIE['token'])) {
      setcookie('token', "", time() + (60 * 60 * 24), $path);
    }
  }

  public static function profile($id)
  {
    $user = new User();
    $userFound = $user->findById($id);
    if (!$userFound) {
      http_response_code(400);
      print_r(json_encode([
        'message' => "Usuario no encontrado",
      ]));
      return;
    }
    print_r(json_encode([
      "id" => $userFound["user_id"],
      "username" => $userFound["username"],
      "email" => $userFound["email"],
      'message' => "Usuario encontrado",
      "status" => 200
    ]));
  }

}