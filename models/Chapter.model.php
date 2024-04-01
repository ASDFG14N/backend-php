<?php
include_once 'C:\xampp\htdocs\PHPVC\crud-animes\database\Database.php';
class Chapter extends Database
{
  public $title;
  public $video_url;
  public $fk_anime_id;

  public function __construct(string $title = null, string $video_url = null, int $fk_anime_id = null)
  {
    $this->title = $title;
    $this->video_url = $video_url;
    $this->fk_anime_id = $fk_anime_id;
    parent::__construct();
  }

  public function save()
  {
    $sql = "INSERT INTO chapters (title, video_url, fk_anime_id) VALUES (?, ?, ?)";
    $params = [
      $this->title,
      $this->video_url,
      $this->fk_anime_id
    ];
    $stmt = $this->executeStatement($sql, $params);
    $stmt->closeCursor();
    $this->closeConnection();
  }

  public function findById(int $id): array
  {
    $sql = "SELECT * FROM chapters WHERE fk_anime_id = ?";
    $params = [
      "fk_anime_id" => $id
    ];
    $stmt = $this->executeStatement($sql, $params);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $this->closeConnection();
    return $result;
  }
  public function findOne(int $id): array
  {
    $sql = "SELECT * FROM chapters WHERE fk_anime_id = ?";
    $params = [
      "fk_anime_id" => $id
    ];
    $stmt = $this->executeStatement($sql, $params);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $this->closeConnection();
    return $result;
  }
}