
div.

<section class="expo-prd">
    <div class="container">

        <!-- titulo da página -->
        <div class="row">
            <div class="col-12 text-center py-2">

                <a href="?a=loja&c=todos" class="btn btn-primary">Todos</a>
                <?php foreach ($categorias as $categoria) : ?>
                    <a href="?a=loja&c=<?= $categoria ?>" class="btn btn-primary">
                        <?= ucfirst(preg_replace("/\_/", " ", $categoria)) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="grid">


            <?php if (count($produtos) == 0) : ?>

                <div class="text-center my-5">
                    <h3>Não existem produtos disponíveis.</h3>
                </div>

            <?php else : ?>

                <!-- ciclo de apresentação dos produtos -->
                <?php foreach ($produtos as $produto) : ?>
                    <div class="card-container">
                        <h2 class="card-price"><?= preg_replace('/\D/', ",", $produto->preco) . ' kzs' ?></h2>
                        <h1 class="card-title"><?= $produto->nome_produto ?></h1>
                        <div class="card-image-container">
                            <img src="assets/images/produtos/<?= $produto->imagem ?>" alt="" />
                        </div>
                        <div class="details-btn">
                            <?php if ($produto->stock > 0) : ?>
                                <button class="btn btn-warning" onclick="adicionar_carrinho(<?= $produto->id_produto ?>)"> Adicionar ao carrinho </button>
                            <?php else : ?>
                                <button class="btn btn-danger"> Indisponivel </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif ?>
        </div>
    </div>
</section>
