<?php
include_once 'C:\xampp\htdocs\PHPVC\crud-animes\models\User.model.php';

class AuthController
{
  /**
   * Registra un nuevo usuario.
   *
   * Esta función obtiene los datos de usuario del cuerpo de la solicitud JSON,
   * crea una instancia de la clase User, guarda el usuario y genera un token
   * que se almacena en una cookie.
   *
   */
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
      $hashPassword = hash('sha512', $dataArray['password']);
      $newUser = new User(
        username: trim($dataArray['username']),
        email: trim($dataArray['email']),
        password: $hashPassword
      );
      $newUser->save();
      // Generar un token aleatorio y almacenarlo en una cookie
      $token = bin2hex(random_bytes(32));
      setcookie('token', $token, time() + (60 * 60 * 24), '/');
      print_r(json_encode([
        'message' => "User created successfully",
      ]));
    } catch (\Throwable $th) {
      http_response_code(500);
      print_r(json_encode([
        'message' => "Apparently there was a problem, details: $th",
      ]));
    }
  }

  /**
   * Inicia sesión de usuario.
   *
   * Este método maneja la lógica para iniciar sesión de un usuario. 
   * Obtiene los datos de inicio de sesión del cuerpo de la solicitud JSON,
   * verifica las credenciales, genera un token y almacena el token en una cookie.
   *
   * @return void No devuelve ningún valor explícito. 
   *              En caso de éxito, imprime un mensaje indicando que el inicio de sesión fue exitoso.
   *              En caso de fallo, imprime un mensaje de error indicando que el usuario no fue encontrado.
   */
  public static function login()
  {
    $dataArray = json_decode(file_get_contents('php://input'), true);
    try {
      $hashPassword = hash('sha512', $dataArray['password']);
      $user = new User();
      $data = [
        'email' => trim($dataArray['emailUsername']),
        'password' => $hashPassword
      ];
      $findUser = $user->findOne($data);
      if (!$findUser) {
        http_response_code(401);
        print_r(json_encode([
          'message' => "La cuenta o la contraseña es incorrecta",
        ]));
        return;
      }
      http_response_code(200);
      print_r(json_encode([
        'message' => "Successfully logged in",
      ]));
      $token = bin2hex(random_bytes(32));
      setcookie('token', $token, time() + (60 * 60 * 24), '/');
    } catch (\Throwable $th) {
      http_response_code(500);
      print_r(json_encode([
        'message' => "Apparently there was a problem, details: $th",
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

  public static function home()
  {
    echo "Bienvenido al home";
  }
}
