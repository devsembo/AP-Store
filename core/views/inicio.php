<?php

use core\classes\Store;
?>


<section id="destaque">
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/images/destaques/banner1.png" alt="...">
            </div>
            <div class="carousel-item">
                <img src="assets/images/destaques/banner2.png" alt="apple watch's">
            </div>
            <div class="carousel-item">
                <img src="assets/images/destaques/banner3.png" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
</section>


<section id="prod-dest">
    <div class="container">
        <div class="row">
            <div class="texto">
                <h4 class="title-text">Os nossos BIG FIVE</h4>
                <p>- como novos, mas a um preço melhor</p>
            </div>

            <?php foreach ($produto as $produto) : ?>
                <div class="col-sm-5">
                    <div class="card">
                        <a href="?a=detalhe_produto&c=<?= Store::aesEncriptar($produto->id_produto) ?>">
                            <div class="card-body">
                                <img src="assets/images/produtos/<?= $produto->imagem ?>" alt="<?= $produto->nome_produto ?>">
                                <h5 class="card-title"><?= $produto->nome_produto ?></h5>
                                <p class="card-text"><?= $produto->detalhes ?></p>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section id="prod-dest-second">
    <div class="container">
        <?php foreach ($sec as $sec) : ?>
            <div class="box">
                <a href="?a=detalhe_produto&c=<?= Store::aesEncriptar($sec->id_produto) ?>">
                    <div class="card-body">
                        <img src="assets/images/produtos/<?= $sec->imagem ?>" alt="<?= $sec->nome_produto ?>">
                        <h5 class="card-title"><?= $sec->nome_produto ?></h5>
                        <p class="card-text"><?= $sec->detalhes ?></p>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>



