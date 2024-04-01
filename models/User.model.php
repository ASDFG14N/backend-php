<?php
require_once 'C:\xampp\htdocs\PHPVC\crud-animes\database\Database.php';
class User extends Database
{
  private $username;
  private $email;
  private $password;

  public function __construct(string $username = null, string $email = null, string $password = null)
  {
    $this->username = $username;
    $this->email = $email;
    $this->password = $password;
    parent::__construct();
  }

  public function save()
  {
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $params = [
      $this->username,
      $this->email,
      $this->password,
    ];
    $stmt = $this->executeStatement($sql, $params);
    $stmt->closeCursor();
    $this->closeConnection();
  }

  public function findOne($data)
  {
    $sql = "SELECT * FROM users 
              WHERE email = ? AND password = ?";
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