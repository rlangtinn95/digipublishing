<?php
class AddOn
{
      private $id;
      private $name;
      private $price;
      private $isFree;

      public function __construct($id = null, $name = '', $price = 0, $isFree = false)
      {
            $this->id = $id;
            $this->name = $name;
            $this->price = $price;
            $this->isFree = $isFree;
      }

      //getter
      public function getId()
      {
            return $this->id;
      }

      //setter
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

      public function getIsFree()
      {
            return $this->isFree;
      }

      public function setIsFree($isFree)
      {
            $this->isFree = $isFree;
      }

      public function save($db)
      {
            if ($this->id) {
                  //updates existing add-on
                  $sql = "UPDATE add_ons SET name = ?, price = ?, is_free = ? WHERE id = ?";
                  $db->query($sql, [$this->name, $this->price, $this->isFree, $this->id]);
            } else {
                  //inserts the new add-on
                  $sql = "INSERT INTO add_ons (name, price, is_free) VALUES (?, ?, ?)";
                  $db->query($sql, [$this->name, $this->price, $this->isFree]);
                  $this->id = $db->pdo->lastInsertId();
            }
      }

      //deletes the add-on
      public function delete($db)
      {
            $sql = "DELETE FROM add_ons WHERE id = ?";
            $db->query($sql, [$this->id]);
      }

      //gets all the add-ons
      public static function getAll($db)
      {
            return $db->fetchAll("SELECT * FROM add_ons");
      }
}
