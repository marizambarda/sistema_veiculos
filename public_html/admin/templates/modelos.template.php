<?php require dirname(__FILE__) . '/header.template.php'; ?>

<div class="container">
  <h2>Modelos</h2>
  <a href="modelo.php" class="btn btn-success">Inserir</a>
  <table class="table">
    <thead>
      <tr>
        <th>Marca</th>
        <th>Modelo</th>
        <th width="1%">Ações</th>
      </tr>
    </thead>
    <tbody>
      <? foreach ($modelos as $modelo): ?>
        <tr>
          <td><?= $modelo['nome_marca'] ?></td>
          <td><?= $modelo['nome'] ?></td>
          <td nowrap>
            <a href="modelo.php?id=<?= $modelo['id'] ?>" class="btn btn-primary">Editar</a>
            <a href="" class="btn btn-danger" data-toggle="modal" data-target="#modalExcluirModelo<?= $modelo['id'] ?>">Excluir</a>

                 <!-- Modal -->
            <div class="modal fade" id="modalExcluirModelo<?= $modelo['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Confirmação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="excluir_modelo.php" method="POST">
                    <input type="hidden" name="id" value="<?= $modelo['id'] ?>">
                    <div class="modal-body">
                      Tem certeza que quer excluir a marca <b><?= escape($modelo['nome']) ?></b>?
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