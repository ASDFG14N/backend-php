<?php
require_once 'C:\xampp\htdocs\PHPVC\crud-animes\database\Database.php';
abstract class Model extends Database
{
  protected string $tableName;
  protected string $tableId;
  protected $fillable = [];
  public function __construct()
  {
    parent::__construct();
    $this->tableName = $this->getTableName();
  }
  abstract protected function getTableName(): string;

  public function save(array $data)
  {
    $filteredData = array_intersect_key($data, array_flip($this->fillable));
    $columns = implode(', ', array_keys($filteredData));
    $placeholders = implode(', ', array_fill(0, count($filteredData), '?'));
    $sql = "INSERT INTO {$this->tableName} ({$columns}) VALUES ({$placeholders})";
    $stmt = $this->executeStatement($sql, array_values($filteredData));
    $stmt->closeCursor();
    $this->closeConnection();
  }
  public function findAll(): array
  {
    $sql = "SELECT * FROM {$this->tableName}";
    $stmt = $this->executeStatement($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $this->closeConnection();
    return $result;
  }

  public function findByName(string $title): int
  {
    $sql = "SELECT {$this->tableId} FROM {$this->tableName} WHERE title=?";
    $stmt = $this->executeStatement($sql, array('title' => $title));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return (int) $result["{$this->tableId}"];
  }

  public function findOne(array $data): array
  {
    $sql = "SELECT * FROM {$this->tableName} 
              WHERE email = ? AND password = ?";
    $stmt = $this->executeStatement($sql, $data);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $this->closeConnection();
    return $result;
  }

  public function findByIdAndDelete(int $id): array
  {
    $sql = "DELETE FROM {$this->tableName} WHERE id = ?";
    $stmt = $this->executeStatement($sql, array('id' => $id));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $this->closeConnection();
    return $result;
  }
}