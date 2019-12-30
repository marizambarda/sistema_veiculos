<?php
require '../includes/core.php';

$veiculo_id = intval($_GET['id']);

$stmt = $con->prepare("SELECT * FROM veiculos WHERE id = ? ");
$stmt->bindParam(1, $veiculo_id);
$stmt->execute();
$veiculo = $stmt->fetch();

if($veiculo == NULL){
  header("Location: veiculos.php");
  exit();
}

$erros = [];
$sucesso = false;

if ($_SERVER['REQUEST_METHOD'] == "POST"){
  $formatosPermitidos = array("png", "jpeg", "jpg", "gif");
  $quantidadeArquivos = count($_FILES['imagens']['name']);

  $pasta = "../uploads/$veiculo_id";
  if(!file_exists($pasta)){
    mkdir($pasta);
  }

  $stmt=$con->prepare("SELECT IFNULL(MAX(ordem), 0) AS ultima_ordem FROM imagens_veiculos WHERE veiculo_id = ?");
  $stmt->bindParam(1, $veiculo_id);
  $stmt->execute();

  $resultado = $stmt->fetch();
  $ordem = intval($resultado['ultima_ordem']);

  for($i = 0; $i < $quantidadeArquivos; $i++){
    $extensao = pathinfo($_FILES['imagens']['name'][$i], PATHINFO_EXTENSION);
    $nome = escape($_FILES['imagens']['name'][$i]);
    if(in_array($extensao, $formatosPermitidos)){
      $temporario = $_FILES['imagens']['tmp_name'][$i];
      $nomeGerado = uniqid().".$extensao";

      if(move_uploaded_file($temporario, $pasta."/$nomeGerado")){
        $stmt = $con->prepare("INSERT INTO imagens_veiculos (veiculo_id, ordem, nome_arquivo) VALUES (?, ?, ?)");

        $ordem++;
        $stmt->bindParam(1, $veiculo_id);
        $stmt->bindParam(2, $ordem);
        $stmt->bindParam(3, $nomeGerado);
        $stmt->execute();

        $sucesso = true;
      } else{
        $erros[] = "Não foi possivel fazer upload do arquivo $nome";
      }
    } else{
      $erros[] = "A imagem $nome está com formato inválido";
    }
  }
  //var_dump($sucesso, $erros);


  //var_dump($_FILES['imagens']);
}

$stmt = $con->prepare("SELECT * FROM imagens_veiculos WHERE veiculo_id = ? ORDER BY ordem ASC");
$stmt->bindParam(1, $veiculo_id);
$stmt->execute();
$imagens_veiculos = $stmt->fetchAll();



require 'templates/imagens-veiculo.template.php';