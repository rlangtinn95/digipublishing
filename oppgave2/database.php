<?php
class Database
{
      private $host = 'localhost';
      private $dbname = 'coffee_shop';
      private $username = 'root';
      private $password = '';
      private $pdo;

      public function __construct()
      {
            try {
                  $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
                  $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                  echo 'Connection failed: ' . $e->getMessage();
            }
      }

      // Function to execute queries (used for SELECT, INSERT, UPDATE, DELETE)
      public function query($sql, $params = [])
      {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
      }

      // Function to fetch all results
      public function fetchAll($sql, $params = [])
      {
            $stmt = $this->query($sql, $params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }

      // Function to fetch a single result
      public function fetchOne($sql, $params = [])
      {
            $stmt = $this->query($sql, $params);
            return $stmt->fetch(PDO::FETCH_ASSOC);
      }
}
