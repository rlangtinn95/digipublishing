<?php
include 'Database.php';
include 'AddOn.php';

$db = new Database();
$addOns = AddOn::getAll($db);
echo json_encode($addOns);
