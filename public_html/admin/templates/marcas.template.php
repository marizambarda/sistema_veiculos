<?php  
require dirname(__FILE__)."/header.template.php";
?>

<div class="container">
  <h2>Marcas</h2>
  <a href="marca.php" class="btn btn-success">Inserir</a>
  <table class="table">
    <thead>
      <tr>
        <th>Nome</th>
        <th width="1%">Ações</th>
      </tr>
    </thead>
    <tbody>
      <? foreach ($marcas as $marca): ?>
        <tr>
          <td><?= $marca['nome'] ?></td>
          <td nowrap>
            <a href="marca.php?id=<?= $marca['id'] ?>" class="btn btn-primary">Editar</a>
            <a href="" class="btn btn-danger" data-toggle="modal" data-target="#modalExcluirMarca<?= $marca['id'] ?>">Excluir</a>

            <!-- Modal -->
            <div class="modal fade" id="modalExcluirMarca<?= $marca['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Confirmação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="excluir_marca.php" method="POST">
                    <input type="hidden" name="id" value="<?= $marca['id'] ?>">
                    <div class="modal-body">
                      Tem certeza que quer excluir a marca <b><?= escape($marca['nome']) ?></b>?
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