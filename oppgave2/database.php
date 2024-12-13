<?php
class Database
{
      private $host = 'localhost';
      private $dbname = 'coffee_shop';
      private $username = 'root';
      private $password = 'root';
      private $pdo;

      public function __construct()
      {
            try {
                  $this->pdo = new PDO(
                        "mysql:host=$this->host;dbname=$this->dbname",
                        $this->username,
                        $this->password
                  );
                  $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                  die('Connection failed: ' . $e->getMessage());
            }
      }

      public function query($sql, $params = [])
      {
            if ($this->pdo) {
                  $stmt = $this->pdo->prepare($sql);
                  $stmt->execute($params);
                  return $stmt;
            }
            throw new Exception("Database connection not established.");
      }

      public function fetchAll($sql, $params = [])
      {
            $stmt = $this->query($sql, $params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }

      public function fetchOne($sql, $params = [])
      {
            $stmt = $this->query($sql, $params);
            return $stmt->fetch(PDO::FETCH_ASSOC);
      }

      public function getPDO()
      {
            return $this->pdo;
      }
}
