<?php
require_once 'C:\xampp\htdocs\PHPVC\crud-animes\app\Model.php';
class User extends Model
{
  public function __construct()
  {
    parent::__construct();
    $this->tableName = 'users';
    $this->fillable = [
      "username",
      "email",
      "password"
    ];
  }

  public function findById($id): array
  {
    $sql = "SELECT * FROM {$this->tableName} WHERE user_id = ?";
    $stmt = $this->executeStatement($sql, array($id));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $this->closeConnection();
    return $result;
  }
  public function findOne(array $data): array
  {
    $sql = "SELECT * FROM {$this->tableName} WHERE email = ? AND password = ?";
    $stmt = $this->executeStatement($sql, $data);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $this->closeConnection();
    return $result;
  }

  public function findByEmail($data)
  {
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $this->executeStatement($sql, $data);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $this->closeConnection();
    return $result;
  }
}