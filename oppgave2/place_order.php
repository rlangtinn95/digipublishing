<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include necessary files
include 'database.php';
include 'drink.php';  // If you have a Drink class, include it
include 'addon.php';  // If you have an AddOn class, include it
include 'order.php';

try {
      // Get the POST data (JSON)
      $data = json_decode(file_get_contents('php://input'), true);

      if (empty($data['drinks'])) {
            // If no drinks are selected, return an error response
            echo json_encode(['error' => 'No drinks selected']);
            exit;
      }

      // Initialize database connection
      $db = new Database();

      // Create a new order
      $order = new Order(null, $data['totalPrice']);
      $order->save($db);

      // Add drinks and add-ons to the order
      $order->addItems($db, array_merge(
            array_map(fn($drink) => ['drink_id' => $drink['id'], 'add_on_id' => null, 'quantity' => 1], $data['drinks']),
            array_map(fn($addOn) => ['drink_id' => null, 'add_on_id' => $addOn['id'], 'quantity' => 1], $data['addOns'])
      ));

      // Prepare the response with the total price and ordered items
      $response = [
            'totalPrice' => $data['totalPrice'],
            'items' => array_merge($data['drinks'], $data['addOns'])
      ];

      // Send the response as JSON
      echo json_encode($response);
} catch (Exception $e) {
      // Catch any exceptions and return an error message
      echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
}
