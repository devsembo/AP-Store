<div class="container">
    <div class="row my-5">
        <div class="col-sm-4 offset-sm-4">

            <div class="text-center">
                <h5>Inserir Email</h5>
            </div>


                <form action="?a=esqueceu_senha_submit" method="post">

                    <?php if (isset($_SESSION['erro'])) : ?>
                        <div class="alert alert-danger text-center p-2">
                            <?= $_SESSION['erro'] ?>
                            <?php unset($_SESSION['erro']) ?>
                        </div>
                    <?php endif; ?>

                    <div class="my-3">
                        <label>Email:</label>
                        <input type="email" name="text_usuario" placeholder="Email"  class="form-control" required>
                    </div>

                    <div class="my-3 text-center">
                        <input type="submit" value="Enviar" class="btn btn-primary">
                    </div>

                </form>
        </div>
    </div>
</div>