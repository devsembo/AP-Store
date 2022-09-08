<section id="perfil-d">
    <div id="texto-perfil">
        <h3> O meu Perfil</h3>
        <p>Quem somos? De onde vimos? Para onde vamos? Não procures mais as respostas.</p>
    </div>
    <div class="container">
        <div class="row">
            <div class="box">
                <h4>Informação pessoal</h4>
                <?php foreach ($dados_cliente as $key => $value) : ?>
                    <td class="text-end"><?= $key ?>:</td>
                    <td width="60%"><strong><?= $value ?> <br></strong></td>
                <?php endforeach; ?>
                <a href="?alterar_senha">Alterar a palavra passe</a>
                <button type="button" data-bs-toggle="modal" class="md-da" data-bs-target="#exampleModal"><i class="fa-solid fa-pen"></i></button>
            </div>
            <div class="box">
                <h4>Morada de faturação e entrega</h4>
                <?php foreach ($dados_entrega as $key => $value) : ?>
                    <td class="text-end"><?= $key ?>:</td>
                    <td width="60%"><strong><?= $value ?> <br></strong></td>
                <?php endforeach; ?>
                <div id="icon">
                    <button type="button" data-bs-toggle="modal" id="md-d" data-bs-target="#entremodal"><i class="fa-solid fa-pen"></i></button>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Atualizar dados pessoais</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="?a=alterar_dados_pessoais_submit" method="post">
                    <div class="my-3">
                        <label for="Nome">Nome:</label>
                        <input type="text" name="nome" required value="<?= $dados_pessoais->nome_completo ?>">
                    </div>

                    <div class="my-3">
                        <label for="E-mail">E-mail:</label>
                        <input type="text" name="email" required value="<?= $dados_pessoais->email ?>">
                    </div>
                   <hr>
                    <button type="submit" class="upload">Salvar</button>
                </form>
            </div>
            <div class="modal-footer">
                <button data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="entremodal" tabindex="-1" aria-labelledby="entremodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="entremodal">Atualizar dados da Morada</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="?a=alterar_dados_morada" method="post">
                    <div class="my-3">
                        <label for="Morada">Morada:</label>
                        <input type="text" name="morada" required value="<?= $dados_pessoais->morada ?>">
                    </div>
                    <div class="my-3">
                        <label for="telefone">Telefone:</label>
                        <input type="text" name="telefone" value="<?= $dados_pessoais->telefone ?>">
                    </div>
                    <div class="my-3">
                        <label for="cidade">cidade:</label>
                        <input type="text" name="cidade" value="<?= $dados_pessoais->cidade ?>">
                    </div>
                    <hr>
                    <button type="submit" class="upload">Salvar</button>
                </form>
            </div>
            <div class="modal-footer">
                <button data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>