<?php 
require dirname(__FILE__)."/header.template.php";
?>

<div class="container">
  <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST">
    <? if(count($erros) != 0): ?>
      <div class="alert alert-danger">
        Por favor, corrija os seguintes erros:
        <ul>
          <? foreach($erros as $erro): ?>
            <li><?= $erro ?></li>
          <? endforeach ?>
        </ul>
      </div>
    <? endif ?>
    <div class="form-group">
      <label for="campoMarca">Marca</label>
      <select class="form-control" id="campoMarca" name="marca_id">
        <option value="">Selecione a marca</option>
        <? foreach($marcas as $marca): ?>
          <option <? if($marca_id == $marca['id']): ?> selected <? endif ?> value="<?= $marca['id'] ?>"><?= escape($marca['nome']) ?></option>
        <? endforeach ?>
      </select>
    </div>
    <div class="form-group">
      <label for="campoModelo">Modelo</label>
      <select class="form-control" id="campoModelo" name="modelo_id">
        <option value="">Selecione o modelo</option>
        <? foreach($modelos as $modelo): ?>
          <option <? if($modelo_id == $modelo['id']): ?> selected <? endif ?> value="<?= $modelo['id'] ?>"><?= escape($modelo['nome']) ?></option>
        <? endforeach ?>
      </select>
    </div>
    <div class="form-group">
      <label for="campoDescricao">Descrição</label>
      <input type="text" class="form-control" id="campoDescricao" name="descricao" value="<?= escape($descricao) ?>">
    </div>
    <div class="form-group">
      <label for="campoAnoMod">Ano/Modelo</label>
      <input type="text" class="form-control" id="campoAnoMod" name="ano_modelo" value="<?= escape($ano_modelo) ?>">
    </div>
    <div class="form-group">
      <label for="campoCor">Cor</label>
      <!-- <input type="text" class="form-control" id="campoCor" name="cor" value="<?= escape($cor) ?>"> -->
      <select class="form-control" name="cor" id="campoCor">
        <option value="">Selecione a cor</option>
        <? foreach ($cores as $opcao_cor): ?>
          <option <? if($opcao_cor == $cor): ?> selected <? endif ?> value="<?= $opcao_cor ?>"><?= $opcao_cor ?></option>
        <? endforeach ?>
        <? if(!in_array($cor, $cores)): ?>
          <option selected value="<?= escape($cor) ?>"><?= escape($cor) ?></option>
        <? endif ?>
        <option value="Outra">Outra</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
  </form>
</div>

<script type="text/javascript" src="js/veiculos.js"></script>

<?php
require dirname(__FILE__)."/footer.template.php";