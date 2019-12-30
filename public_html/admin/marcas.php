<?php
require "../includes/core.php";

$stmt = $con->prepare("SELECT * FROM marcas ORDER BY nome");
$stmt->execute();
$marcas = $stmt->fetchAll();

require "templates/marcas.template.php";