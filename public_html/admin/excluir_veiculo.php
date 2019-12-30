<?php
require '../includes/core.php';

$stmt = $con->prepare("DELETE FROM veiculos WHERE id = ?");
$stmt->bindParam(1, $_POST['id']);
$stmt->execute();

header("Location: veiculos.php");