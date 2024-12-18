<?php
class Order
{
      private $id;
      private $totalPrice;
      private $createdAt;

      public function __construct($id = null, $totalPrice = 0)
      {
            $this->id = $id;
            $this->totalPrice = $totalPrice;
            $this->createdAt = date('Y-m-d H:i:s');
      }

      public function getId()
      {
            return $this->id;
      }

      public function setId($id)
      {
            $this->id = $id;
      }

      public function getTotalPrice()
      {
            return $this->totalPrice;
      }

      public function setTotalPrice($totalPrice)
      {
            $this->totalPrice = $totalPrice;
      }

      public function getCreatedAt()
      {
            return $this->createdAt;
      }

      public function save($db, $details = null)
      {
            $sql = "INSERT INTO orders (total_price, details) VALUES (?, ?)";
            $db->query($sql, [$this->totalPrice, $details]);
            $this->id = $db->getPDO()->lastInsertId();
      }


      public function addItems($db, $items)
      {
            foreach ($items as $item) {
                  $sql = "INSERT INTO order_items (order_id, drink_id, add_on_id, quantity) VALUES (?, ?, ?, ?)";
                  $db->query($sql, [$this->id, $item['drink_id'], $item['add_on_id'], $item['quantity']]);
            }
      }
}
