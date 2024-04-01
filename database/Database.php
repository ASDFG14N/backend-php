<?php
require_once 'C:\xampp\htdocs\PHPVC\crud-animes\config\config.php';
class Database
{
  protected $connection = null;
  public function __construct()
  {
    try {
      $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE_NAME;
      $this->connection = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
      $this->connection->exec('set names utf8');
    } catch (PDOException $e) {
      throw new Exception("Could not connect to database: " . $e->getMessage());
    }
  }
  public function executeStatement($query = "", $params = [])
  {
    try {
      $stmt = $this->connection->prepare($query);

      if ($stmt === false) {
        throw new Exception("Unable to prepare statement: " . $query);
      }

      if ($params) {
        $index = 1;
        foreach ($params as $value) {
          $stmt->bindValue($index++, $value);
        }
      }
      $stmt->execute();
      return $stmt;
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

  public function closeConnection()
  {
    $this->connection = null;
  }
}