<?php
// Database connection details
$host = 'localhost';
$dbname = 'coffee_shop';
$username = 'root';
$password = 'root';

try {
      // Create a new PDO instance
      $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

      // Set PDO attributes for error handling
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      echo "Connection successful!";
} catch (PDOException $e) {
      // If an error occurs, output the error message
      echo "Connection failed: " . $e->getMessage();
}
