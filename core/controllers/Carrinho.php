<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;

use core\models\Clientes;
use core\models\Encomendas;
use core\models\Produtos;

class Carrinho
{

    // ===========================================================
    public function adicionar_carrinho()
    {
        // vai buscar o id_produto à query string
        if (!isset($_GET['id_produto'])) {
            echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : '';
            return;
        }

        // define o id do produto
        $id_produto = $_GET['id_produto'];

        $produtos = new Produtos();
        $resultados = $produtos->verificar_stock_produto($id_produto);

        if (!$resultados) {
            echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : '';
            return;
        }

        // adiciona/gestão da variável de SESSAO do carrinho
        $carrinho = [];

        if (isset($_SESSION['carrinho'])) {
            $carrinho = $_SESSION['carrinho'];
        }

        // adicionar o produto ao carrinho
        if (key_exists($id_produto, $carrinho)) {

            // já existe o produto. Acrescenta mais uma unidade
            $carrinho[$id_produto]++;
        } else {

            // adicionar novo produto ao carrinho
            $carrinho[$id_produto] = 1;
        }

        // atualiza os dados do carrinho na sessão
        $_SESSION['carrinho'] = $carrinho;

        // devolve a resposta (número de produtos do carrinho)
        $total_produtos = 0;
        foreach ($carrinho as $quantidade) {
            $total_produtos += $quantidade;
        }
        echo $total_produtos;
    }

    // ===========================================================
    public function remover_produto_carrinho()
    {

        // vai buscar o id_produto na query string
        $id_produto = $_GET['id_produto'];

        // buscar o carrinho à sessão
        $carrinho = $_SESSION['carrinho'];

        // remover o produto do carrinho
        unset($carrinho[$id_produto]);

        // atualizar o carrinho na sessão
        $_SESSION['carrinho'] = $carrinho;

        // apresentar novamente a página do carrinho
        $this->carrinho();
    }

    // ===========================================================
    public function limpar_carrinho()
    {

        // limpa o carrinho de todos os produtos
        unset($_SESSION['carrinho']);

        // refrescar a página do carrinho
        $this->carrinho();
    }

    // ===========================================================
    public function carrinho()
    {
        // verificar se existe carrinho
        if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0) {
            $dados = [
                'carrinho' => null
            ];
        } else {

            $ids = [];
            foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
                array_push($ids, $id_produto);
            }
            $ids = implode(",", $ids);
            $produtos = new Produtos();
            $resultados = $produtos->buscar_produtos_por_ids($ids);

            $dados_tmp = [];
            foreach ($_SESSION['carrinho'] as $id_produto => $quantidade_carrinho) {

                // imagem do produto
                foreach ($resultados as $produto) {
                    if ($produto->id_produto == $id_produto) {
                        $id_produto = $produto->id_produto;
                        $imagem = $produto->imagem;
                        $titulo = $produto->nome_produto;
                        $quantidade = $quantidade_carrinho;
                        $preco = $produto->preco * $quantidade;

                        // colocar o produto na coleção
                        array_push($dados_tmp, [
                            'id_produto' => $id_produto,
                            'imagem' => $imagem,
                            'titulo' => $titulo,
                            'quantidade' => $quantidade,
                            'preco' => $preco
                        ]);

                        break;
                    }
                }
            }

            // calcular o total
            $total_da_encomenda = 0;
            foreach ($dados_tmp as $item) {
                $total_da_encomenda += $item['preco'];
            }
            array_push($dados_tmp, $total_da_encomenda);

            // colocar o preço total na sessao
            $_SESSION['total_encomenda'] = $total_da_encomenda;

