<?php

require '../includes/core.php';


$sql = "SELECT veiculos.*, marcas.nome AS nome_marca, modelos.nome AS nome_modelo
FROM veiculos
INNER JOIN marcas ON marcas.id = veiculos.marca_id
INNER JOIN modelos ON modelos.id = veiculos.modelo_id
ORDER BY marcas.nome ASC, modelos.nome ASC";

$stmt = $con->prepare($sql);
$stmt->execute();
$veiculos = $stmt->fetchAll();

require 'templates/veiculos.template.php';