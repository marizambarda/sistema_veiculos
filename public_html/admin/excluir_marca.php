<?php
require '../includes/core.php';

$stmt = $con->prepare("DELETE FROM marcas WHERE id = ?");
$stmt->bindParam(1, $_POST['id']);
$stmt->execute();

header("Location: marcas.php");