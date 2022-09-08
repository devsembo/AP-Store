<section class="banner_main">
    <div class="container-fluid">
        <div class="col-sm-4 offset-sm-4">

            <div>
                <div class="wrapper fadeInDown">
                    <div id="formContent">
                        <!-- Tabs Titles -->
                        <h2 class="active"> Criar Conta </h2>

                        <!-- Icon -->
                        <div class="fadeIn first">
                
                        </div>
                        <form action="?a=criar_cliente" method="post">
                            <?php if (isset($_SESSION['erro'])) : ?>
                                <div class="alert alert-danger text-center p-2">
                                    <?= $_SESSION['erro'] ?>
                                    <?php unset($_SESSION['erro']) ?>
                                </div>
                            <?php endif; ?>
                            <!-- email -->
                            <div class="my-3">
                                <label>Email</label>
                                <input type="email" name="text_email" placeholder="Email" class="fadeIn second" required>
                            </div>

                            <!-- senha_1 -->
                            <div class="my-3">
                                <label>Senha</label>
                                <input type="password" name="text_senha_1" placeholder="Senha" class="fadeIn second" required>
                            </div>

                            <!-- senha_2 -->
                            <div class="my-3">
                                <label>senha</label>
                                <input type="password" name="text_senha_2" placeholder="Repetir a senha" class="fadeIn second" required>
                            </div>

                            <!-- nome_completo -->
                            <div class="my-3">
                                <label>Nome </label>
                                <input type="text" name="text_nome_completo" placeholder="Nome completo" class="fadeIn second" required>
                            </div>

                            <!-- morada -->
                            <div class="my-3">
                                <label>Morada</label>
                                <input type="text" name="text_morada" placeholder="Morada" class="fadeIn second" required>
                            </div>

                            <!-- cidade -->
                            <div class="my-3">
                                <label>Cidade</label>
                                <input type="text" name="text_cidade" placeholder="Cidade" class="fadeIn second" required>
                            </div>

                            <!-- telefone -->
                            <div class="my-3">
                                <label>Telefone</label>
                                <input type="text" name="text_telefone" placeholder="Telefone" class="fadeIn second">
                            </div>

                            <!-- submit -->
                            <div class="my-4">
                                <input type="submit" value="Criar conta" class="btn btn-primary">
                            </div>



                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>