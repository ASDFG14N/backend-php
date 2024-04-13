<?php
include_once 'C:\xampp\htdocs\PHPVC\crud-animes\models\Chapter.php';
class ChapterController
{
  public static function getChapters($id)
  {
    $chapter = new Chapter();
    $chaptersFound = $chapter->findById($id);
    if ($chaptersFound == null) {
      http_response_code(400);
      print_r(json_encode([
        'message' => "Capitulos no encontrados",
      ]));
      return;
    }
    print_r(json_encode($chaptersFound));

  }
  public static function getChapter()
  {
    $id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : null;
    $chapter = new Chapter();
  }

  public static function addChapter()
  {
    $dataArray = json_decode(file_get_contents('php://input'), true);
    $newChapter = new Chapter();
    $newChapter->create($dataArray);
  }
}