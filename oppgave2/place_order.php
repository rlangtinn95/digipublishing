<?php
include 'Database.php';
include 'Drink.php';
include 'AddOn.php';
include 'Order.php';

$data = json_decode(file_get_contents('php://input'), true);

if (empty($data['drinks'])) {
      echo json_encode(['error' => 'No drinks selected']);
      exit;
}

$db = new Database();

// Create a new order
$order = new Order(null, $data['totalPrice']);
$order->save($db);

// Add drinks and add-ons to the order
$order->addItems($db, array_merge(
      array_map(fn($drink) => ['drink_id' => $drink['id'], 'add_on_id' => null, 'quantity' => 1], $data['drinks']),
      array_map(fn($addOn) => ['drink_id' => null, 'add_on_id' => $addOn['id'], 'quantity' => 1], $data['addOns'])
));

$response = [
      'totalPrice' => $data['totalPrice'],
      'items' => array_merge($data['drinks'], $data['addOns'])
];

echo json_encode($response);
