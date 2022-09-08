<main>
    <section id="acount">
        <div class="container">
            <div class="row">

                <div class="login">
                    <h5>Quem vem lá?</h5>
                    <h6>Já és um soluter?</h6>

                    <form action="?a=login_submit" method="post">

                        <?php if (isset($_SESSION['erro'])) : ?>
                            <div class="alert alert-danger text-center">
                                <?= $_SESSION['erro'] ?>
                                <?php unset($_SESSION['erro']); ?>
                            </div>
                        <?php endif; ?>
                        <!--Usuario -->
                        <div class="my-3">
                            <label for="E-mail">E-mail</label>
                            <input type="text" name="email" placeholder="E-mail" required>
                        </div>

                        <!--Password -->
                        <div class="my-3">
                            <label for="senha">Senha</label>
                            <input type="password" name="senha" placeholder="E-mail" required>
                        </div>
                        <h5><a href="?">Esqueceste-te da tua palavra-passe?</a></h5>

                        <div class="my-3 text-center">
                            <button type="submit"> Entrar </button>
                        </div>
                    </form>
                </div>

                <div class="registro">
                    <h5>Quem vem lá?</h5>
                    <h6>Já és um soluter?</h6>

                    <form action="?a=criar_cliente" method="post">

                        <?php if (isset($_SESSION['erro'])) : ?>
                            <div class="alert alert-danger text-center">
                                <?= $_SESSION['erro'] ?>
                                <?php unset($_SESSION['erro']); ?>
                            </div>
                        <?php endif; ?>
                        <!--Usuario -->
                        <div class="my-3">
                            <label for="Nome">Nome:</label>
                            <input type="text" name="nome" placeholder="Primeiro e Ultimo" required>
                        </div>

                        <div class="my-3">
                            <label for="E-mail">E-mail:</label>
                            <input type="text" name="email" placeholder="E-mail" required>
                        </div>

                        <div class="my-3">
                            <label for="Morada">Morada:</label>
                            <input type="text" name="morada" placeholder="Morada Completa" required>
                        </div>

                        <div class="my-3">
                            <label for="telefone">Telefone:</label>
                            <input type="text" name="telefone" placeholder="número contactável" required>
                        </div>
                        <div class="my-3">
                            <label for="senha">Senha:</label>
                            <input type="password" name="senha" placeholder="Palavra-Passe" required>
                            <p class="text"> Pelo menos 8 caracteres, incluindo 1 letra maiúscula, 1 letra minúscula e 1 número. Pelo sim pelo não 😉</p>
                        </div>
                        <div class="checkbox">

                            <input type="checkbox" name="newsletter" value="newsletter">
                            <p>Quero receber as melhores ofertas e a nova newsletter da APStore por e-mail.</p>
                        </div>

                        <p class="termo">Ao criares uma conta, concordas com os <a href="?a=termo_utlizacao">Termos de utilização</a>, <a href="?a=condicoes_venda">Condições de venda</a>, <a href="?a=politica_privacidade">política de privacidade</a> e confirmas que tens pelo menos 16 anos de idade.
                        </p>
                        <div class="my-3 text-center">
                            <button type="submit"> Prazer em conhecer-te! </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</main>