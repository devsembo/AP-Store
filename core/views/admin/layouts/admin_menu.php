<div>
    <div div class="alert alert-info">
        <a href="?a=inicio">Início</a>
    </div>

    <div div class="alert alert-success">
        <a href="?a=lista_clientes">Clientes</a>
    </div>

    <div div class="alert alert-info">
        <a href="?a=lista_encomendas">Encomendas</a>
    </div>

    <div div class="alert alert-success">
        <a href="?a=lista_produtos">Produtos</a>
    </div>

    <div div class="alert alert-info">
        <a href="?a=lista_destaque">Destaques</a>
    </div>

    <div div class="alert alert-info" onclick="apresentaModalImg()">
        <a href="#">Inserir Imagens</a>
    </div>

    <div div class="alert alert-success" onclick="apresentarModalProdDest()">
        <a href="#">Inserir Produtos em destaque</a>
    </div>
    <div div class="alert alert-info" onclick="apresentarModalProd()">
        <a href="#">Inserir Produtos</a>
    </div>

    <!-- modal -->
    <div class="modal fade" id="modalProd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Iserir Produtos Em Destaque</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="?a=inserir_produto_destaque_submit" method="post">

                        <div class="form-group">
                            <label for="user">Tipo de bilhete:</label>
                            <input type="text" class="form-control" placeholder="categoria do produto" name="categoria" required>
                        </div>
                        <div class="form-group">
                            <label for="user">Nome do Bilhete:</label>
                            <input type="text" class="form-control" placeholder="Nome do produto" name="nome_prod" required>
                        </div>
                        <div class="form-group">
                            <label for="user">Descrição:</label>
                            <input type="text" class="form-control" placeholder="detalhe do produto" name="descricao" required>
                        </div>
                        <div class="form-group">
                            <label for="user">Nome da Imagem:</label>
                            <input type="text" class="form-control" placeholder="Nome da Imagem" name="imagem" required>
                        </div>
                        <div class="form-group">
                            <label>Preço:</label>
                            <input type="number" class="form-control" placeholder="Preço do produto" name="preco" required>
                        </div>
                        <div class="form-group">
                            <label>Stock:</label>
                            <input type="number" class="form-control" placeholder="Quantidade de Stock" name="stock" required>
                        </div>
                        <div class="form-group">
                            <label>Estado:</label>
                            <input type="number" class="form-control" placeholder="Visibilidade'1=Sim & 0=não'" name="visivel" required>
                        </div>
                        <br>
                        <button type="submit" name='btn_upload' class="btn btn-primary">Inserir</button>
                        <button type="reset" class="btn btn-secondary">Limpar Dados</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>

            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['erro'])) : ?>
        <div class="alert alert-danger text-center">
            <?= $_SESSION['erro'] ?>
            <?php unset($_SESSION['erro']); ?>
        </div>
    <?php endif; ?>


    <script>
        function apresentarModalProdDest() {
            var modalProd = new bootstrap.Modal(document.getElementById('modalProd'));
            modalProd.show();
        }
    </script>

    <div class="modal fade" id="modalImg" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Iserir Destaque</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="?a=inserir_imagens_submit" method="post" enctype='multipart/form-data'>
                        <div class="form-group">
                            <label>Imagem do destaque</label>
                            <input type="file" class="form-control" placeholder="Inserir imagem" name="ficheirof" required>
                        </div>
                        <div class="form-group">
                            <label for="user">Nome da Imagem:</label>
                            <input type="text" class="form-control" placeholder="Nome da Imagem" name="name" required>
                        </div>
                        <br>
                        <button type="submit" name='btn_upload' class="btn btn-primary">Inserir</button>
                        <button type="reset" class="btn btn-secondary">Limpar Dados</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function apresentaModalImg() {
            var modalImg = new bootstrap.Modal(document.getElementById('modalImg'));
            modalImg.show();
        }
    </script>

    <div class="modal fade" id="modalAnim" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Iserir Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="?a=inserir_produto_submit" method="post" enctype='multipart/form-data'>
                        <?php if (isset($_SESSION['erro'])) : ?>
                            <div class="alert alert-danger text-center">
                                <?= $_SESSION['erro'] ?>
                                <?php unset($_SESSION['erro']); ?>
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="user">categoria do produto:</label>
                            <input type="text" class="form-control" placeholder="categoria" name="categoria" required>
                        </div>
                        <div class="form-group">
                            <label for="user">nomedo produto:</label>
                            <input type="text" class="form-control" placeholder="nome do produto" name="nome_produto" required>
                        </div>
                        <div class="form-group">
                            <label for="user">descricao:</label>
                            <input type="text" class="form-control" placeholder="descrição" name="descricao" required>
                        </div>
                        <div class="form-group">
                            <label for="user">Imagem do produto:</label>
                            <input type="text" class="form-control" placeholder="imagem do produto" name="imagem" required>
                        </div>
                        <div class="form-group">
                            <label>preco:</label>
                            <input type="text" class="form-control" placeholder="Preço do produto" name="preco" required>
                        </div>
                        <div class="form-group">
                            <label>stock:</label>
                            <input type="number" class="form-control" placeholder="Quandtidade do produto" name="stock" required>
                        </div>
                        <div class="form-group">
                            <label>Estado:</label>
                            <input type="number" class="form-control" placeholder="Visibilidade'1=Sim & 0=não'" name="visivel" required>
                        </div>
                        <div class="form-group">
                            <label>Imagem:</label>
                            <input type="file" class="form-control" placeholder="Imagem do animal" name="foto" required>
                        </div>
                        <div class="form-group">
                            <label for="user">Nome da Imagem:</label>
                            <input type="text" class="form-control" placeholder="Nome da Imagem" name="name" required>
                        </div>
                        <br>
                        <button type="submit" name='btn_upload' class="btn btn-success">Inserir</button>
                        <button type="reset" class="btn btn-secondary">Limpar Dados</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        function apresentarModalProd() {
            var modalAnim = new bootstrap.Modal(document.getElementById('modalAnim'));
            modalAnim.show();
        }
    </script>
</div>