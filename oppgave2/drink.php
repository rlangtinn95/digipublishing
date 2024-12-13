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

      public function save($db)
      {
            if ($this->id) {
                  $sql = "UPDATE drinks SET name = ?, price = ? WHERE id = ?";
                  $db->query($sql, [$this->name, $this->price, $this->id]);
            } else {
                  $sql = "INSERT INTO drinks (name, price) VALUES (?, ?)";
                  $db->query($sql, [$this->name, $this->price]);
                  $this->id = $db->pdo->lastInsertId();
            }
      }

      public function delete($db)
      {
            $sql = "DELETE FROM drinks WHERE id = ?";
            $db->query($sql, [$this->id]);
      }

      public static function getAll($db)
      {
            return $db->fetchAll("SELECT * FROM drinks");
      }
}
