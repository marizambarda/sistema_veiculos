<?php

function escape($html){
  return htmlspecialchars($html, ENT_QUOTES);
}

/*
 * Verifica se o ano modelo passado está no formato válido (por exemplo, "2009/2009").
 * Retorna true caso esteja válido, e false caso esteja inválido.
 */
function validarAnoModelo($ano_modelo){
  /**
   * Usamos a função preg_match para verificar com uma expressão regular
   * se o ano/modelo passado é válido.
   * Esta função retorna 1 se a expressão regular casar (válido), e 0 caso não case.
   */
  $resultado = preg_match('/^[0-9]{4}\/[0-9]{4}$/', $ano_modelo);

  /**
   * Transformamos o resultado da função preg_match de 1/0 (inteiro)
   * para true/false (booleano).
   */
  return boolval($resultado);
}

function caminhoImagemVeiculo($imagem_veiculo, $contexto = "/"){
  /**
   * Removemos aqui as barras do nome do arquivo por questões de segurança,
   * para garantir que caso exista uma imagem com nome malicioso no banco de dados,
   * os códigos que usem essa função não permitam que se acessem outros diretórios
   * a não ser o de uploads.
   */
  $nome_arquivo = str_replace('/', '' $imagem_veiculo['nome_arquivo']);

  return $contexto."uploads/{$imagem_veiculo['veiculo_id']}/{$nome_arquivo}";
}