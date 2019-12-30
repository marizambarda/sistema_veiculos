<?php
require '../includes/core.php';

/* Este arquivo trata de realizar operações sobre a imagem de um veículo.
 * Ele recebe através de uma requisição post dois campos: id e operação. 
 * O campo "id" é o id da foto do veículo que estamos querendo mexer.
 * O campo "operacao" contém qual operação estamos querendo realizar, e pode ser: 
 * deletar, aumentar-ordem ou diminuir-ordem.
 */
$veiculo_foto_id = $_POST['id']; 
$operacao = $_POST['operacao'];

// Aqui buscamos os dados da imagem que queremos mexer.
$stmt = $con->prepare("SELECT * FROM imagens_veiculos WHERE id = ?");
$stmt->bindParam(1, $veiculo_foto_id);
$stmt->execute();
$veiculo_foto = $stmt->fetch();

/* Operação aumentar-ordem
 * Quando essa operação é chamada nós aumentamos a ordem da imagem selecionada e
 * diminuímos a ordem da próxima imagem em relação a imagem chamada, trocando elas
 * de lugar.
 * Porém, se a imagem selecionada já for a última, ela passará a ser a primeira imagem.   
*/
if($operacao == "aumentar-ordem"){

  // Aqui buscamos a imagem com a maior ordem dentre as imagens do mesmo veículo.
  $stmt = $con->prepare("SELECT MAX(ordem) AS maior_ordem FROM imagens_veiculos WHERE veiculo_id = ? ");
  $stmt->bindParam(1, $veiculo_foto['veiculo_id']);
  $stmt->execute();
  $resultado = $stmt->fetch();

  // Verificamos se a imagem selecionada já não é a última(maior ordem). 
  if($resultado['maior_ordem'] !== $veiculo_foto['ordem']){

    /*
     * Esta query está diminuindo a ordem da próxima imagem em relação à selecionada.
     * Por exemplo, se tivermos as seguintes imagens:
     * id = 70, ordem = 1
     * id = 71, ordem = 2
     * id = 72, ordem = 3
     * ...e quisermos aumentar a ordem da imagem com id 70, esta query irá diminuir
     * a ordem da imagem com id 71 para 1.
     * Nesse momento, as imagens ficarão assim:
     * id = 70, ordem = 1
     * id = 71, ordem = 1
     * id = 72, ordem = 3
     * Na próxima query, iremos tratar de aumentar a ordem da imagem 70.
     */
    $stmt = $con->prepare("UPDATE imagens_veiculos SET ordem = ordem-1 WHERE veiculo_id = ? AND ordem = ?");
    $stmt->bindParam(1, $veiculo_foto['veiculo_id']);
    $proxima_ordem = intval($veiculo_foto['ordem'])+1;
    $stmt->bindParam(2, $proxima_ordem);
    $stmt->execute();

    /*
     * Esta query irá aumentar a ordem da imagem selecionada. Seguindo o exemplo do
     * comentário anterior, nossas fotos ficariam assim:
     * id = 70, ordem = 2
     * id = 71, ordem = 1
     * id = 72, ordem = 3
     */
    $stmt = $con->prepare("UPDATE imagens_veiculos SET ordem = ordem+1 WHERE id = ?");
    $stmt->bindParam(1,$veiculo_foto_id);
    $stmt->execute();
  } else {
    /*
     * Esta parte do código trata do caso onde a imagem selecionada já é a última,
     * e deve ser transformada em primeira.
     *
     * Por exemplo, se tivermos as seguintes imagens:
     * id = 70, ordem = 1
     * id = 71, ordem = 2
     * id = 72, ordem = 3
     * Cairemos nesse "else" caso a imagem selecionada seja a imagem com id 72.
     */

    /*
     * Esta primeira query irá aumentar a ordem de todas as imagens do veículo
     * da imagem selecionada.
     * id = 70, ordem = 2
     * id = 71, ordem = 3
     * id = 72, ordem = 4
     *
     * Agora precisamos fazer com que a imagem 72 vire a primeira. Para isso,
     * transformaremos sua ordem para 1 na próxima query.
     */
    $stmt = $con->prepare("UPDATE imagens_veiculos SET ordem = ordem+1 WHERE veiculo_id = ?");
    $stmt->bindParam(1, $veiculo_foto['veiculo_id']);
    $stmt->execute();

    // Esta query transforma o veículo selecionado em ordem 1.
    $stmt = $con->prepare("UPDATE imagens_veiculos SET ordem = 1 WHERE id = ?");
    $stmt->bindParam(1,$veiculo_foto_id);
    $stmt->execute(); 
  }
}

/* Operação diminuir-ordem
 * Quando essa operação é chamada nós diminuimos a ordem da imagem selecionada e
 * aumentarmos a ordem da imagem anterior em relação a imagem chamada, trocando elas
 * de lugar.
 * Porém, se a imagem selecionada já for a primeira, ela passará a ser a última imagem.   
 */
