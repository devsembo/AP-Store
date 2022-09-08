<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;
use core\classes\PDF;
use core\models\Clientes;
use core\models\Destaque;
use core\models\Produtos;
use core\models\Encomendas;
use core\models\Marcas;
use core\models\Produtos_destaque;

class Main
{

    // ===========================================================
    public function index()
    {

        $destaques = new Destaque();
        $mostrar_destaque = $destaques->mostar_destaque();

        $produtos = new Produtos_destaque();
        $produtos_em_destaque = $produtos->mostrar_produtos_em_destaque();

        $produtos_sec = new Produtos_destaque();
        $produtos_em_destaque_sec = $produtos_sec->mostrar_produtos_em_destaque_Sec();

        $recom = new Produtos_destaque();
        $mostar_recomdados = $recom->mostrar_produtos_recomendados();

        $dados = [
            'destaque' => $mostrar_destaque,
            'produto' => $produtos_em_destaque,
            'recom' => $mostar_recomdados,
            'sec' => $produtos_em_destaque_sec,

        ];



        Store::Layout([
            'layouts/header',
            'inicio',
            'layouts/footer',
        ], $dados);
    }


    // ===========================================================
    public function loja()
    {

        // apresenta a página da loja

        // buscar a lista de produtos disponíveis
        $produtos = new Produtos();

        // analisa que categoria mostrar
        $c = 'todos';
        if (isset($_GET['c'])) {
            $c = $_GET['c'];
        }

        // buscar informação à base de dados
        $lista_produtos = $produtos->lista_produtos_disponiveis($c);
        $lista_categorias = $produtos->lista_categorias();

        $dados = [
            'produtos' => $lista_produtos,
            'categorias' => $lista_categorias
        ];

        Store::Layout([
            'layouts/header',
            'loja',
            'layouts/footer',
        ], $dados);
    }


    // ===========================================================
    public function criar_cliente()
    {

        // verifica se já existe sessao
        if (Store::clienteLogado()) {
            $this->index();
            return;
        }

        // verifica se houve submissão de um formulário
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->index();
            return;
        }

        // verifica na base de dados se existe cliente com mesmo email
        $cliente = new Clientes();

        if ($cliente->verificar_email_existe($_POST['email'])) {

            $_SESSION['erro'] = 'Já existe um cliente com o mesmo email.';
            $this->login();
            return;
        }

        // inserir novo cliente na base de dados e devolver o purl
        $email_cliente = strtolower(trim($_POST['email']));
        $purl = $cliente->registar_cliente();

        // envio do email para o cliente
        $email = new EnviarEmail();
        $resultado = $email->enviar_email_confirmacao_novo_cliente($email_cliente, $purl);

