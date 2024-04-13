<?php
require_once 'C:\xampp\htdocs\PHPVC\crud-animes\config\config.php';
class Database
{
  private static $connection = null;
  public function __construct()
  {
    try {
      $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE_NAME;
      Database::$connection = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
      Database::$connection->exec('set names utf8');
    } catch (PDOException $e) {
      throw new Exception("Could not connect to database: " . $e->getMessage());
    }
  }
  public static function executeStatement($query = "", $params = [])
  {
    try {
      $stmt = Database::$connection->prepare($query);

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

  public static function closeConnection()
  {
    Database::$connection = null;
  }
}