<section id="bv-info">
    <div class="info">
        <h3 class="boas-vindas" style="margin-bottom: 60px;">
            Bem vindo a APStore, O SEU NOVO (VIZINHO) dos recondicionados
        </h3>
        <a href="?a=quem_somos"><input type="button" value="Quem somos nós?"></a>
    </div>
    <div class="ofertas">
        <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-smile-fill" viewBox="0 0 16 16">
                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zM4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM10 8c-.552 0-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5S10.552 8 10 8z" />
            </svg></span>
        <h3 class="garantia">
            Qualidade garantida
        </h3>
        <p>Escolhe as melhores ofertas de <br> vendedores verificados.</p>
    </div>

    <div class="preco">
        <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z" />
            </svg></span>
        <h3 class="qualidade">
            As melhores ofertas
        </h3>
        <p>Selecionadas por nossos profissionais. <br> só a melhor qualidade ao melhor preço.</p>
    </div>


    <div class="segur">
        <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16 " fill="currentColor" class="bi bi-file-lock-fill" viewBox="0 0 16 16">
                <path d="M7 6a1 1 0 0 1 2 0v1H7V6zM6 8.3c0-.042.02-.107.105-.175A.637.637 0 0 1 6.5 8h3a.64.64 0 0 1 .395.125c.085.068.105.133.105.175v2.4c0 .042-.02.107-.105.175A.637.637 0 0 1 9.5 11h-3a.637.637 0 0 1-.395-.125C6.02 10.807 6 10.742 6 10.7V8.3z" />
                <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-2 6v1.076c.54.166 1 .597 1 1.224v2.4c0 .816-.781 1.3-1.5 1.3h-3c-.719 0-1.5-.484-1.5-1.3V8.3c0-.627.46-1.058 1-1.224V6a2 2 0 1 1 4 0z" />
            </svg></span>
        <h3>
            Serviço excelente
        </h3>
        <p>Compra segura.</p>
    </div>

    <div class="impacto">
        <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe2" viewBox="0 0 16 16">
                <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855-.143.268-.276.56-.395.872.705.157 1.472.257 2.282.287V1.077zM4.249 3.539c.142-.384.304-.744.481-1.078a6.7 6.7 0 0 1 .597-.933A7.01 7.01 0 0 0 3.051 3.05c.362.184.763.349 1.198.49zM3.509 7.5c.036-1.07.188-2.087.436-3.008a9.124 9.124 0 0 1-1.565-.667A6.964 6.964 0 0 0 1.018 7.5h2.49zm1.4-2.741a12.344 12.344 0 0 0-.4 2.741H7.5V5.091c-.91-.03-1.783-.145-2.591-.332zM8.5 5.09V7.5h2.99a12.342 12.342 0 0 0-.399-2.741c-.808.187-1.681.301-2.591.332zM4.51 8.5c.035.987.176 1.914.399 2.741A13.612 13.612 0 0 1 7.5 10.91V8.5H4.51zm3.99 0v2.409c.91.03 1.783.145 2.591.332.223-.827.364-1.754.4-2.741H8.5zm-3.282 3.696c.12.312.252.604.395.872.552 1.035 1.218 1.65 1.887 1.855V11.91c-.81.03-1.577.13-2.282.287zm.11 2.276a6.696 6.696 0 0 1-.598-.933 8.853 8.853 0 0 1-.481-1.079 8.38 8.38 0 0 0-1.198.49 7.01 7.01 0 0 0 2.276 1.522zm-1.383-2.964A13.36 13.36 0 0 1 3.508 8.5h-2.49a6.963 6.963 0 0 0 1.362 3.675c.47-.258.995-.482 1.565-.667zm6.728 2.964a7.009 7.009 0 0 0 2.275-1.521 8.376 8.376 0 0 0-1.197-.49 8.853 8.853 0 0 1-.481 1.078 6.688 6.688 0 0 1-.597.933zM8.5 11.909v3.014c.67-.204 1.335-.82 1.887-1.855.143-.268.276-.56.395-.872A12.63 12.63 0 0 0 8.5 11.91zm3.555-.401c.57.185 1.095.409 1.565.667A6.963 6.963 0 0 0 14.982 8.5h-2.49a13.36 13.36 0 0 1-.437 3.008zM14.982 7.5a6.963 6.963 0 0 0-1.362-3.675c-.47.258-.995.482-1.565.667.248.92.4 1.938.437 3.008h2.49zM11.27 2.461c.177.334.339.694.482 1.078a8.368 8.368 0 0 0 1.196-.49 7.01 7.01 0 0 0-2.275-1.52c.218.283.418.597.597.932zm-.488 1.343a7.765 7.765 0 0 0-.395-.872C9.835 1.897 9.17 1.282 8.5 1.077V4.09c.81-.03 1.577-.13 2.282-.287z" />
            </svg></span>
        <h3>Impacto positivo</h3>
        <p>A alternativa ao novo, verde e económica.</p>
    </div>
</section>

<h2 class="infon">Saiba mais sobre a APStore</h2>

<div class="texto">
    <h4 class="title-text">Os nossos BIG FIVE</h4>
    <p>- como novos, mas a um preço melhor</p>
</div>

<section id="recomendados">
    <div class="rec-promo">
        <h4 class="texto-promo">Recomendados para ti</h4>
        <p>- Valem a pena!</p>
    </div>

    <div class="container">
        <ul class="slider">
            <?php foreach ($recom as $recom) : ?>
                <li>
                    <div class="cardc">
                        <a href="?a=detalhe_produto&c=<?= Store::aesEncriptar($recom->id_produto) ?>">
                            <p class="promo">Produto mais vendido</p>
                            <div class="card-body">
                                <img src="assets/images/produtos/<?= $recom->imagem ?>" alt="<?= $recom->nome_produto ?>">
                                <h6 class="card-title"><?= $recom->nome_produto ?></h6>
                                <p class="card-text"> Apartir de: <br><?= preg_replace('/\'D/', ",", $recom->preco) . ' kzs' ?></p>
                            </div>
                        </a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>




