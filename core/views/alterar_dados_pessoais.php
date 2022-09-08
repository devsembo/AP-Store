<div class="container">
    <div class="row my-5">
        <div class="col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-10 offset-1">

            <form action="?a=alterar_dados_pessoais_submit" method="post">

            <?php if (isset($_SESSION['erro'])) : ?>
                <div class="alert alert-danger text-center p-2">
                    <?= $_SESSION['erro'] ?>
                    <?php unset($_SESSION['erro']) ?>
                </div>
            <?php endif; ?>

                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" maxlength="50" name="text_email" class="form-control" required value="<?= $dados_pessoais->email ?>">
                    <button type="reset"><i class="fa-thin fa-circle-x"></i></button>
                </div>

                <div class="form-group">
                    <label>Nome completo:</label>
                    <input type="text" maxlength="50" name="text_nome_completo" class="form-control" required value="<?= $dados_pessoais->nome_completo ?>">
                </div>

                <div class="form-group">
                    <label>Morada:</label>
                    <input type="text" maxlength="100" name="text_morada" class="form-control" required value="<?= $dados_pessoais->morada ?>">

                    <div class="form-group">
                        <label>Cidade:</label>
                    </div>

                    <div class="form-group">
                        <label>Telefone:</label>
                        <input type="text" maxlength="20" name="text_telefone" class="form-control" value="<?= $dados_pessoais->telefone ?>">
                    </div>

                    <div class="text-center my-4">
                        <a href="?a=perfil" class="btn btn-primary btn-100">Cancelar</a>
                        <input  value="Salvar" class="btn btn-primary btn-100">
                    </div>

            </form>



        </div>
    </div>
</div>