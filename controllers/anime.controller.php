<?php
require_once 'C:\xampp\htdocs\PHPVC\crud-animes\models\Anime.model.php';
class AnimeController
{
  //metodo get
  public static function getAnimes()
  {
    $anime = new AnimeModel();
    print_r(json_encode($anime->findAll()));
  }
  public static function getAnime()
  {
    $id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : null;
    $anime = new AnimeModel();
    $animeFound = $anime->findById($id);
    if (!$animeFound) {
      http_response_code(400);
      print_r(json_encode([
        'message' => "Anime no encontrado",
      ]));
      return;
    }
    print_r(json_encode($animeFound));
  }
  //Metodo post
  public static function createAnime()
  {
    $dataArray = json_decode(file_get_contents('php://input'), true);
    $newAnime = new AnimeModel(
      title: trim($dataArray['title']),
      poster: $dataArray['poster'],
      synopsis: trim($dataArray['synopsis']),
      status: $dataArray['status'],
      year: $dataArray['year'],
      type: $dataArray['type'],
      genres: $dataArray['genres']
    );
    $newAnime->save();
  }
  //metodo put

  public static function updateAnime()
  {
    $jsonData = json_decode(file_get_contents("php://input"), true);
    $anime = new AnimeModel();
    $anime->findByIdAndUpdate($jsonData);
  }

  //metodo delete
  public function deleteAnime()
  {
    $jsonData = json_decode(file_get_contents("php://input"), true);
    $id = isset($jsonData['id']) ? htmlspecialchars($jsonData['id']) : null;
    $anime = new AnimeModel();
    $animeFound = $anime->findByIdAndDelete($id);
    if (!$animeFound) {
      http_response_code(400);
      print_r(json_encode([
        'message' => "Anime no encontrado",
      ]));
      return;
    }
    print_r(json_encode($animeFound));
  }
}