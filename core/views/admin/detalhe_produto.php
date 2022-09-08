<?php

use core\classes\Store;
?>


<div class="container-fluid">
    <div class="row mt-3">

        <div class="col-md-2">
            <?php include(__DIR__ . '/layouts/admin_menu.php') ?>
        </div>

        <div class="col-md-10">
            <h3>Detalhe do Produto</h3>
            <hr>

            <div class="row mt-3">
                <!-- nome completo -->
                <div class="col-3 text-end fw-bold">Nome de Produto:</div>
                <div class="col-9"><?= $dados_produtos->nome_produto ?></div>
                <!-- telefone -->
                <div class="col-3 text-end fw-bold">Preço:</div>
                <div class="col-9"><?= empty($dados_produtos->preco) ? '-' : $dados_produtos->preco ?></div>
                <!-- email -->
                <div class="col-3 text-end fw-bold">Categoria do Produto:</div>
                <div class="col-9"><?= $dados_produtos->categoria ?></div>
                <!-- ativo -->
                <div class="col-3 text-end fw-bold">Visivel:</div>
                <div class="col-9"><?= $dados_produtos->visivel == 0 ? '<span class="text-danger">Indisponivel</span>' : '<span class="text-success">Ativo</span>' ?></div>
                <!-- criado em -->
                <div class="col-3 text-end fw-bold">Inserido Em:</div>
                <?php
                $data = DateTime::createFromFormat('Y-m-d H:i:s', $dados_produtos->created_at);
                ?>
                <div class="col-9"><?= $data->format('d-m-Y') ?></div>
                <!-- criado em -->
                <div class="col-3 text-end fw-bold">Atualizado Em:</div>
                <?php
                $ano = DateTime::createFromFormat('Y-m-d H:i:s', $dados_produtos->updated_at);
                ?>
                <div class="col-9"><?= $ano->format('d-m-Y') ?></div>
                <div class="col-md-10 text-center">
                    <a class="btn btn-primary btn-sm" onclick="ModalEdit()">Editar Produto</a>
                </div>
                
                                            <?php if (isset($_SESSION['erro'])) : ?>
                            <div class="alert alert-danger text-center">
                                <?= $_SESSION['erro'] ?>
                                <?php unset($_SESSION['erro']); ?>
                            </div>
                        <?php endif; ?>
            </div>
        </div>

    </div>

</div>

    <!-- modal -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Iserir Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="?a=editar_produto_submit&c=<?= Store::aesEncriptar($produto->id_produto) ?>" method="post" enctype='multipart/form-data'>


                        <div class="form-group">
                            <label for="user">Id  do produto:</label>
                            <input type="text" class="form-control" placeholder="Id produto" name="id_produto"  value="<?= $dados_produtos->id_produto ?>">
                        </div>
                        <div class="form-group">
                            <label for="user">categoria do produto:</label>
                            <input type="text" class="form-control" placeholder="categoria" name="categoria" required value="<?= $dados_produtos->categoria ?>">
                        </div>
                        <div class="form-group">
                            <label for="user">nomedo produto:</label>
                            <input type="text" class="form-control" placeholder="nome do produto" name="nome_produto" required value="<?= $dados_produtos->nome_produto ?>">
                        </div>
                        <div class="form-group">
                            <label for="user">descricao:</label>
                            <input type="text" class="form-control" placeholder="descrição" name="descricao" required value="<?= $dados_produtos->descricao ?>">
                        </div>
                        <div class="form-group">
                            <label for="user">Imagem do produto:</label>
                            <input type="text" class="form-control" placeholder="imagem do produto" name="imagem" required value="<?= $dados_produtos->imagem ?>">
                        </div>
                        <div class="form-group">
                            <label>preco:</label>
                            <input type="text" class="form-control" placeholder="Preço do produto" name="preco" required value="<?= $dados_produtos->preco ?>">
                        </div>
                        <div class="form-group">
                            <label>stock:</label>
                            <input type="number" class="form-control" placeholder="Quandtidade do produto" name="stock" required value="<?= $dados_produtos->stock ?>">
                        </div>
                        <div class="form-group">
                            <label>Estado:</label>
                            <input type="number" class="form-control" placeholder="Visibilidade'1=Sim & 0=não'" name="visivel" required value="<?= $dados_produtos->visivel ?>">
                        </div>
                        <div class="form-group">
                            <label>Imagem:</label>
                            <input type="file" class="form-control" placeholder="Imagem do animal" name="foto">
                        </div>
                        <div class="form-group">
                            <label for="user">Nome da Imagem:</label>
                            <input type="text" class="form-control" placeholder="Nome da Imagem" name="name">
                        </div>
                        <br>
                        <button type="submit" name='btn_upload' class="btn btn-success">Atualizar</button> </a>
                        <button type="reset" class="btn btn-secondary">Limpar Dados</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>

            </div>
        </div>
    </div>


<script>
    function ModalEdit() {
        var modalEdit = new bootstrap.Modal(document.getElementById('modalEdit'));
        modalEdit.show();
    }
</script>