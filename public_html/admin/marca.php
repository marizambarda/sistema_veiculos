<?php
require '../includes/core.php';

if (isset($_GET['id'])){
  $modo = "edit";
  $marca_id = $_GET['id'];
  $marca_statement = $con->prepare("SELECT * FROM marcas WHERE id = ?");
  $marca_statement->bindParam(1, $marca_id);
  $marca_statement->execute();
  $marca = $marca_statement->fetch();

  $nome = $marca['nome'];
} else{
  $modo = "create";
  $nome = "";
 }

$erros = array();

if ($_SERVER['REQUEST_METHOD'] == "POST"){
  $nome = $_POST['nome'];

  if ($nome == "") {
    $erros[] = "Marca precisa ser preenchida";
  }

  if (count($erros) == 0) {
    if($modo == "create"){
      $marca_statement = $con->prepare("INSERT INTO marcas (nome) VALUES (?)");
      $marca_statement->bindParam(1, $nome);
      $marca_statement->execute();
    } else{
      $marca_statement = $con->prepare("UPDATE marcas SET nome = ? WHERE id = ?");
      $marca_statement->bindParam(1, $nome);
      $marca_statement->bindParam(2, $marca_id);
      $marca_statement->execute();
    }
    header("Location: marcas.php");
    exit;
  }
}

require 'templates/marca.template.php';