<?php
require_once 'C:\xampp\htdocs\PHPVC\crud-animes\database\Database.php';
class AnimeModel extends Database
{
  public $title;
  public $poster;
  public $synopsis;
  public $status;
  public $year;
  public $type;
  public $genres;

  public function __construct(
    string $title = null,
    string $synopsis = null,
    string $poster = null,
    string $status = null,
    int $year = null,
    string $type = null,
    array $genres = null,
  ) {
    $this->title = $title;
    $this->synopsis = $synopsis;
    $this->poster = $poster;
    $this->status = $status;
    $this->year = $year;
    $this->type = $type;
    $this->genres = $genres;
    parent::__construct();
  }

  public function save()
  {
    $sql = "INSERT INTO animes (title, poster_url, synopsis, status, year, type) 
    VALUES (?, ?, ?, ?, ?, ?)";
    $params = [
      $this->title,
      $this->poster,
      $this->synopsis,
      $this->status,
      $this->year,
      $this->type
    ];
    $stmt = $this->executeStatement($sql, $params);
    $stmt->closeCursor();
    $anime_id = $this->findByName($this->title);
    foreach ($this->genres as $genre) {
      $sql = "INSERT INTO anime_genres (fk_anime_id, fk_genre_id) VALUES ($anime_id, $genre)";
      $stmt = $this->executeStatement($sql);
      $stmt->closeCursor();
    }
    $this->closeConnection();
  }
  private function findByName($title): int
  {
    $sql = "SELECT anime_id FROM animes WHERE title=?";
    $stmt = $this->executeStatement($sql, array('title' => $title));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return (int) $result['anime_id'];
  }
  public function findAll(): array
  {
    $sql = "SELECT * FROM animes";
    $stmt = $this->executeStatement($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $this->closeConnection();
    return $result;
  }

  public function findById($id)
  {
    $sql = "SELECT * FROM animes WHERE anime_id=?";
    $stmt = $this->executeStatement($sql, array('anime_id' => $id));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $sql = "SELECT genre_id FROM genres
    RIGHT JOIN anime_genres
    ON anime_genres.fk_genre_id = genres.genre_id
    WHERE anime_genres.fk_anime_id = ?";
    $stmt = $this->executeStatement($sql, [$id]);
    $genreArray = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'genre_id');
    $stmt->closeCursor();
    $this->closeConnection();
    $result['genres'] = $genreArray;
    return $result;
  }

  public function findByIdAndUpdate($data)
  {
    $sql = "UPDATE animes SET 
    title = ?, 
    poster_url = ?, 
    synopsis = ?, 
    status = ?, 
    year = ?, 
    type = ? 
    WHERE anime_id = ?";

    $newData = [
      "title" => $data['title'],
      "poster_url" => $data['poster'],
      "synopsis" => $data['synopsis'],
      "status" => $data['status'],
      "year" => $data['year'],
      "type" => $data['type'],
      "anime_id" => $data['id'],
    ];
    $stmt = $this->executeStatement($sql, $newData);
    $stmt->closeCursor();
    $this->closeConnection();
  }
  public function findByIdAndDelete($id): array
  {
    $sql = "DELETE FROM animes WHERE id = ?";
    $stmt = $this->executeStatement($sql, array('id' => $id));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $this->closeConnection();
    return $result;
  }

}