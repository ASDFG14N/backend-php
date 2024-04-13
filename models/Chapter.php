<?php
require_once 'C:\xampp\htdocs\PHPVC\crud-animes\app\Model.php';
class Chapter extends Model
{
  public function __construct()
  {
    parent::__construct();
    $this->tableName = 'chapters';
    $this->tableNamePK = 'fk_anime_id';
    $this->fillable = [
      "title",
      "video_url",
      "fk_anime_id"
    ];
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

}