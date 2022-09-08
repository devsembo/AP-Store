<?php



namespace core\controllers;



use core\classes\Database;

use core\classes\EnviarEmail;

use core\classes\PDF;

use core\classes\Store;

use core\models\AdminModel;

use core\models\Produtos;



class admin

{

    // ===========================================================

    // usuário admin: admin@admin.com

    // senha:         123456

    //        echo  password_hash('09876', PASSWORD_DEFAULT);

    // Usuario admin: Sidney@outlook.com

    //senha: 98765

    // ===========================================================

    public function index()

    {



        // verifica se já existe sessão aberta (admin)

        if (!Store::adminLogado()) {

            Store::redirect('admin_login', true);

            return;
        }



        // verificar se existem encomendas em estado PENDENTE

        $ADMIN = new AdminModel();

        $total_encomendas_pendentes = $ADMIN->total_encomendas_pendentes();

        $total_encomendas_em_processamento = $ADMIN->total_encomendas_em_processamento();



        $data = [

            'total_encomendas_pendentes' => $total_encomendas_pendentes,

            'total_encomendas_em_processamento' => $total_encomendas_em_processamento

        ];



        // já existe um admin logado

        Store::Layout_admin([

            'admin/layouts/html_header',

            'admin/layouts/header',

            'admin/home',

            'admin/layouts/footer',

            'admin/layouts/html_footer',

        ], $data);
    }





    // ===========================================================

    // AUTENTICAÇÃO

    // ===========================================================

    public function admin_login()

    {



        if (Store::adminLogado()) {

            Store::redirect('inicio', true);

            return;
        }



        // apresenta o quadro de login

        Store::Layout_admin([

            'admin/layouts/html_header',

            'admin/layouts/header',

            'admin/login_frm',

            'admin/layouts/footer',

            'admin/layouts/html_footer',

        ]);
    }



    // ===========================================================

    public function admin_login_submit()

    {

        // verifica se já existe um utilizador logado

        if (Store::adminLogado()) {

            Store::redirect('inicio', true);

            return;
        }



        // verifica se foi efetuado o post do formulário de login do admin

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {

            Store::redirect('inicio', true);

            return;
        }



        // validar se os campos vieram corretamente preenchidos

        if (

            !isset($_POST['text_admin']) ||

            !isset($_POST['text_senha']) ||

            !filter_var(trim($_POST['text_admin']), FILTER_VALIDATE_EMAIL)

        ) {

            // erro de preenchimento do formulário

            $_SESSION['erro'] = 'Login inválido';

            Store::redirect('admin_login', true);

            return;
        }



        // prepara os dados para o model

        $admin = trim(strtolower($_POST['text_admin']));

        $senha = trim($_POST['text_senha']);



        // carrega o model e verifica se login é válido

        $admin_model = new AdminModel();

        $resultado = $admin_model->validar_login($admin, $senha);



        // analisa o resultado

        if (is_bool($resultado)) {



            // login inválido

            $_SESSION['erro'] = 'Login inválido';

            Store::redirect('login', true);

            return;
        } else {



            // login válido. Coloca os dados na sessão do admin

            $_SESSION['admin'] = $resultado->id_admin;

            $_SESSION['admin_usuario'] = $resultado->usuario;



            // redirecionar para a página inicial do backoffice

            Store::redirect('inicio', true);
        }
    }



    // ===========================================================

    public function admin_logout()

    {



        // faz o logout do admin da sessão

        unset($_SESSION['admin']);

        unset($_SESSION['admin_usuario']);



        // redirecionar para o início

        Store::redirect('inicio', true);
    }









    // ===========================================================

    // CLIENTES

    // ===========================================================

    public function lista_clientes()