            $dados = [
                'carrinho' => $dados_tmp
            ];
        }

        // apresenta a página do carrinho
        Store::Layout([
            'layouts/header',
            'carrinho',
            'layouts/footer',
        ], $dados);
    }

    // ===========================================================
    public function morada_alternativa(){

        // receber os dados via AJAX(axios)
        $post = json_decode(file_get_contents('php://input'), true);

        // adiciona ou altera na sessão a variável (coleção / array) dados_alternativos
        $_SESSION['dados_alternativos'] = [
            'morada' => $post['morada'],

            'email' => $post['text_email'],
            'telefone' => $post['telefone'],
        ];
    }

    // ===========================================================
    public function finalizar_encomenda()
    {

        // verifica se existe cliente logado
        if (!isset($_SESSION['cliente'])) {

            // coloca na sessão um referrer temporário
            $_SESSION['tmp_carrinho'] = true;

            // redirecionar para o quadro de login
            Store::redirect('login');
        } else {

            Store::redirect('finalizar_encomenda_resumo');
        }
    }

    // ===========================================================
    public function finalizar_encomenda_resumo()
    {

        // verifica se existe cliente logado
        if(!isset($_SESSION['cliente'])){
            Store::redirect('inicio');
        }

        // verifica se pode avançar para a gravação da encomenda
        if(!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0){
            Store::redirect('inicio');
            return;
        }

        // -------------------------------------------------------
        // informações do carrinho
        $ids = [];
        foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
            array_push($ids, $id_produto);
        }
        $ids = implode(",", $ids);
        $produtos = new Produtos();
        $resultados = $produtos->buscar_produtos_por_ids($ids);

        $dados_tmp = [];
        foreach ($_SESSION['carrinho'] as $id_produto => $quantidade_carrinho) {

            // imagem do produto
            foreach ($resultados as $produto) {
                if ($produto->id_produto == $id_produto) {
                    $id_produto = $produto->id_produto;
                    $imagem = $produto->imagem;
                    $titulo = $produto->nome_produto;
                    $quantidade = $quantidade_carrinho;
                    $preco = $produto->preco * $quantidade;

                    // colocar o produto na coleção
                    array_push($dados_tmp, [
                        'id_produto' => $id_produto,
                        'imagem' => $imagem,
                        'titulo' => $titulo,
                        'quantidade' => $quantidade,
                        'preco' => $preco
                    ]);

                    break;
                }
            }
        }

        // calcular o total
        $total_da_encomenda = 0;
        foreach ($dados_tmp as $item) {
            $total_da_encomenda += $item['preco'];
        }
        array_push($dados_tmp, $total_da_encomenda);

        // preparar os dados da view
        $dados = [];
        $dados['carrinho'] = $dados_tmp;

        // -------------------------------------------------------
        // buscar informações do cliente
        $cliente = new Clientes();
        $dados_cliente = $cliente->buscar_dados_cliente($_SESSION['cliente']);
        $dados['cliente'] = $dados_cliente;

        // -------------------------------------------------------
        // gerar o código da encomenda
        if(!isset($_SESSION['codigo_encomenda'])){
            $codigo_encomenda = Store::gerarCodigoEncomenda();
            $_SESSION['codigo_encomenda'] = $codigo_encomenda;
        }

        // apresenta a página do carrinho
        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'encomenda_resumo',
            'layouts/footer',
            'layouts/html_footer',
        ], $dados);
    }

    // ===========================================================
    public function confirmar_encomenda(){

        // verifica se existe cliente logado
        if(!isset($_SESSION['cliente'])){
            Store::redirect('inicio');            
        }

        // verifica se pode avançar para a gravação da encomenda
        if(!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0){
            Store::redirect('inicio');
            return;
        }

        // ---------------------------------------
        // enviar email para o cliente com os dados da encomenda e pagamento
        $dados_encomenda = [];

        // buscar os dados dos produtos
        $ids = [];
        foreach ($_SESSION['carrinho'] as $id_produto => $quantidade) {
            array_push($ids, $id_produto);
        }
        $ids = implode(",", $ids);
        $produtos = new Produtos();
        $produtos_da_encomenda = $produtos->buscar_produtos_por_ids($ids);
        
        // estrutura dos dados dos produtos
        $string_produtos = [];

        foreach($produtos_da_encomenda as $resultado){
        
            // quantidade
            $quantidade = $_SESSION['carrinho'][$resultado->id_produto];

            // string do produto
            $string_produtos[] = "$quantidade x $resultado->nome_produto - " . number_format($resultado->preco,2,',','.') . ' kzs / Uni.';
        }

        // lista de produtos para o email
        $dados_encomenda['lista_produtos'] = $string_produtos;

        // preco total da encomenda para o email
        $dados_encomenda['total'] = number_format($_SESSION['total_encomenda'],2,',','.') . ' kzs';

        // dados de pagamento
        $dados_encomenda['dados_pagamento'] = [
            'numero_da_conta' => '123456789',
            'codigo_encomenda' => $_SESSION['codigo_encomenda'],
            'total' => number_format($_SESSION['total_encomenda'],2,',','.') . ' kzs'
        ];

        // enviar o email para o cliente com os dados da encomenda
        $email = new EnviarEmail();
        $resultado = $email->enviar_email_confirmacao_encomenda($_SESSION['usuario'], $dados_encomenda);

        // ---------------------------------------
        // guardar na base de dados a encomenda

        $dados_encomenda = [];
        $dados_encomenda['id_cliente'] = $_SESSION['cliente'];
        // morada
        if(isset($_SESSION['dados_alternativos']['morada']) && !empty($_SESSION['dados_alternativos']['morada'])){
            
            // considerar a morada alternativa
            $dados_encomenda['morada'] = $_SESSION['dados_alternativos']['morada'];
            $dados_encomenda['cidade'] = $_SESSION['dados_alternativos']['cidade'];
            $dados_encomenda['email'] = $_SESSION['dados_alternativos']['email'];
            $dados_encomenda['telefone'] = $_SESSION['dados_alternativos']['telefone'];
        } else {

            // considerar a morada do cliente na base de dados
            $CLIENTE = new Clientes();
            $dados_cliente = $CLIENTE->buscar_dados_cliente($_SESSION['cliente']);

            $dados_encomenda['morada'] = $dados_cliente->morada;
            $dados_encomenda['cidade'] = $dados_cliente->cidade;
            $dados_encomenda['email'] = $dados_cliente->email;
            $dados_encomenda['telefone'] =$dados_cliente->telefone;
        }

        // codigo encomenda
        $dados_encomenda['codigo_encomenda'] = $_SESSION['codigo_encomenda'];

        // status
        $dados_encomenda['status'] = 'PENDENTE';
        $dados_encomenda['mensagem'] = '';
        
        // -----------------------------------
        // dados dos produtos da encomenda
        // $produtos_da_encomenda (nome_produto, preco)
        $dados_produtos = [];
        foreach($produtos_da_encomenda as $produto){
            $dados_produtos[] = [
                'designacao_produto' => $produto->nome_produto,
                'preco_unidade' => $produto->preco,
                'quantidade' => $_SESSION['carrinho'][$produto->id_produto]
            ];
        }

        $encomenda = new Encomendas();
        $encomenda->guardar_encomenda($dados_encomenda, $dados_produtos);

        // preparar dados para apresentar na página de agradecimento
        $codigo_encomenda = $_SESSION['codigo_encomenda'];
        $total_encomenda = $_SESSION['total_encomenda'];

        // ---------------------------------------
        // limpar todos os dados da encomenda que estão no carrinho
        unset($_SESSION['codigo_encomenda']);
        unset($_SESSION['carrinho']);
        unset($_SESSION['total_encomenda']);
        unset($_SESSION['dados_alternativos']);

        // ---------------------------------------
        // apresenta a página a agradecer a encomenda
        $dados = [
            'codigo_encomenda' => $codigo_encomenda,
            'total_encomenda' => $total_encomenda
        ];
        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'encomenda_confirmada',
            'layouts/footer',
            'layouts/html_footer',
        ], $dados);
    }
}
