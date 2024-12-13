<?php
include 'database.php';
include 'drink.php';

$db = new Database();
$drinks = Drink::getAll($db);
echo json_encode($drinks);