    {

        // verifica se existe um admin logado

        if (!Store::adminLogado()) {

            Store::redirect('inicio', true);

            return;
        }



        // vai buscar a lista de clientes

        $ADMIN = new AdminModel();

        $clientes = $ADMIN->lista_clientes();

        $data = [

            'clientes' => $clientes

        ];



        // apresenta a página da lista de clientes

        Store::Layout_admin([

            'admin/layouts/html_header',

            'admin/layouts/header',

            'admin/lista_clientes',

            'admin/layouts/footer',

            'admin/layouts/html_footer',

        ], $data);
    }



    // ===========================================================

    public function detalhe_cliente()

    {

        // verifica se existe um admin logado

        if (!Store::adminLogado()) {

            Store::redirect('inicio', true);

            return;
        }



        // verifica se existe um id_cliente na query string

        if (!isset($_GET['c'])) {

            Store::redirect('inicio', true);

            return;
        }



        $id_cliente = Store::aesDesencriptar($_GET['c']);

        // verifica se o id_cliente é válido

        if (empty($id_cliente)) {

            Store::redirect('inicio', true);

            return;
        }



        // buscar os dados do cliente

        $ADMIN = new AdminModel();

        $data = [

            'dados_cliente' => $ADMIN->buscar_cliente($id_cliente),

            'total_encomendas' => $ADMIN->total_encomendas_cliente($id_cliente)

        ];



        // apresenta a página das encomendas

        Store::Layout_admin([

            'admin/layouts/html_header',

            'admin/layouts/header',

            'admin/detalhe_cliente',

            'admin/layouts/footer',

            'admin/layouts/html_footer',

        ], $data);
    }



    // ===========================================================

    public function cliente_historico_encomendas()

    {

        // verifica se existe um admin logado

        if (!Store::adminLogado()) {

            Store::redirect('inicio', true);

            return;
        }



        // verifica se existe o id_cliente encriptado

        if (!isset($_GET['c'])) {

            Store::redirect('inicio', true);
        }



        // definir o id_cliente que vem encriptado

        $id_cliente = Store::aesDesencriptar($_GET['c']);

        $ADMIN = new AdminModel();



        $data = [

            'cliente' => $ADMIN->buscar_cliente($id_cliente),

            'lista_encomendas' => $ADMIN->buscar_encomendas_cliente($id_cliente)

        ];



        // apresenta a página das encomendas

        Store::Layout_admin([

            'admin/layouts/html_header',

            'admin/layouts/header',

            'admin/lista_encomendas_cliente',

            'admin/layouts/footer',

            'admin/layouts/html_footer',

        ], $data);
    }



    // ===========================================================
    // PRODUTOS
    // ===========================================================
    public function lista_produtos()
    {
        // verifica se existe um admin logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }

        // vai buscar a lista de clientes
        $ADMIN = new AdminModel();
        $produtos = $ADMIN->lista_produtos();
        $data = [
            'produtos' => $produtos
        ];

        // apresenta a página da lista de clientes
        Store::Layout_admin([
            'admin/layouts/html_header',

            'admin/layouts/header',

            'admin/lista_produtos',

            'admin/layouts/footer',

            'admin/layouts/html_footer',
        ], $data);
    }

    // ===========================================================
    public function detalhe_produto()
    {


        // verifica se existe um admin logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }

        // verifica se existe um id_cliente na query string
        if (!isset($_GET['c'])) {
            Store::redirect('inicio', true);
            return;
        }
        // vai buscar a lista de clientes
        $ADMIN = new AdminModel();
        $produtos = $ADMIN->lista_produtos();

        $id_produto = Store::aesDesencriptar($_GET['c']);
        // verifica se o id_cliente é válido
        if (empty($id_produto)) {
            Store::redirect('inicio', true);
            return;
        }

        // buscar os dados do cliente
        $produto = new Produtos();
        $dados = [
            'dados_produtos' => $produto->buscar_dados_produto($id_produto),
            'produtos' => $produtos
            //'total_encomendas' => $ADMIN->total_encomendas_cliente($id_produto)
        ];

        // apresenta a página das encomendas
        Store::Layout_admin([
            'admin/layouts/html_header',

            'admin/layouts/header',

            'admin/detalhe_produto',

            'admin/layouts/footer',

            'admin/layouts/html_footer',
        ], $dados);
    }
    

