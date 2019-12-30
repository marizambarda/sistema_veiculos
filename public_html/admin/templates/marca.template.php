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
      <input type="text" class="form-control" id="campoMarca" name="nome" value="<?= escape($nome) ?>">
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
  </form>
</div>


<?php
require dirname(__FILE__)."/footer.template.php";