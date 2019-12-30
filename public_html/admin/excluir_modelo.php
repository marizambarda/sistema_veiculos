<?php
require '../includes/core.php';

$stmt = $con->prepare("DELETE FROM modelos WHERE id = ?");
$stmt->bindParam(1, $_POST['id']);
$stmt->execute();

header("Location: modelos.php");