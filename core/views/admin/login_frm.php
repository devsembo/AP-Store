<div class="container">
    <div class="row my-5">
        <div class="col-sm-4 offset-sm-4">

            <div class="text-center">
                <img src="../../public/assets/images/logo2.png">
            </div>

            <div>
                <h4 class="text-center">LOGIN ADMIN</h4>

                <form action="?a=admin_login_submit" method="post">

                    <?php if (isset($_SESSION['erro'])) : ?>
                        <div class="alert alert-danger text-center">
                            <?= $_SESSION['erro'] ?>
                            <?php unset($_SESSION['erro']); ?>
                        </div>
                    <?php endif; ?>


                    <div class="my-3">
                        <label>Administrador:</label>
                        <input type="email" name="text_admin" placeholder="admin" required class="form-control">
                    </div>

                    <div class="my-3">
                        <label>Senha:</label>
                        <input type="password" name="text_senha" placeholder="Senha" required class="form-control">
                    </div>

                    <div class="my-3 text-center">
                        <input type="submit" value="Entrar" class="btn btn-primary">
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>