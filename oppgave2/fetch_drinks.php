<?php
include 'Database.php';
include 'Drink.php';

$db = new Database();
$drinks = Drink::getAll($db);
echo json_encode($drinks);
