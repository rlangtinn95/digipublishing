<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'database.php';
include 'drink.php';
include 'addon.php';
include 'order.php';

try {
      $data = json_decode(file_get_contents('php://input'), true);
      if (empty($data['drinks'])) {
            // If no drinks are selected, return an error response
            echo json_encode(['error' => 'No drinks selected']);
            exit;
      }

      $db = new Database();
      $order = new Order(null, $data['totalPrice']);
      $order->save($db);

      $order->addItems($db, array_merge(
            array_map(fn($drink) => ['drink_id' => $drink['id'], 'add_on_id' => null, 'quantity' => 1], $data['drinks']),
            array_map(fn($addOn) => ['drink_id' => null, 'add_on_id' => $addOn['id'], 'quantity' => 1], $data['addOns'])
      ));

      $response = [
            'totalPrice' => $data['totalPrice'],
            'items' => array_merge($data['drinks'], $data['addOns'])
      ];

      echo json_encode($response);
} catch (Exception $e) {
      echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
}