    public function editar_produto_submit()
    {
        // verifica se existe um admin logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }

        // verifica se houve submissão de um formulário
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->index();
            return;
        }



        // validar dados
        $id_produto = trim($_POST['id_produto']);
        $categoria = trim($_POST['categoria']);
        $nome_produto = trim($_POST['nome_produto']);
        $descricao = trim($_POST['descricao']);
        $imagem = trim($_POST['imagem']);
        $preco = trim($_POST['preco']);
        $stock = trim($_POST['stock']);
        $visivel = trim($_POST['visivel']);

        // validar rapidamente os restantes campos
        if (
           empty($id_produto)  || empty($categoria) || empty($nome_produto) || empty($descricao) ||
            empty($imagem) || empty($preco) || empty($stock)
        ) {
            $_SESSION['erro'] = "Preencha corretamente o formulário.";
            $this->detalhe_produto();
            return;
        }

        // validar se este email já existe noutra conta de cliente
        $produto = new Produtos();
        $existe_noutra_conta = $produto->verificar_se_nome_existe_noutro_produto($id_produto, $nome_produto);
        if ($existe_noutra_conta) {
            $_SESSION['erro'] = "Este nome já existe noutro produto.";
            $this->detalhe_produto();
            return;
        }

        // atualizar os dados do cliente na base de dados
        $produto->atualizar_dados_produto($id_produto, $categoria, $nome_produto, $descricao, $imagem, $preco, $stock, $visivel);

