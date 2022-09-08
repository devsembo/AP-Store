<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class Clientes
{

    // ===========================================================
    public function verificar_email_existe($email)
    {

        // verifica se já existe outra conta com o mesmo email
        $bd = new Database();
        $parametros = [
            ':e' => strtolower(trim($email))
        ];
        $resultados = $bd->select("
            SELECT email FROM clientes WHERE email = :e
        ", $parametros);

        // se o cliente já existe...
        if (count($resultados) != 0) {
            return true;
        } else {
            return false;
        }
    }

    // ===========================================================
    public function registar_cliente()
    {

        // regista o novo cliente na base de dados
        $bd = new Database();

        // cria uma hash para o registo do cliente
        $purl = Store::criarHash();

        // parametros
        $parametros = [
            ':email' => strtolower(trim($_POST['email'])),
            ':senha' => password_hash(trim($_POST['senha']), PASSWORD_DEFAULT),
            ':nome_completo' => trim($_POST['nome']),
            ':morada' => trim($_POST['morada']),
            ':telefone' => trim($_POST['telefone']),
            ':purl' => $purl,
            ':ativo' => 0
        ];
        $bd->insert("
            INSERT INTO clientes VALUES(
                0,
                :email,
                :senha,
                :nome_completo,
                :morada,
                :telefone,
                :purl,
                :ativo,
                NOW(),
                NOW(),
                NULL
            )
        ", $parametros);

        // retorna o purl criado
        return $purl;
    }

    // ===========================================================
    public function validar_email($purl)
    {

        // validar o email do novo cliente
        $bd = new Database();
        $parametros = [
            ':purl' => $purl
        ];
        $resultados = $bd->select("
            SELECT * FROM clientes 
            WHERE purl = :purl
        ", $parametros);

        // verifica se foi encontrado o cliente
        if (count($resultados) != 1) {
            return false;
        }

        // foi encontrado este cliente com o purl indicado
        $id_cliente = $resultados[0]->id_cliente;

        // atualizar os dados do cliente
        $parametros = [
            ':id_cliente' => $id_cliente
        ];
        $bd->update("
            UPDATE clientes SET
            purl = NULL,
            activo = 1,
            updated_at = NOW()
            WHERE id_cliente = :id_cliente
        ", $parametros);

        return true;
    }

    // ===========================================================
    public function validar_login($usuario, $senha)
    {

        // verificar se o login é válido
        $parametros = [
            ':usuario' => $usuario
        ];

        $bd = new Database();
        $resultados = $bd->select("
            SELECT * FROM clientes 
            WHERE email = :usuario 
            AND activo = 1 
            AND deleted_at IS NULL
        ", $parametros);

        if (count($resultados) != 1) {

            // não existe usuário
            return false;
        } else {

            // temos usuário. Vamos ver a sua password
            $usuario = $resultados[0];

            // verificar a password
            if (!password_verify($senha, $usuario->senha)) {

                // password inválida
                return false;
            } else {

                // login válido
                return $usuario;
            }
        }
    }

    // ===========================================================
    public function buscar_dados_cliente($id_cliente)
    {

        $parametros = [
            'id_cliente' => $id_cliente
        ];

        $bd = new Database();
        $resultados = $bd->select("
            SELECT 
                email,
                nome_completo,
                morada,
                cidade,
                telefone
            FROM clientes 
            WHERE id_cliente = :id_cliente
        ", $parametros);
        return $resultados[0];
    }

    // ===========================================================
    public function verificar_se_email_existe_noutra_conta($id_cliente, $email)
    {

        // verificar se existe a conta de email noutra conta de cliente
        $parametros = [
            ':email' => $email,
            ':id_cliente' => $id_cliente
        ];
        $bd = new Database();
        $resultados = $bd->select("
            SELECT id_cliente
            FROM clientes
            WHERE id_cliente <> :id_cliente
            AND email = :email
        ", $parametros);

        if (count($resultados) != 0) {
            return true;
        } else {
            return false;
        }
    }

    // ===========================================================
    public function atualizar_dados_cliente($email, $nome_completo)
    {

        // atualiza os dados do cliente na base de dados
        $parametros = [
            ':id_cliente' => $_SESSION['cliente'],
            ':email' => $email,
            ':nome_completo' => $nome_completo
        ];

        $bd = new Database();

        $bd->update("
            UPDATE clientes
            SET
                email = :email,
                nome_completo = :nome_completo,
                updated_at = NOW()
            WHERE id_cliente = :id_cliente
        ", $parametros);
    }

    // ===========================================================
    public function atualizar_dados_entrega($morada, $telefone, $cidade)
    {

        // atualiza os dados do cliente na base de dados
        $parametros = [
            ':id_cliente' => $_SESSION['cliente'],
            ':morada' => $morada,
            ':cidade' => $cidade,
            ':telefone' => $telefone
        ];

        $bd = new Database();

        $bd->update("
            UPDATE clientes
            SET
                morada = :morada,
                cidade = :cidade,
                telefone = :telefone,
                updated_at = NOW()
            WHERE id_cliente = :id_cliente
        ", $parametros);
    }



    // ===========================================================
    public function ver_se_senha_esta_correta($id_cliente, $senha_atual)
    {

        // verifica se a senha atual está correta (de acordo com o que está na base de dados)
        $parametros = [
            ':id_cliente' => $id_cliente
        ];

        $bd = new Database();

        $senha_na_bd = $bd->select("
            SELECT senha 
            FROM clientes 
            WHERE id_cliente = :id_cliente
        ", $parametros)[0]->senha;

        // verificar se a senha corresponde à senha atualmente na bd
        return password_verify($senha_atual, $senha_na_bd);
    }

    // ===========================================================
    public function atualizar_a_nova_senha($id_cliente, $nova_senha)
    {

        // atualização da senha do cliente
        $parametros = [
            ':id_cliente' => $id_cliente,
            ':nova_senha' => password_hash($nova_senha, PASSWORD_DEFAULT)
        ];

        $bd = new Database();
        $bd->update("
            UPDATE clientes
            SET
                senha = :nova_senha,
                updated_at = NOW()
            WHERE id_cliente = :id_cliente
        ", $parametros);
    }
}
