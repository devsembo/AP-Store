<section id="encomendas-detalhe">

    <div class="container">
        <div class="row">
            <div class="col-12">

                <h3 class="text-center">Detalhe da encomenda</h3>

                <div class="row">
                    <div class="col">
                        <div class="p-2 my-1">
                            <span><strong>Data da encomenda</strong></span><br>
                            <?= $dados_encomenda->data_encomenda ?>
                        </div>
                        <div class="p-2 my-1">
                            <span><strong>Morada</strong></span><br>
                            <?= $dados_encomenda->morada ?>
                        </div>
                        <div class="p-2 my-1">
                            <span><strong>Cidade</strong></span><br>
                            <?= $dados_encomenda->cidade ?>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2 my-1">
                            <span><strong>Email</strong></span><br>
                            <?= $dados_encomenda->email ?>
                        </div>

                        <div class="col">
                            <div class="p-1 my-3">
                                <span><strong>Envio</strong></span><br>
                                <?= $dados_encomenda->email ?>
                            </div>


                            <div class="p-1 my-3">
                                <span><strong>Telefone</strong></span><br>
                                <?= !empty($dados_encomenda->telefone) ? $dados_encomenda->telefone : '&nbsp;' ?>
                            </div>
                            <div class="p-1 my-3">
                                <span><strong>Código da encomenda</strong></span><br>
                                <?= $dados_encomenda->codigo_encomenda ?>
                            </div>
                        </div>
                        <div class="col align-self-center">
                            <div class="text-start mb-2">
                               <span> <strong>Estado da encomenda</strong></span> <br>
                                <?= $dados_encomenda->status ?>
                            </div>
                        </div>
                    </div>

                    <!-- dados da encomenda -->
                    <div class="row mb-3">
                        <div class="col">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Produto</th>
                                        <th class="text-center">Quantidade</th>
                                        <th class="text-end">Preço / Uni.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($produtos_encomenda as $produto) : ?>
                                        <tr>
                                            <td><?= $produto->designacao_produto ?></td>
                                            <td class="text-center"><?= $produto->quantidade ?></td>
                                            <td class="text-end"><?= number_format($produto->preco_unidade, 2, ',', '.') . '  kzs' ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="3" class="text-end">Total: <strong><?= number_format($total_encomenda, 2, ',', '.') . ' kzs' ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</section>