if($operacao == "diminuir-ordem"){

  // Aqui buscamos a imagem com a menor ordem dentre as imagens do mesmo veículo.
  $stmt = $con->prepare("SELECT MIN(ordem) AS menor_ordem FROM imagens_veiculos WHERE veiculo_id = ? ");
  $stmt->bindParam(1, $veiculo_foto['veiculo_id']);
  $stmt->execute();
  $resultado = $stmt->fetch();

  // Verificamos se a imagem selecionada já não é a primeira (menor ordem). 
  if($resultado['menor_ordem'] !== $veiculo_foto['ordem']){

    /*
     * Esta query está aumentando a ordem da imagem anterior em relação à selecionada.
     * Por exemplo, se tivermos as seguintes imagens:
     * id = 70, ordem = 1
     * id = 71, ordem = 2
     * id = 72, ordem = 3
     * ...e quisermos diminuir a ordem da imagem com id 72, esta query irá diminuir
     * a ordem da imagem com id 72 para 2.
     * Nesse momento, as imagens ficarão assim:
     * id = 70, ordem = 1
     * id = 71, ordem = 3
     * id = 72, ordem = 3
     * Na próxima query, iremos tratar de diminuir a ordem da imagem 72.
     */
    $stmt = $con->prepare("UPDATE imagens_veiculos SET ordem = ordem+1 WHERE veiculo_id = ? AND ordem = ?");
    $stmt->bindParam(1, $veiculo_foto['veiculo_id']);
    $ordem_anterior = intval($veiculo_foto['ordem'])-1;
    $stmt->bindParam(2, $ordem_anterior);
    $stmt->execute();

    /*
     * Esta query irá diminuir a ordem da imagem selecionada. Seguindo o exemplo do
     * comentário anterior, nossas fotos ficariam assim:
     * id = 70, ordem = 1
     * id = 71, ordem = 3
     * id = 72, ordem = 2
     */
    $stmt = $con->prepare("UPDATE imagens_veiculos SET ordem = ordem-1 WHERE id = ?");
    $stmt->bindParam(1,$veiculo_foto_id);
    $stmt->execute();
  } else {
    /*
     * Esta parte do código trata do caso onde a imagem selecionada já é a primeira,
     * e deve ser transformada em última.
     *
     * Por exemplo, se tivermos as seguintes imagens:
     * id = 70, ordem = 1
     * id = 71, ordem = 2
     * id = 72, ordem = 3
     * Cairemos nesse "else" caso a imagem selecionada seja a imagem com id 70.
     */

    /**
     * Aqui, buscamos a ordem máxima das imagens desse veículo no banco pois
     * vamos precisar depois. Nesse caso, é 3
     */
    $stmt = $con->prepare("SELECT MAX(ordem) AS maior_ordem FROM imagens_veiculos WHERE veiculo_id = ? ");
    $stmt->bindParam(1, $veiculo_foto['veiculo_id']);
    $stmt->execute();
    $resultado = $stmt->fetch();

    /*
     * Esta query irá diminuir a ordem de todas as imagens do veículo
     * da imagem selecionada.
     * id = 70, ordem = 0
     * id = 71, ordem = 1
     * id = 72, ordem = 2
     *
     * Agora precisamos fazer com que a imagem 70 vire a última. Para isso,
     * transformaremos sua ordem para 3 (ordem máxima) na próxima query.
     */
    $stmt = $con->prepare("UPDATE imagens_veiculos SET ordem = ordem-1 WHERE veiculo_id = ?");
    $stmt->bindParam(1, $veiculo_foto['veiculo_id']);
    $stmt->execute();

    // Aqui transformamos essa imagem na última da lista.
    $stmt = $con->prepare("UPDATE imagens_veiculos SET ordem = ?  WHERE id = ?");
    $stmt->bindParam(1, $resultado['maior_ordem']);
    $stmt->bindParam(2, $veiculo_foto_id);
    $stmt->execute(); 
  }
}

/* Operação delete
 * Esta opereção deleta a imagem selecionada e atualiza a ordem das próximas imagens. 
 * Por exemplo, supondo que temos as seguintes imagens:    
 * id = 70, ordem = 1
 * id = 71, ordem = 2
 * id = 72, ordem = 3
 * id = 73, ordem = 4
 * E queiramos excluir a imagem com id = 71. Após essa operação as imagens ficarão assim:
 * id = 70, ordem = 1
 * id = 72, ordem = 2
 * id = 73, ordem = 3
 */
if($operacao == "delete"){
  $stmt = $con->prepare("DELETE FROM imagens_veiculos WHERE id = ?");
  $stmt->bindParam(1, $veiculo_foto_id);
  $stmt->execute();

  $stmt = $con->prepare("UPDATE imagens_veiculos SET ordem = ordem-1 WHERE veiculo_id = ? AND ordem > ?");
  $stmt->bindParam(1, $veiculo_foto['veiculo_id']);
  $stmt->bindParam(2, $veiculo_foto['ordem']);
  $stmt->execute();

  unlink(caminhoImagemVeiculo($veiculo_foto, "../"));
}
  
header("Location: imagens-veiculo.php?id={$veiculo_foto['veiculo_id']}");