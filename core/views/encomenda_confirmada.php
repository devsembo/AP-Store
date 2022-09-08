<div class="container">
    <div class="row my-5">
        <div class="col text-center">
            <h3 class="text-center">Encomenda confirmada</h3>
            <p>Muito obrigado pela sua encomenda.</p>

            <div class="my-5">
                <h4>Dados de Pagamento</h4>
                <p>Conta bancária: 123456789</p>
                <p>Código da encomenda: <strong><?= $codigo_encomenda ?></strong></p>
                <p>Total da encomenda: <strong><?= number_format($total_encomenda, 2, ',', '.') . ' kzs' ?></strong></p>
            </div>

            <p>
                Vai receber um email com a confirmação da encomenda e os dados de pagamento.
                <br>
                A sua encomenda só será processada após confirmação do pagamento.
            </p>
            <p><small>Por favor verifique se o email aparece na sua conta ou se foi para a pasta do SPAM.</small></p>
            <div class="my-5"><a href="?a=inicio" class="btn btn-primary">Voltar</a></div>
        </div>
    </div>
</div>