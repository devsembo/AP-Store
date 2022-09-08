<?php

use core\classes\Store;

// calcula o numero de produtos no carrinho
$total_produtos = 0;
if (isset($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $quantidade) {
        $total_produtos += $quantidade;
    }
}
?>


<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://kit.fontawesome.com/7d3230b0bd.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik+Moonrocks&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href="assets/images/icons/aa.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css.map">
</head>

<body>
    <header id="navbar">
        <div class="logo">
            <a href="?a=inicio">
                <h1>APStore</h1>
            </a>
        </div>
        <nav>

            <ul id="navbar-list">
                <li>
                    <a href="#">Quem Somos?</a>
                </li>

                <li>
                    <a href="#">Ajuda</a>
                </li>
            </ul>

            <div id="divBusca">
                <form action="" id="form-pesquisa" method="POST">
                    <input type="text" id="txtBusca" name="palavra" placeholder="Procuras algo(recondicionado) em particular?" />
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                </form>

                <ul class="resultado">

                </ul>
            </div>

            <div id="user">
                <?php if (Store::clienteLogado(true)) : ?>
                    <a href="?a=perfil"> <?= $_SESSION['nome_cliente'] ?> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                            <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                            <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                        </svg>
                    </a>
                    <a href="?a=logout">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z" />
                            <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                        </svg>
                    </a>

                <?php else : ?>
                    <a href="?a=login"> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                        </svg>
                    </a>
                <?php endif; ?>
                <a href="?a=carrinho">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                        <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                    </svg>
                    <span class="badge bg-warning" id="carrinho"><?= $total_produtos == 0 ? '' : $total_produtos ?></span>
                </a>
            </div>

            <div class="btn">
                <span class="fas fa-bars"></span>
            </div>
            <div id="sidebar">
                <ul>
                    <li><a href="#">Top Promoção</a></li>
                    <li><a href="#" class="appl-btn">Apple Store
                            <span class="fas fa-caret-down first"></span>
                        </a>
                        <ul class="appl-show">
                            <li><a href="#">iPhone</a></li>
                            <li><a href="#">McBook</a></li>
                            <li><a href="#">Apple Watch</a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="sony-btn">Sony Entretaiment
                            <span class="fas fa-caret-down second"></span>
                        </a>
                        <ul class="sony-show">
                            <li><a href="#">PS4</a></li>
                            <li><a href="#">PS4 Pro</a></li>
                            <li><a href="#">PS5</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div>
                <ul id="categorias">
                    <li><a href="" style="color:#df5b5b;">Melhores Ofertas</a></li>
                    <li><a href="" style="color:#d6b6ff;">Impacto ambiental</a></li>
                    <li><a href="">Top Vendas</a></li>
                    <li><a href="">Smartphones</a></li>
                    <li><a href="">iPhone</a></li>
                    <li><a href="">iPhone11</a></li>
                    <li><a href="">iPhone12</a></li>
                    <li><a href="">iPhone13</a></li>
                    <li><a href="">MacBook</a></li>
                    <li><a href="">Apple</a></li>
                    <li><a href="">Samsumg</a></li>
                    <li><a href="">Galaxy S10</a></li>
                    <li><a href="">Play Station 4</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <script>
        $('.btn').click(function() {
            $(this).toggleClass("click");
            $('#sidebar').toggleClass("show");
        });
        $('.appl-btn').click(function() {
            $('#sidebar ul .appl-show').toggleClass("show");
            $('#sidebar ul .first').toggleClass("rotate");
        });

        $('.sony-btn').click(function() {
            $('#sidebar ul .sony-show').toggleClass("show1");
            $('#sidebar ul .second').toggleClass("rotate");
        });

        $('#sidebar ul li').click(function() {
            $(this).addClass("active").siblings().removeClass("active");
        });
    </script>

    <main>