<?php
include 'database.php';
include 'addon.php';

$db = new Database();
$addOns = AddOn::getAll($db);
echo json_encode($addOns);
