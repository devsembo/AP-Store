<section class="why_us_section layout_padding" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col">





                <div class="card">
                    <div class="card-body p-4">
                        <?php if ($carrinho == null) : ?>

                            <p class="text-center">Não existem produtos no carrinho.</p>
                            <div class="mt-4 text-center">
                                <a href="?a=loja" class="btn btn-primary">Ir para a Loja</a>
                            </div>
                            <hr>
                        <?php else : ?>
                            <?php
                            $index = 0;
                            $total_rows = count($carrinho);
                            ?>
                            <div class="row">



                                <div class="col-lg-7">
                                    <h5 class="mb-3"><a href="?a=loja" class="btn btn-sm btn-primary"><i class="fas fa-long-arrow-alt-left me-2"></i>Continuar a comprar</a></h5>
                                    <hr>

                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div>
                                            <p class="mb-1">Carrinho de compra</p>
                                            <p class="mb-0">Você tem <?php $total_rows ?> produtos no carrinho</p>
                                        </div>
                                        <div>
                                            <p class="mb-0">Preço: </i></a></p>
                                        </div>
                                    </div>

                                    <div class="card mb-3">
                                        <?php foreach ($carrinho as $produto) : ?>
                                            <?php if ($index < $total_rows - 1) : ?>
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex flex-row align-items-center">
                                                            <div>
                                                                <img src="assets/images/produtos/<?= $produto['imagem']; ?>" class="img-fluid rounded-3" alt="Shopping item" style="width: 65px;">
                                                            </div>
                                                            <div class="ms-3">
                                                                <h6><?= $produto['titulo'] ?></h6>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-row align-items-center">
                                                            <div style="width: 50px;">
                                                                <h6 class="fw-normal mb-0"><?= $produto['quantidade'] ?></h6>
                                                            </div>
                                                            <div style="width: 80px;">
                                                                <h7 class="mb-0"><?= number_format($produto['preco'], 2, ',', '.') . ' kzs' ?></h7>
                                                            </div>
                                                            <a href="?a=remover_produto_carrinho&id_produto=<?= $produto['id_produto'] ?>" class="btn btn-danger btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                                                </svg></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                    </div>
                                    <div class="col">
                                        <!-- <a href="?a=limpar_carrinho" class="btn btn-sm btn-primary">Limpar carrinho</a> -->
                                        <h5> <button onclick="limpar_carrinho()" class="btn btn-sm btn-primary mb-3">Limpar carrinho</button></h5>
                                        <span class="ms-3" id="confirmar_limpar_carrinho" style="display: none; ">Tem a certeza?
                                            <button class="btn btn-sm btn-primary" onclick="limpar_carrinho_off()">Não</button>
                                            <a href="?a=limpar_carrinho" class="btn btn-sm btn-primary">Sim</a>
                                        </span>
                                    </div>

                                </div>
                                <div class="col-lg-5">

                                    <div class="card bg-primary text-white rounded-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <h5 class="mb-0">Detalhes Bancários</h5>
                                                <img src="../public/assets/images/logo5.png" class="img-fluid rounded-3" style="width: 45px;" alt="Avatar">
                                            </div>

                                            <p class="small mb-2">Bancos M87</p>
                                            <a href="#!" type="submit" class="text-white">BAI</i></a>
                                            <a href="#!" type="submit" class="text-white">BFA</i></a>
                                            <a href="#!" type="submit" class="text-white">BIC</i></a>
                                            <a href="#!" type="submit" class="text-white">Atlântico</i></a>
                                            <p></p>
                                            <p class="mb-2">IBAN:AO004052014531</p>
                                            <hr class="my-4">


                                            <div class="d-flex justify-content-between">
                                                <p class="mb-2">Subtotal</p>
                                                <p class="mb-2"><?= number_format($produto, 2, ',', '.') . ' kzs' ?></p>
                                            </div>

                                            <div class="d-flex justify-content-between">
                                                <p class="mb-2">Entrega se gratis dentro de luanda</p>
                                            </div>

                                            <div class="d-flex justify-content-between mb-4">
                                                <h8>Total:</h8>
                                                <p class="mb-2"><?= number_format($produto, 2, ',', '.') . ' kzs' ?></p>
                                            </div>

                                            <button type="button" class="btn btn-info btn-block btn-lg">
                                                <div class="d-flex justify-content-between">
                                                    <span><?= number_format($produto, 2, ',', '.') . ' kzs' ?> </span>
                                                    <span>
                                                        <h5 class="mb-3"><a href="?a=finalizar_encomenda" class="text-white">Continuar</a></h5>
                                                    </span></a>

                                                </div>
                                            </button>

                                        </div>
                                    </div>

                                </div>



                            </div>

                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php $index++; ?>
    <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

</section>