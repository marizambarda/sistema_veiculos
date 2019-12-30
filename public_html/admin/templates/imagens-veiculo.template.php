<?php 
require dirname(__FILE__)."/header.template.php";
?>

<div class="pagina-imagens-veiculo">
  <div class="container">
    <? if(count($erros) != 0): ?>
      <div class="alert alert-danger">
        Houve um erro ao processar alguns de seus arquivos:
        <ul>
          <? foreach($erros as $erro): ?>
            <li><?= $erro ?></li>
          <? endforeach ?>
        </ul>
      </div>
    <? endif ?>
    <?if($sucesso): ?>
      <div class="alert alert-success">
        Arquivos enviados com sucesso.
      </div>
    <? endif ?>
    <h4>Insira fotos do veículo</h4>
    <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST" enctype="multipart/form-data">
      <div class="form-group row">  
        <label class="col-sm-2 col-form-label" for="campoEnviarImagens">Imagens</label>
        <div class="col-sm-10">
          <input type="file" name="imagens[]" class="form-control-file" id="campoEnviarImagens" multiple>
          <button type="submit" name="enviar-formulario">Enviar</button>
        </div>
      </div>
    </form>
    <div class="row">
      <? foreach($imagens_veiculos as $imagem_veiculo): ?>
        <div class="col-2">      
          <div class="card">
            <img src="<?= caminhoImagemVeiculo($imagem_veiculo) ?>" class="card-img-top">
            <div class="card-body">
              <form action="imagem_veiculo.php" method="post">
                <input type="hidden" name="id" value="<?= $imagem_veiculo['id'] ?>">
                <input type="hidden" name="operacao" value="diminuir-ordem">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
              </form>
              <form action="imagem_veiculo.php" method="post">
                <input type="hidden" name="id" value="<?= $imagem_veiculo['id'] ?>">
                <input type="hidden" name="operacao" value="aumentar-ordem">
                <button type="submit" class="btn btn-primary btn-sm"> <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
              </form>  
              <form action="imagem_veiculo.php" method="post">
                <input type="hidden" name="id" value="<?= $imagem_veiculo['id'] ?>">
                <input type="hidden" name="operacao" value="delete">
                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></button>
              </form>
            </div>
          </div> 
        </div>
      <? endforeach ?>
    </div>
  </div>
</div>
<?php
require dirname(__FILE__)."/footer.template.php";