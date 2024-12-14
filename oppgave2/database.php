<?php
// database.php
class Database
{
      private $pdo;

      public function __construct()
      {
            $config = require('config.php');

            try {
                  $this->pdo = new PDO(
                        "mysql:host={$config['host']};dbname={$config['dbname']}",
                        $config['username'],
                        $config['password']
                  );
                  $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                  die('Connection failed: ' . $e->getMessage());
            }
      }

      public function query($sql, $params = [])
      {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
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
