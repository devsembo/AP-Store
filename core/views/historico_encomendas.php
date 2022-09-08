<?php

use core\classes\Store;
?>

<section id="encomendas-hist">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <h3 class="text-center">Histórico de encomendas</h3>

                <?php if (count($historico_encomendas) == 0) : ?>
                    <p class="text-center">Não existem encomendas registadas.</p>
                    <img src="assets/images/icons/vazia2.gif"  alt="" srcset="">
                <?php else : ?>

                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Data da Encomenda</th>
                                <th>Código encomenda</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($historico_encomendas as $encomenda) : ?>
                                <tr>
                                    <td><?= $encomenda->data_encomenda ?></td>
                                    <td><?= $encomenda->codigo_encomenda ?></td>
                                    <td><?= $encomenda->status ?></td>
                                    <td>
                                        <a href="?a=detalhe_encomenda&id=<?= Store::aesEncriptar($encomenda->id_encomenda) ?>">Detalhes</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <p class="text-end">Total encomendas: <strong><?= count($historico_encomendas) ?></strong></p>

                <?php endif; ?>
            </div>
        </div>
    </div>
</section>