<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'database.php';
include 'drink.php';
include 'addon.php';
include 'order.php';

try {
      // Decode the incoming JSON request
      $data = json_decode(file_get_contents('php://input'), true);

      // Validation: Check if drinks and add-ons are provided
      if (empty($data['drinks']) && empty($data['addOns'])) {
            echo json_encode(['error' => 'Ordren må inneholde minst én drikk eller tillegg.']);
            exit;
      }

      // Validate each drink and add-on to make sure it has an ID
      foreach ($data['drinks'] as $drink) {
            if (empty($drink['id'])) {
                  echo json_encode(['error' => 'Drikk-ID mangler.']);
                  exit;
            }
      }

      foreach ($data['addOns'] as $addOn) {
            if (empty($addOn['id'])) {
                  echo json_encode(['error' => 'Tillegg-ID mangler.']);
                  exit;
            }
      }

      // Create a new database connection
      $db = new Database();

      // Fetch drink names and prices from the database
      $drinkDetails = [];
      foreach ($data['drinks'] as $drink) {
            $sql = "SELECT id, name, price FROM drinks WHERE id = ?";
            $result = $db->query($sql, [$drink['id']])->fetch(PDO::FETCH_ASSOC);  // Fetch the result as an associative array
            if ($result) {
                  $drinkDetails[] = [
                        'id' => $result['id'],
                        'name' => $result['name'],
                        'price' => $result['price'],
                  ];
            }
      }

      // Fetch add-on names and prices from the database
      $addOnDetails = [];
      foreach ($data['addOns'] as $addOn) {
            $sql = "SELECT id, name, price FROM add_ons WHERE id = ?";
            $result = $db->query($sql, [$addOn['id']])->fetch(PDO::FETCH_ASSOC);  // Fetch the result as an associative array
            if ($result) {
                  $addOnDetails[] = [
                        'id' => $result['id'],
                        'name' => $result['name'],
                        'price' => $result['price'],
                  ];
            }
      }

      // Combine the drink and add-on details into one array for storage
      $orderDetails = [
            'drinks' => $drinkDetails,
            'addOns' => $addOnDetails,
      ];

      $orderDetailsJson = json_encode($orderDetails); // Encode with names

      // Create the Order object and save it along with the order details
      $order = new Order(null, $data['totalPrice']);
      $order->save($db, $orderDetailsJson);  // Pass the details when saving

      // Add the items to the order
      $order->addItems($db, array_merge(
            array_map(fn($drink) => ['drink_id' => $drink['id'], 'add_on_id' => null, 'quantity' => 1], $data['drinks']),
            array_map(fn($addOn) => ['drink_id' => null, 'add_on_id' => $addOn['id'], 'quantity' => 1], $data['addOns'])
      ));

      // Return the response with the total price and the items
      $response = [
            'totalPrice' => $data['totalPrice'],
            'items' => array_merge($drinkDetails, $addOnDetails)
      ];

      echo json_encode($response);
} catch (Exception $e) {
      echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
}