        // redirecionar para a página do perfil
        Store::redirect('detalhe_produto', true);
    }

    // ===========================================================
    public function inserir_produto_submit()
    {
        //die ('Aquiii');
        // verifica se o admin está logado 
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }
        // verifica se houve submissão de um formulário
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->index();
            return;
        }



        $produto = new AdminModel();
        $produto->inserir_produto();


        // redirecionar para a página inicial do backoffice
        Store::redirect('inicio', true);
    }


    public function inserir_imagens_submit()
    {
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }
        // verifica se houve submissão de um formulário
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->index();
            return;
        }

        $imagem = new AdminModel();
        $imagem->inserir_imagem();

        // redirecionar para a página inicial do backoffice
        Store::redirect('inicio', true);
    }


    public function eliminar_produto()
    {
        // verifica se existe um admin logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }

        // verifica se existe um id_cliente na query string
        if (!isset($_GET['c'])) {
            Store::redirect('inicio', true);
            return;
        }

        $id_produto = Store::aesDesencriptar($_GET['c']);
        // verifica se o id_produto é válido
        if (empty($id_produto)) {
            Store::redirect('inicio', true);
            return;
        }

        $produto = new AdminModel();
        $produto->eliminar_produto($id_produto);

    }

    //============================================================
    // Animais
    // ===========================================================
    public function inserir_animal_submit()
    {

        // verifica se existe um admin logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }
        // verifica se houve submissão de um formulário
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->index();
            return;
        }

        $animal = new AdminModel();
        $animal->inserir_produto();

        // redirecionar para a página inicial do backoffice
        Store::redirect('inicio', true);
    }



    // ===========================================================

    // ENCOMENDAS

    // ===========================================================

    public function lista_encomendas()

    {

        // verifica se existe um admin logado

        if (!Store::adminLogado()) {

            Store::redirect('inicio', true);

            return;
        }



        // apresenta a lista de encomendas (usando filtro se for o caso)

        // verifica se existe um filtro da query string

        $filtros = [

            'pendente' => 'PENDENTE',

            'em_processamento' => 'EM PROCESSAMENTO',

            'cancelada' => 'CANCELADA',

            'enviada' => 'ENVIADA',

            'concluida' => 'CONCLUIDA',

        ];



        $filtro = '';

        if (isset($_GET['f'])) {



            // verifica se a variável é uma key dos filtros

            if (key_exists($_GET['f'], $filtros)) {

                $filtro = $filtros[$_GET['f']];
            }
        }



        // vai buscar o id cliente se existir na query string

        $id_cliente = null;

        if (isset($_GET['c'])) {

            $id_cliente = Store::aesDesencriptar($_GET['c']);
        }



        // carregar a lista de encomendas

        $admin_model = new AdminModel();

        $lista_encomendas = $admin_model->lista_encomendas($filtro, $id_cliente);



        $data = [

            'lista_encomendas' => $lista_encomendas,

            'filtro' => $filtro

        ];



        // apresenta a página das encomendas

        Store::Layout_admin([

            'admin/layouts/html_header',

            'admin/layouts/header',

            'admin/lista_encomendas',

            'admin/layouts/footer',

            'admin/layouts/html_footer',

        ], $data);
    }



    // ===========================================================

    public function detalhe_encomenda()

    {

        // verifica se existe um admin logado

        if (!Store::adminLogado()) {

            Store::redirect('inicio', true);

            return;
        }



        //buscar o id_encomenda

        $id_encomenda = null;

        if (isset($_GET['e'])) {

            $id_encomenda = Store::aesDesencriptar($_GET['e']);
        }

        if (gettype($id_encomenda) != 'string') {

            Store::redirect('inicio', true);

            return;
        }



        //carregar os dados da encomenda selecionada

        $admin_model = new AdminModel();

        $encomenda = $admin_model->buscar_detalhes_encomenda($id_encomenda);



        //apresentar os dados por forma a poder ver os detalhes e alterar o seu status

        $data = $encomenda;

        Store::Layout_admin([

            'admin/layouts/html_header',

            'admin/layouts/header',

            'admin/encomenda_detalhe',

            'admin/layouts/footer',

            'admin/layouts/html_footer',

        ], $data);
    }



    // ===========================================================

    public function encomenda_alterar_estado()

    {

        // verifica se existe um admin logado

        if (!Store::adminLogado()) {

            Store::redirect('inicio', true);

            return;
        }



        //buscar o id_encomenda

        $id_encomenda = null;

        if (isset($_GET['e'])) {

            $id_encomenda = Store::aesDesencriptar($_GET['e']);
        }

        if (gettype($id_encomenda) != 'string') {

            Store::redirect('inicio', true);

            return;
        }



        // buscar o novo estado

        $estado = null;

        if (isset($_GET['s'])) {

            $estado = $_GET['s'];
        }

        if (!in_array($estado, STATUS)) {

            Store::redirect('inicio', true);

            return;
        }



        // regras de negócio para gerir a encomenda (novo estado)



        // atualizar o estado da encomenda na base de dados

        $admin_model = new AdminModel();

        $admin_model->atualizar_status_encomenda($id_encomenda, $estado);



        // executar operações baseadas no novo estado

        switch ($estado) {

            case 'PENDENTE':

                // não existem ações

                $this->operacao_notificar_cliente_mudanca_estado($id_encomenda);

                break;



            case 'EM PROCESSAMENTO':

                // não existem ações

                break;



            case 'ENVIADA':

                // enviar um email com a notificação ao cliente sobre o envio da encomenda

                $this->operacao_notificar_cliente_mudanca_estado($id_encomenda);

                $this->operacao_enviar_email_encomenda_enviada($id_encomenda);



                break;



            case 'CANCELADA':

                $this->operacao_notificar_cliente_mudanca_estado($id_encomenda);

                break;



            case 'CONCLUIDA':

                $this->operacao_notificar_cliente_mudanca_estado($id_encomenda);

                break;
        }



        // redireciona para a página da própria encomenda

        Store::redirect('detalhe_encomenda&e=' . $_GET['e'], true);
    }





    // ===========================================================

    // OPERAÇÕES APÓS MUDANÇA DE ESTADO

    // ===========================================================



    public function operacao_notificar_cliente_mudanca_estado($id_encomenda)

    {

        // vai enviar um email para o cliente indicando que a encomenda sofreu alterações

    }



    // ===========================================================

    private function operacao_enviar_email_encomenda_enviada($id_encomenda)

    {

        // executar as operações para enviar email ao cliente.

    }



    // ===========================================================

    public function criar_pdf_encomenda()

    {

        // verifica se existe um admin logado

        if (!Store::adminLogado()) {

            Store::redirect('inicio', true);

            return;
        }



        //buscar o id_encomenda

        $id_encomenda = null;

        if (isset($_GET['e'])) {

            $id_encomenda = Store::aesDesencriptar($_GET['e']);
        }

        if (gettype($id_encomenda) != 'string') {

            Store::redirect('inicio', true);

            return;
        }



        // vai buscar os dados da encomenda

        $id_encomenda = Store::aesDesencriptar($_GET['e']);

        $admin_model = new AdminModel();

        $encomenda = $admin_model->buscar_detalhes_encomenda($id_encomenda);



        // criar o PDF com os detalhes da encomenda

        $pdf = new PDF();

        $pdf->set_template(getcwd() . '/assets/templates_pdf/fatura2k21.pdf');



        // preparar opções base do pdf

        $pdf->set_letra_familia('Arial');

        $pdf->set_letra_tamanho('13px');

        $pdf->set_tipo_letra('bold');



        // data encomenda 

        $pdf->posicao_dimensao(255, 240, 146, 22);

        $pdf->escrever($encomenda['encomenda']->data_encomenda);



        // código encomenda 

        $pdf->posicao_dimensao(585, 240, 157, 22);

        $pdf->escrever($encomenda['encomenda']->codigo_encomenda);



        //===========================================================================        

        // dados do cliente



        // Nome 

        $pdf->posicao_dimensao(60, 340, 500, 30);

        $pdf->escrever($encomenda['encomenda']->nome_completo);



        // Morada 

        $pdf->posicao_dimensao(60, 360, 500, 30);

        $pdf->escrever($encomenda['encomenda']->morada . ' - ' . $encomenda['encomenda']->cidade);



        // Email

        $pdf->posicao_dimensao(60, 380, 200, 30);

        $pdf->escrever($encomenda['encomenda']->email);



        // Contacto

        $pdf->posicao_dimensao(60, 400, 200, 30);

        $pdf->escrever($encomenda['encomenda']->telefone);



        // ==========================================================================        

        // LISTA DOS PRODUTOS

        $y = 540;

        $total_encomenda = 0;

        $pdf->set_tipo_letra('regular');



        foreach ($encomenda['lista_produtos'] as $produto) {

            //localização da apresentação do produto 

            $pdf->set_alinhamento('left');

            $pdf->posicao_dimensao(75, $y, 470, 30);

            $pdf->escrever($encomenda['lista_produtos'][0]->quantidade . ' X ' . $produto->designacao_produto);



            //preço do produto

            $pdf->set_alinhamento('right');

            $pdf->posicao_dimensao(550, $y, 180, 30);

            $preco = $produto->quantidade * $produto->preco_unidade;

            $total_encomenda += $preco;

            $pdf->escrever(number_format($preco, 2, ',', '.') . ' kzs');



            $y += 26;
        }



        // Apresenta o preço total  

        $pdf->set_tipo_letra('bold');

        $pdf->set_cor('white');

        $pdf->posicao_dimensao(420, 878, 195, 24);

        //$preco = $produto->quantidade * $produto->preco_unidade;

        $pdf->escrever('Total a pagar:');



        $pdf->posicao_dimensao(545, 878, 194, 24);

        $pdf->escrever(number_format($total_encomenda, 2, ',', '.') . ' kzs');





        //================================================================================        

        // Apresentar o pdf

        $pdf->apresentar_pdf();
    }



    public function enviar_pdf_encomenda()

    {

        // verifica se existe um admin logado

        if (!Store::adminLogado()) {

            Store::redirect('inicio', true);

            return;
        }



        //buscar o id_encomenda

        $id_encomenda = null;

        if (isset($_GET['e'])) {

            $id_encomenda = Store::aesDesencriptar($_GET['e']);
        }

        if (gettype($id_encomenda) != 'string') {

            Store::redirect('inicio', true);

            return;
        }



        // vai buscar os dados da encomenda

        $id_encomenda = Store::aesDesencriptar($_GET['e']);

        $admin_model = new AdminModel();

        $encomenda = $admin_model->buscar_detalhes_encomenda($id_encomenda);



        // criar o PDF com os detalhes da encomenda

        $pdf = new PDF();

        $pdf->set_template(getcwd() . '/assets/templates_pdf/fatura2k21.pdf');



        // preparar opções base do pdf

        $pdf->set_letra_familia('Arial');

        $pdf->set_letra_tamanho('13px');

        $pdf->set_tipo_letra('bold');



        // data encomenda 

        $pdf->posicao_dimensao(255, 245, 143, 22);

        $pdf->escrever($encomenda['encomenda']->data_encomenda);



        // código encomenda 

        $pdf->posicao_dimensao(585, 245, 155, 22);

        $pdf->escrever($encomenda['encomenda']->codigo_encomenda);



        //===========================================================================        

        // dados do cliente



        // Nome 

        $pdf->posicao_dimensao(60, 340, 500, 30);

        $pdf->escrever($encomenda['encomenda']->nome_completo);



        // Morada 

        $pdf->posicao_dimensao(60, 360, 500, 30);

        $pdf->escrever($encomenda['encomenda']->morada . ' - ' . $encomenda['encomenda']->cidade);



        // Email

        $pdf->posicao_dimensao(60, 380, 200, 30);

        $pdf->escrever($encomenda['encomenda']->email);



        // Contacto

        $pdf->posicao_dimensao(60, 400, 200, 30);

        $pdf->escrever($encomenda['encomenda']->telefone);



        // ==========================================================================        

        // LISTA DOS PRODUTOS

        $y = 540;

        $total_encomenda = 0;

        $pdf->set_tipo_letra('regular');



        foreach ($encomenda['lista_produtos'] as $produto) {

            //localização da apresentação do produto 

            $pdf->set_alinhamento('left');

            $pdf->posicao_dimensao(75, $y, 470, 30);

            $pdf->escrever($encomenda['lista_produtos'][0]->quantidade . ' X ' . $produto->designacao_produto);



            //preço do produto

            $pdf->set_alinhamento('right');

            $pdf->posicao_dimensao(550, $y, 180, 30);

            $preco = $produto->quantidade * $produto->preco_unidade;

            $total_encomenda += $preco;

            $pdf->escrever(number_format($preco, 2, ',', '.') . ' kzs');



            $y += 26;
        }



        // Apresenta o preço total  

        $pdf->set_tipo_letra('bold');

        $pdf->set_cor('white');

        $pdf->posicao_dimensao(420, 883, 195, 24);

        //$preco = $produto->quantidade * $produto->preco_unidade;

        $pdf->escrever('Total a pagar:');



        $pdf->posicao_dimensao(545, 883, 194, 24);

        $pdf->escrever(number_format($total_encomenda, 2, ',', '.') . ' kzs');



        // definir permissões e proteção

        $pdf->set_permissoes([]);



        // Apresentar o pdf

        $ficheiro = $encomenda['encomenda']->codigo_encomenda . ' _' . date('Y-m-d-His') . '.pdf';

        $pdf->guardar_pdf($ficheiro);





        // enviar o email com o ficheiro em anexo

        $email = new EnviarEmail();

        $email->enviar_pdf_encomenda_para_cliente($encomenda['encomenda']->email, $ficheiro);



        // Eliminar o ficheiro pdf enviado

        unlink(PDF_PATH . $ficheiro);

        Store::redirect('detalhe_encomenda&e=' . $_GET['e'], true);
    }
}
