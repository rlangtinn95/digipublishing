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
                  // Initialize PDO connection
                  $this->pdo = new PDO(
                        "mysql:host=$this->host;dbname=$this->dbname",
                        $this->username,
                        $this->password
                  );
                  $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                  // Output error message and stop the script
                  die('Connection failed: ' . $e->getMessage());
            }
      }

      // Function to execute queries (used for SELECT, INSERT, UPDATE, DELETE)
      public function query($sql, $params = [])
      {
            if ($this->pdo) {
                  $stmt = $this->pdo->prepare($sql);
                  $stmt->execute($params);
                  return $stmt;
            }
            throw new Exception("Database connection not established.");
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

      // Public method to get PDO instance
      public function getPDO()
      {
            return $this->pdo;
      }
}
