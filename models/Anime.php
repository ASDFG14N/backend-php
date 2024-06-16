<?php
require_once 'C:\xampp\htdocs\PHPVC\crud-animes\app\Model.php';
class Anime extends Model
{
  public function __construct()
  {
    parent::__construct();
    $this->tableName = 'animes';
    $this->tableNamePK = 'anime_id';
    $this->fillable = [
      "title",
      "poster_url",
      "synopsis",
      "status",
      "year",
      "type",
      "genres"
    ];
  }

  public function createAnime($data)
  {
    $sql = "INSERT INTO animes (title, poster_url, synopsis, status, year, type) 
    VALUES (?, ?, ?, ?, ?, ?)";
    $params = [
      $data['title'],
      $data['poster_url'],
      $data['synopsis'],
      $data['status'],
      $data['year'],
      $data['type']
    ];
    $stmt = $this->executeStatement($sql, $params);
    $stmt->closeCursor();
    $anime_id = $this->findByName($data['title']);
    foreach ($data['genres'] as $genre) {
      $sql = "INSERT INTO anime_genres (fk_anime_id, fk_genre_id) VALUES ($anime_id, $genre)";
      $stmt = $this->executeStatement($sql);
      $stmt->closeCursor();
    }
    $this->closeConnection();
  }

  public function findById($id)
  {
    $sql = "SELECT * FROM {$this->tableName} WHERE anime_id=?";
    $stmt = $this->executeStatement($sql, array('anime_id' => $id));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    if ($result != null) {
      $sql = "SELECT genre_id FROM genres
      RIGHT JOIN anime_genres
      ON anime_genres.fk_genre_id = genres.genre_id
      WHERE anime_genres.fk_anime_id = ?";
      $stmt = $this->executeStatement($sql, [$id]);
      $genreArray = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'genre_id');
      $stmt->closeCursor();
      $this->closeConnection();
      $result['genres'] = $genreArray;
    }
    return $result;
  }

  public function findByStatus(int $state)
  {
    $sql = "SELECT * FROM {$this->tableName} WHERE status=?";
    $stmt = $this->executeStatement($sql, array('status' => $state));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $this->closeConnection();
    return $result;
  }

  public function findByGenres(array $genres)
  {
    $sql = $this->generateQuery($genres);
    $stmt = $this->executeStatement($sql, $genres);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $this->closeConnection();
    return $result;
  }

  public function findByType(int $type)
  {
    $sql = "SELECT * FROM {$this->tableName} WHERE type=?";
    $stmt = $this->executeStatement($sql, array('type' => $type));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $this->closeConnection();
    return $result;
  }

  private function generateQuery($genres) {
    $sql = "SELECT ag1.fk_anime_id FROM anime_genres ag1";
    for ($i = 2; $i <= count($genres); $i++) {
        $sql .= " JOIN anime_genres ag{$i} ON ag1.fk_anime_id = ag{$i}.fk_anime_id";
    }
    $sql .= " WHERE";
    for ($i = 1; $i <= count($genres); $i++) {
        if ($i > 1) {
            $sql .= " AND";
        }
        $sql .= " ag{$i}.fk_genre_id = ?";
    }
    return $sql;
  }

  public function updateObj(array $data)
  {
    $sql = "UPDATE {$this->tableName} SET 
    title = ?, 
    poster_url = ?, 
    synopsis = ?, 
    status = ?, 
    year = ?, 
    type = ? 
    WHERE anime_id = ?";
    $params = [
      $data['title'],
      $data['poster_url'],
      $data['synopsis'],
      $data['status'],
      $data['year'],
      $data['type'],
      $data['id']
    ];

    $stmt = $this->executeStatement($sql, $params);
    $stmt->closeCursor();
  }

}