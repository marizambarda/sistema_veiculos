<?php
require '../includes/core.php';


$sql = "SELECT modelos.*, marcas.nome AS nome_marca
FROM modelos
INNER JOIN marcas ON marcas.id = modelos.marca_id
ORDER BY marcas.nome ASC, modelos.nome ASC";

$stmt = $con->prepare($sql);
$stmt->execute();
$modelos = $stmt->fetchAll();

require 'templates/modelos.template.php';
