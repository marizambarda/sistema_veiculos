<?php
require '../includes/core.php';

$stmt = $con->prepare("SELECT * FROM modelos WHERE marca_id = ? ORDER BY nome ASC ");
$stmt->bindParam(1, $_GET['id']);
$stmt->execute();
$modelos = $stmt->fetchAll();

$json = json_encode($modelos);
header("Content-Type: application/json");
echo $json; 