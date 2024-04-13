<?php
include_once 'C:\xampp\htdocs\PHPVC\crud-animes\app\Http\Controller.php';
include_once 'C:\xampp\htdocs\PHPVC\crud-animes\models\Anime.php';
class AnimeController extends Controller
{

  public static function getAnimes()
  {
    $anime = new Anime();
    print_r(json_encode($anime->findAll()));
  }

  public static function getAnime($id)
  {
    $anime = new Anime();
    $animeFound = $anime->findById($id);
    if (!$animeFound) {
      http_response_code(404);
      print_r(json_encode([
        'message' => "Anime no encontrado",
        "status" => 404
      ]));
      return;
    }
    print_r(json_encode($animeFound));
  }

  public static function store()
  {
    $dataArray = json_decode(file_get_contents('php://input'), true);
    $anime = new Anime();
    $data = [
      "title" => trim($dataArray['title']),
      "poster_url" => $dataArray['poster_url'],
      "synopsis" => trim($dataArray['synopsis']),
      "status" => $dataArray['status'],
      "year" => $dataArray['year'],
      "type" => $dataArray['type'],
      "genres" => $dataArray['genres']
    ];
    $anime->createAnime($data);
  }

  public static function update()
  {
    $jsonData = json_decode(file_get_contents("php://input"), true);
    $anime = new Anime();
    $animeFound = $anime->findById($jsonData['id']);
    if (!$animeFound) {
      http_response_code(404);
      print_r(json_encode([
        'message' => "Anime no encontrado",
        "status" => 404
      ]));
      return;
    }
    $anime = new Anime();
    $anime->updateObj($jsonData);
    // $animeFound = $anime->findById($jsonData['id']);
    print_r(json_encode($animeFound));
  }

  public static function destroy($id)
  {
    $anime = new Anime();
    $animeFound = $anime->findByIdAndDelete($id);
    if ($animeFound != null) {
      http_response_code(400);
      print_r(json_encode([
        'message' => "Anime no encontrado",
      ]));
      return;
    }
  }
}
