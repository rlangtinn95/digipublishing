<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'database.php';
include 'drink.php';
include 'addon.php';
include 'order.php';

try {
      //crud
      $method = $_SERVER['REQUEST_METHOD'];

      if ($method == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            if (empty($data['drinks']) && empty($data['addOns'])) {
                  echo json_encode(['error' => 'Ordren må inneholde minst en drikk eller tillegg.']);
                  exit;
            }

            foreach ($data['drinks'] as $drink) {
                  if (empty($drink['id'])) {
                        echo json_encode(['error' => 'Drikke-ID mangler.']);
                        exit;
                  }
            }

            foreach ($data['addOns'] as $addOn) {
                  if (empty($addOn['id'])) {
                        echo json_encode(['error' => 'Tillegg-ID mangler.']);
                        exit;
                  }
            }

            $db = new Database();

            $drinkDetails = [];
            foreach ($data['drinks'] as $drink) {
                  $sql = "SELECT id, name, price FROM drinks WHERE id = ?";
                  $result = $db->query($sql, [$drink['id']])->fetch(PDO::FETCH_ASSOC);
                  if ($result) {
                        $drinkDetails[] = [
                              'id' => $result['id'],
                              'name' => $result['name'],
                              'price' => $result['price'],
                        ];
                  }
            }

            $addOnDetails = [];
            foreach ($data['addOns'] as $addOn) {
                  $sql = "SELECT id, name, price FROM add_ons WHERE id = ?";
                  $result = $db->query($sql, [$addOn['id']])->fetch(PDO::FETCH_ASSOC);
                  if ($result) {
                        $addOnDetails[] = [
                              'id' => $result['id'],
                              'name' => $result['name'],
                              'price' => $result['price'],
                        ];
                  }
            }

            $orderDetails = [
                  'drinks' => $drinkDetails,
                  'addOns' => $addOnDetails,
            ];

            $orderDetailsJson = json_encode($orderDetails);
            $order = new Order(null, $data['totalPrice']);
            $order->save($db, $orderDetailsJson);
            $order->addItems($db, array_merge(
                  array_map(fn($drink) => ['drink_id' => $drink['id'], 'add_on_id' => null, 'quantity' => 1], $data['drinks']),
                  array_map(fn($addOn) => ['drink_id' => null, 'add_on_id' => $addOn['id'], 'quantity' => 1], $data['addOns'])
            ));

            $response = [
                  'totalPrice' => $data['totalPrice'],
                  'items' => array_merge($drinkDetails, $addOnDetails),
            ];

            echo json_encode($response);
      } elseif ($method == 'PUT') {
            if (empty($_GET['id'])) {
                  echo json_encode(['error' => 'Order ID is required.']);
                  exit;
            }

            $orderId = $_GET['id'];
            $data = json_decode(file_get_contents('php://input'), true);

            if (empty($data['drinks']) && empty($data['addOns'])) {
                  echo json_encode(['error' => 'Ordren må inneholde minst en drikk eller tillegg.']);
                  exit;
            }

            foreach ($data['drinks'] as $drink) {
                  if (empty($drink['id'])) {
                        echo json_encode(['error' => 'Drikke-ID mangler.']);
                        exit;
                  }
            }

            foreach ($data['addOns'] as $addOn) {
                  if (empty($addOn['id'])) {
                        echo json_encode(['error' => 'Tillegg-ID mangler.']);
                        exit;
                  }
            }

            $db = new Database();
            $sql = "UPDATE orders SET total_price = ? WHERE id = ?";
            $db->query($sql, [$data['totalPrice'], $orderId]);
            echo json_encode(['message' => 'Order updated successfully']);
      } elseif ($method == 'DELETE') {
            if (empty($_GET['id'])) {
                  echo json_encode(['error' => 'Order ID is required.']);
                  exit;
            }

            $orderId = $_GET['id'];

            $db = new Database();
            $sql = "DELETE FROM order_items WHERE order_id = ?";
            $db->query($sql, [$orderId]);
            $sql = "DELETE FROM orders WHERE id = ?";
            $db->query($sql, [$orderId]);

            echo json_encode(['message' => 'Order deleted successfully']);
      }
} catch (Exception $e) {
      echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
}