        if ($resultado) {

            // apresenta o layout para informar o envio do email
            Store::Layout([
                'layouts/header',
                'criar_cliente_sucesso',
                'layouts/footer',
            ]);
            return;
        } else {
            echo 'Aconteceu um erro';
        }
    }

    // ===========================================================
    public function confirmar_email()
    {

        // verifica se já existe sessao
        if (Store::clienteLogado()) {
            $this->index();
            return;
        }

        // verificar se existe na query string um purl
        if (!isset($_GET['purl'])) {
            $this->index();
            return;
        }

        $purl = $_GET['purl'];

        // verifica se o purl é válido
        if (strlen($purl) != 12) {
            $this->index();
            return;
        }

        $cliente = new Clientes();
        $resultado = $cliente->validar_email($purl);

        if ($resultado) {

            // apresenta o layout para informar a conta foi confirmada com sucesso
            Store::Layout([
                'layouts/header',
                'conta_confirmada_sucesso',
                'layouts/footer',
            ]);
            return;
        } else {

            // redirecionar para a página inicial
            Store::redirect();
        }
    }

    // ===========================================================
    public function login()
    {

        // verifica se já existe um utilizador logado
        if (Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // apresentação do formulário de login
        Store::Layout([
            'layouts/header',
            'login_frm',
            'layouts/footer',
        ]);
    }

    // ===========================================================
    public function login_submit()
    {

        // verifica se já existe um utilizador logado
        if (Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // verifica se foi efetuado o post do formulário de login
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect();
            return;
        }

        // validar se os campos vieram corretamente preenchidos
        if (
            !isset($_POST['email']) ||
            !isset($_POST['senha']) ||
            !filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)
        ) {
            // erro de preenchimento do formulário
            $_SESSION['erro'] = 'Login inválido';
            Store::redirect('senha');
            return;
        }

        // prepara os dados para o model
        $usuario = trim(strtolower($_POST['email']));
        $senha = trim($_POST['senha']);

        // carrega o model e verifica se login é válido
        $cliente = new Clientes();
        $resultado = $cliente->validar_login($usuario, $senha);

        // analisa o resultado
        if (is_bool($resultado)) {

            // login inválido
            $_SESSION['erro'] = 'Login inválido';
            Store::redirect('login');
            return;
        } else {

            // login válido. Coloca os dados na sessão
            $_SESSION['cliente'] = $resultado->id_cliente;
            $_SESSION['usuario'] = $resultado->email;
            $_SESSION['nome_cliente'] = $resultado->nome_completo;

            // redirecionar para o local correto
            if (isset($_SESSION['tmp_carrinho'])) {

                // remove a variável temporária da sessão
                unset($_SESSION['tmp_carrinho']);

                // redireciona para resumo da encomenda
                Store::redirect('finalizar_encomenda_resumo');
            } else {

                // redirectionamento para a loja
                Store::redirect();
            }
        }
    }

    // ===========================================================
    public function logout()
    {

        // remove as variáveis da sessão
        unset($_SESSION['cliente']);
        unset($_SESSION['usuario']);
        unset($_SESSION['nome_cliente']);

        // redireciona para o início da loja
        Store::redirect();
    }


    // ===========================================================
    // PERFIL DO USUÁRIO
    // ===========================================================
    public function perfil()
    {

        // verifica se existe um utilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // buscar informações do client
        $cliente = new Clientes();
        $dtemp = $cliente->buscar_dados_cliente($_SESSION['cliente']);

        $dados_cliente = [
            'Email' => $dtemp->email,
            'Nome completo' => $dtemp->nome_completo,
        ];

        $dados_entrega = [
            'Morada' => $dtemp->morada,
            'Cidade' => $dtemp->cidade,
            'Telefone' => $dtemp->telefone
        ];


        $dados = [
            'dados_cliente' => $dados_cliente,
            'dados_entrega' => $dados_entrega,
            'dados_pessoais' => $cliente->buscar_dados_cliente($_SESSION['cliente'])

        ];

        // apresentação da página de perfil
        Store::Layout([
            'layouts/header',
            'perfil_navegacao',
            'perfil',
            'layouts/footer',
        ], $dados);
    }


    // ===========================================================
    public function alterar_dados_pessoais()
    {
        // verifica se existe um utilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // vai buscar os dados pessoais
        $cliente = new Clientes();
        $dados = [
            'dados_pessoais' => $cliente->buscar_dados_cliente($_SESSION['cliente'])
        ];

        // apresentação da página de perfil
        Store::Layout([
            'layouts/header',
            'perfil',
            'alterar_dados_pessoais',
            'layouts/footer',
        ], $dados);
    }

    // ===========================================================
    public function alterar_dados_pessoais_submit()
    {
        // verifica se existe um utilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // verifica se existiu submissão de formulário
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect();
            return;
        }

        // validar dados
        $email = trim(strtolower($_POST['email']));
        $nome_completo = trim($_POST['nome']);

        // validar se é email válido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['erro'] = "Endereço de email inválido.";
            $this->alterar_dados_pessoais();
            return;
        }

        // validar rapidamente os restantes campos
        if (empty($nome_completo)) {
            $_SESSION['erro'] = "Preencha corretamente o formulário.";
            $this->alterar_dados_pessoais();
            return;
        }

        // validar se este email já existe noutra conta de cliente
        $cliente = new Clientes();
        $existe_noutra_conta = $cliente->verificar_se_email_existe_noutra_conta($_SESSION['cliente'], $email);
        if ($existe_noutra_conta) {
            $_SESSION['erro'] = "O email já pertence a outro cliente.";
            $this->alterar_dados_pessoais();
            return;
        }

        // atualizar os dados do cliente na base de dados
        $cliente->atualizar_dados_cliente($email, $nome_completo);

        // atualizar os dados do cliente na sessao
        $_SESSION['usuario'] = $email;
        $_SESSION['nome_cliente'] = $nome_completo;

        // redirecionar para a página do perfil
        Store::redirect('perfil');
    }

    // ===========================================================
    public function alterar_dados_morada()
    {
        // verifica se existe um utilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // verifica se existiu submissão de formulário
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect();
            return;
        }

        // validar dados
        $morada = trim($_POST['morada']);
        $telefone = trim($_POST['telefone']);
        $cidade = trim($_POST['cidade']);

        // validar rapidamente os restantes campos
        if (empty($telefone) || (empty($cidade))) {
            $_SESSION['erro'] = "Preencha corretamente o formulário.";
            $this->perfil();
            return;
        }

        // validar se este email já existe noutra conta de cliente
        $cliente = new Clientes();

        // atualizar os dados do cliente na base de dados
        $cliente->atualizar_dados_entrega( $morada,  $telefone, $cidade);

        // atualizar os dados do cliente na sessao
        $_SESSION['morada'] = $morada;
        $_SESSION['telefone'] = $telefone;

        // redirecionar para a página do perfil
        Store::redirect('perfil');
    }




    // ===========================================================
    public function alterar_password()
    {
        // verifica se existe um utilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // apresentação da página de alteração da password
        Store::Layout([
            'layouts/header',
            'perfil_navegacao',
            'alterar_password',
            'layouts/footer',
        ]);
    }

    // ===========================================================
    public function alterar_password_submit()
    {
        // verifica se existe um utilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // verifica se existiu submissão de formulário
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect();
            return;
        }

        // validar dados
        $senha_atual = trim($_POST['text_senha_atual']);
        $nova_senha = trim($_POST['text_nova_senha']);
        $repetir_nova_senha = trim($_POST['text_repetir_nova_senha']);

        // validar se a nova senha vem com dados
        if (strlen($nova_senha) < 6) {
            $_SESSION['erro'] = "Indique a nova senha e a repetição da nova senha.";
            $this->alterar_password();
            return;
        }

        // verificar se a nova senha a a sua repetição coincidem
        if ($nova_senha != $repetir_nova_senha) {
            $_SESSION['erro'] = "A nova senha e a sua repetição não são iguais.";
            $this->alterar_password();
            return;
        }

        // verificar se a senha atual está correta
        $cliente = new Clientes();
        if (!$cliente->ver_se_senha_esta_correta($_SESSION['cliente'], $senha_atual)) {
            $_SESSION['erro'] = "A senha atual está errada.";
            $this->alterar_password();
            return;
        }

        // verificar se a nova senha é diferente da senha atual
        if ($senha_atual == $nova_senha) {
            $_SESSION['erro'] = "A nova senha é igual à senha atual.";
            $this->alterar_password();
            return;
        }

        // atualizar a nova senha
        $cliente->atualizar_a_nova_senha($_SESSION['cliente'], $nova_senha);

        // redirecionar para a página do perfil
        Store::redirect('perfil');
    }

    // ===========================================================
    public function esqueceu_senha()
    {
        // verifica se já existe um utilizador logado
        if (Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // apresentação do formulário de login
        Store::Layout([
            'layouts/header',
            'esqueceu_senha_frm',
            'layouts/footer',
        ]);
    }

    // ===========================================================
    public function esqueceu_senha_submit()
    {

        // verifica se já existe um utilizador logado
        if (Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // verifica se existiu submissão de formulário
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect();
            return;
        }

        // validar dados
        $nova_senha = trim($_POST['text_nova_senha_1']);
        $repetir_nova_senha = trim($_POST['text_nova_senha_2']);

        // validar se a nova senha vem com dados
        if (strlen($nova_senha) < 6) {
            $_SESSION['erro'] = "Indique a nova senha e a repetição da nova senha.";
            $this->alterar_password();
            return;
        }

        // verificar se a nova senha a a sua repetição coincidem
        if ($nova_senha != $repetir_nova_senha) {
            $_SESSION['erro'] = "A nova senha e a sua repetição não são iguais.";
            $this->alterar_password();
            return;
        }

        // atualizar a nova senha
        $cliente = new Clientes();
        $cliente->atualizar_a_nova_senha($_SESSION['cliente'], $nova_senha);

        // redirecionar para a página do perfil
        Store::redirect('perfil');
    }

    // ===========================================================
    public function historico_encomendas()
    {
        // verifica se existe um utilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // carrega o histórico das encomendas
        $encomendas = new Encomendas();
        $historico_encomendas = $encomendas->buscar_historico_encomendas($_SESSION['cliente']);

        // Store::printData($historico_encomendas);

        $data = [
            'historico_encomendas' => $historico_encomendas
        ];

        // apresentar a view com o histórico das encomendas
        Store::Layout([
            'layouts/header',
            'perfil_navegacao',
            'historico_encomendas',
            'layouts/footer',
        ], $data);
    }

    // ===========================================================
    public function historico_encomendas_detalhe()
    {

        // verifica se existe um utilizador logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // verificar se veio indicado um id_encomenda (encriptado)
        if (!isset($_GET['id'])) {
            Store::redirect();
            return;
        }

        $id_encomenda = null;

        // verifica se o id_encomenda é uma string com 32 caracteres
        if (strlen($_GET['id']) != 32) {
            Store::redirect();
            return;
        } else {
            $id_encomenda = Store::aesDesencriptar($_GET['id']);
            if (empty($id_encomenda)) {
                Store::redirect();
                return;
            }
        }

        // verifica se a encomenda pertence a este cliente
        $encomendas = new Encomendas();
        $resultado = $encomendas->verificar_encomenda_cliente($_SESSION['cliente'], $id_encomenda);
        if (!$resultado) {
            Store::redirect();
            return;
        }

        // vamos buscar os dados de detalhe da encomenda.
        $detalhe_encomenda = $encomendas->detalhes_de_encomenda($_SESSION['cliente'], $id_encomenda);

        // calcular o valor total da encomenda
        $total = 0;
        foreach ($detalhe_encomenda['produtos_encomenda'] as $produto) {
            $total += ($produto->quantidade * $produto->preco_unidade);
        }

        $data = [
            'dados_encomenda' => $detalhe_encomenda['dados_encomenda'],
            'produtos_encomenda' => $detalhe_encomenda['produtos_encomenda'],
            'total_encomenda' => $total
        ];

        // vamos apresentar a nova view com esses dados.
        Store::Layout([
            'layouts/header',
            'perfil_navegacao',
            'encomenda_detalhe',
            'layouts/footer',
        ], $data);
    }

    // ===========================================================
    public function pagamento()
    {
        // simulação do webhook do getaway de pagamento

        /* 
            verificar se vem o código da encomenda
            verificar se a encomenda com o código indicado está pendente
            alterar o estado da encomenda de pendente para em processamento
        */

        // verificar se o código da encomenda veio indicado
        $codigo_encomenda = '';
        if (!isset($_GET['cod'])) {
            return;
        } else {
            $codigo_encomenda = $_GET['cod'];
        }

        // verificar se existe o código ativo (PENDENTE)
        $encomenda = new Encomendas();
        $resultado = $encomenda->efetuar_pagamento($codigo_encomenda);

        echo (int)$resultado;
    }









    public function criar_pdf()
    {

        $pdf = new PDF();
        //$pdf->set_template(getcwd() . '/assets/templates_pdf/fatura2k21.pdf');

        $pdf->apresentar_pdf();
    }


    public function error_page()
    {
        // vamos apresentar a nova view com esses dados.
        Store::Layout([
            'layouts/header_error',
            'error_page',
            'layouts/footer_error',
        ]);
    }
}
