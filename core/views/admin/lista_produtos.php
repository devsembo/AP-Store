<?php

use core\classes\Store;
?>

<div class="container-fluid">
    <div class="row mt-3">

        <div class="col-md-2">
            <?php include(__DIR__ . '/layouts/admin_menu.php') ?>
        </div>

        <div class="col-md-10">
            <h3>Lista de Produtos</h3>
            <hr>

            <?php if (count($produtos) == 0) : ?>
                <p class="text-center text-muted">Não existem Produtos registados.</p>
            <?php else : ?>
                <!-- apresenta a tabela de clientes -->
                <table class="table table-sm" id="tabela-produtos">
                    <thead class="table-dark">
                        <tr>
                            <th>Nome do Produto</th>
                            <th>Categoria de Produto</th>
                            <th>Stock</th>
                            <th class="text-center">Preço</th>
                            <th class="text-center">Visivel</th>
                            <th class="text-center">Deleted</th>
                            <th class="text-center">Eliminar</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($produtos as $produto) : ?>
                            <tr>
                                <td>
                                    <a href="?a=detalhe_produto&c=<?= Store::aesEncriptar($produto->id_produto) ?>"><?= $produto->nome_produto ?></a>
                                </td>

                                <td><?= $produto->categoria ?></td>
                                <td><?= $produto->stock ?></td>

                                <td class="text-center">
                                    <?php if ($produto->preco == 0) : ?>
                                        -
                                    <?php else : ?>
                                        <a href="?a=detalhe_produto&c=<?= Store::aesEncriptar($produto->id_produto) ?>"><?= $produto->preco ?></a>
                                    <?php endif; ?>
                                </td>

                                <!-- ativo -->
                                <td class="text-center">
                                    <?php if ($produto->visivel == 1) : ?>
                                        <i class="text-success fas fa-check-circle"></i></span>
                                    <?php else : ?>
                                        <i class="text-danger fas fa-times-circle"></i></span>
                                    <?php endif; ?>
                                </td>

                                <!-- eliminado -->
                                <td class="text-center">
                                    <?php if ($produto->deleted_at == null) : ?>
                                        <i class="text-danger fas fa-times-circle"></i></span>
                                    <?php else : ?>
                                        <i class="text-success fas fa-check-circle"></i></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="?a=eliminar_produto&c=<?= Store::aesEncriptar($produto->id_produto) ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square-fill  text-danger " viewBox="0 0 16 16">
                                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z" />
                                        </svg></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            <?php endif; ?>

        </div>

    </div>
</div>



<script>
    $(document).ready(function() {
        $('#tabela-clientes').DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No data available in table",
                "info": "Mostrando página _PAGE_ de um total de _PAGES_",
                "infoEmpty": "Não existem encomendas disponíveis",
                "infoFiltered": "(Filtrado de um total de _MAX_ encomendas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Apresenta _MENU_ encomendas por página",
                "loadingRecords": "Carregando...",
                "processing": "Processando...",
                "search": "Procurar:",
                "zeroRecords": "Não foram encontradas encomendas",
                "paginate": {
                    "first": "Primeira",
                    "last": "Última",
                    "next": "Seguinte",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": ativar para ordenar a coluna de forma ascendente",
                    "sortDescending": ": ativar para ordenar a coluna de forma descendente"
                }
            }
        });
    });
</script>

<script>
    function ModalEdit() {
        var modalEdit = new bootstrap.Modal(document.getElementById('modalEdit'));
        modalEdit.show();
    }
</script>

<script>
    $(document).ready(function() {
        $('#tabela-produtos').DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No data available in table",
                "info": "Mostrando página _PAGE_ de um total de _PAGES_",
                "infoEmpty": "Não existe nenhum produto com este nome",
                "infoFiltered": "(Filtrado de um total de _MAX_ produtos)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Apresenta _MENU_ produtos por página",
                "loadingRecords": "Carregando...",
                "processing": "Processando...",
                "search": "Procurar:",
                "zeroRecords": "Não foi encontrado nenhum produto",
                "paginate": {
                    "first": "Primeira",
                    "last": "Última",
                    "next": "Seguinte",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": ativar para ordenar a coluna de forma ascendente",
                    "sortDescending": ": ativar para ordenar a coluna de forma descendente"
                }
            }
        });
    });
</script>