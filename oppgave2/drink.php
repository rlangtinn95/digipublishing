<?php
class Drink
{
      private $id;
      private $name;
      private $price;

      public function __construct($id = null, $name = '', $price = 0)
      {
            $this->id = $id;
            $this->name = $name;
            $this->price = $price;
      }

      // Getters and setters
      public function getId()
      {
            return $this->id;
      }

      public function setId($id)
      {
            $this->id = $id;
      }

      public function getName()
      {
            return $this->name;
      }

      public function setName($name)
      {
            $this->name = $name;
      }

      public function getPrice()
      {
            return $this->price;
      }

      public function setPrice($price)
      {
            $this->price = $price;
      }

      // Save a drink to the database
      public function save($db)
      {
            if ($this->id) {
                  // Update existing drink
                  $sql = "UPDATE drinks SET name = ?, price = ? WHERE id = ?";
                  $db->query($sql, [$this->name, $this->price, $this->id]);
            } else {
                  // Insert new drink
                  $sql = "INSERT INTO drinks (name, price) VALUES (?, ?)";
                  $db->query($sql, [$this->name, $this->price]);
                  $this->id = $db->pdo->lastInsertId();
            }
      }

      // Delete a drink
      public function delete($db)
      {
            $sql = "DELETE FROM drinks WHERE id = ?";
            $db->query($sql, [$this->id]);
      }

      // Fetch all drinks
      public static function getAll($db)
      {
            return $db->fetchAll("SELECT * FROM drinks");
      }
}
