<?php
require '../includes/core.php';

$stmt = $con->prepare("SELECT * FROM marcas ORDER BY nome ASC ");
$stmt->execute();
$marcas = $stmt->fetchAll();


if (isset($_GET['id'])){
  $modo = "edit";
  $modelo_id = $_GET['id'];
  $modelo_statement = $con->prepare("SELECT * FROM modelos WHERE id = ?");
  $modelo_statement->bindParam(1, $modelo_id);
  $modelo_statement->execute();
  $modelo = $modelo_statement->fetch();

  $marca_id = $modelo['marca_id'];
  $nome = $modelo['nome'];
} else{
  $modo = "create";
  $nome = "";
  $marca_id = "";
}

$erros = array();

if ($_SERVER['REQUEST_METHOD'] == "POST"){
  $marca_id = $_POST['marca_id'];
  $nome = $_POST['nome'];

  if ($marca_id == "") {
    $erros[] = "Marca precisa ser selecionada";
  }
  if ($nome == "") {
    $erros[] = "Modelo precisa ser preenchido";
  }

  if (count($erros) == 0) {
    if($modo == "create"){
      $modelo_statement = $con->prepare("INSERT INTO modelos (nome, marca_id) VALUES (?, ?)");
      $modelo_statement->bindParam(1, $nome);
      $modelo_statement->bindParam(2, $marca_id);
      $modelo_statement->execute();
    } else{
      $modelo_statement = $con->prepare("UPDATE modelos SET nome = ?, marca_id = ? WHERE id = ?");
      $modelo_statement->bindParam(1, $nome);
      $modelo_statement->bindParam(2, $marca_id);
      $modelo_statement->bindParam(3, $modelo_id);
      $modelo_statement->execute();
    }
    header("Location: modelos.php");
    exit;
  }
}

require 'templates/modelo.template.php';