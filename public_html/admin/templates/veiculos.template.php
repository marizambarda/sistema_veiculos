<?php require dirname(__FILE__) . '/header.template.php'; ?>

<div class="container">
  <h2>Veiculos</h2>
  <a href="veiculo.php" class="btn btn-success">Inserir</a>
  <table class="table">
    <thead>
      <tr>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Descrição</th>
        <th>Ano/Mod</th>
        <th>Cor</th>
        <th width="1%">Ações</th>
      </tr>
    </thead>
    <tbody>
      <? foreach ($veiculos as $veiculo): ?>
        <tr>
          <td><?= $veiculo['nome_marca'] ?></td>
          <td><?= $veiculo['nome_modelo'] ?></td>
          <td><?= $veiculo['descricao'] ?></td>
          <td><?= $veiculo['ano_modelo'] ?></td>
          <td><?= $veiculo['cor'] ?></td>
          <td nowrap>
            <a href="veiculo.php?id=<?= $veiculo['id'] ?>" class="btn btn-primary">Editar</a>
            <a href="" class="btn btn-danger" data-toggle="modal" data-target="#modalExcluirVeiculo<?= $veiculo['id'] ?>">Excluir</a>

                 <!-- Modal -->
            <div class="modal fade" id="modalExcluirVeiculo<?= $veiculo['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Confirmação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="excluir_veiculo.php" method="POST">
                    <input type="hidden" name="id" value="<?= $veiculo['id'] ?>">
                    <div class="modal-body">
                      Tem certeza que quer excluir o veículo <b><?= escape($veiculo['nome_modelo']) ?></b>?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                      <button type="submit" class="btn btn-danger">Excluir</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- Fim Modal -->
          </td>
        </tr>
      <? endforeach ?>
    </tbody>
  </table>
</div>

<?php
require dirname(__FILE__)."/footer.template.php";