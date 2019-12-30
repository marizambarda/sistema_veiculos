<?php
require '../includes/core.php';

$stmt = $con->prepare("SELECT * FROM marcas ORDER BY nome ASC ");
$stmt->execute();
$marcas = $stmt->fetchAll();

$cores = array("Branco", "Preto", "Azul", "Amarelo", "Vermelho", "Prata", "Verde");

if (isset($_GET['id'])){
  $modo = "edit";
  $veiculo_id = $_GET['id'];
  $veiculo_statement = $con->prepare("SELECT * FROM veiculos WHERE id = ?");
  $veiculo_statement->bindParam(1, $veiculo_id);
  $veiculo_statement->execute();
  $veiculo = $veiculo_statement->fetch();

  $marca_id = $veiculo['marca_id'];
  $modelo_id = $veiculo['modelo_id'];
  $descricao = $veiculo['descricao'];
  $ano_modelo = $veiculo['ano_modelo'];
  $cor = $veiculo['cor'];

  $stmt = $con->prepare("SELECT * FROM modelos WHERE marca_id = ? ORDER BY nome ASC ");
  $stmt->bindParam(1, $marca_id);
  $stmt->execute();
  $modelos = $stmt->fetchAll();

} else{
  $modo = "create";
  $modelos = array();
  $marca_id = "";
  $modelo_id = "";
  $descricao = "";
  $ano_modelo = "";
  $cor = "";
}

$erros = array();

if ($_SERVER['REQUEST_METHOD'] == "POST"){
  $marca_id = $_POST['marca_id'];
  $modelo_id = $_POST['modelo_id'];
  $descricao = $_POST['descricao'];
  $ano_modelo = $_POST['ano_modelo'];
  $cor = $_POST['cor'];

  if ($marca_id == "") {
    $erros[] = "Marca precisa ser selecionada";
  } else{
    $stmt = $con->prepare("SELECT * FROM modelos WHERE marca_id = ? ORDER BY nome ASC ");
    $stmt->bindParam(1, $marca_id);
    $stmt->execute();
    $modelos = $stmt->fetchAll();
  }

  if ($modelo_id == "") {
    $erros[] = "Modelo precisa ser preenchido";
  }

  if ($descricao == "") {
    $erros[] = "Descrição precisa ser preenchido";
  }

  if ($ano_modelo == "") {
    $erros[] = "Ano/Modelo precisa ser preenchido";
  }
  else if (validarAnoModelo($ano_modelo) == 0) {
    $erros[] = "Ano/Modelo inválido. Por favor, use o formato 2015/2015";
  }

  if ($cor == "") {
    $erros[] = "Cor precisa ser preenchida";
  }

  if (count($erros) == 0) {
    if($modo == "create"){
      $veiculo_statement = $con->prepare("INSERT INTO veiculos (marca_id, modelo_id, descricao, ano_modelo, cor) VALUES (?, ?, ?, ?, ?)");
      $veiculo_statement->bindParam(1, $marca_id);
      $veiculo_statement->bindParam(2, $modelo_id);
      $veiculo_statement->bindParam(3, $descricao);
      $veiculo_statement->bindParam(4, $ano_modelo);
      $veiculo_statement->bindParam(5, $cor);
      $veiculo_statement->execute();
      $veiculo_id = $con->lastInsertId();
    } else{
      $veiculo_statement = $con->prepare("UPDATE veiculos SET marca_id = ?, modelo_id = ?, descricao = ?, ano_modelo = ?, cor = ? WHERE id = ?");
      $veiculo_statement->bindParam(1, $marca_id);
      $veiculo_statement->bindParam(2, $modelo_id);
      $veiculo_statement->bindParam(3, $descricao);
      $veiculo_statement->bindParam(4, $ano_modelo);
      $veiculo_statement->bindParam(5, $cor);
      $veiculo_statement->bindParam(6, $veiculo_id);
      $veiculo_statement->execute();
    }
    header("Location: imagens-veiculo.php?id=$veiculo_id");
    exit;
  }
}

require 'templates/veiculo.template.php';