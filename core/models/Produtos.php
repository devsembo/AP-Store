<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class Produtos
{
    // ===========================================================
    public function lista_produtos_disponiveis($categoria)
    {
        // buscar todas as informações dos produtos da base de dados
        $bd = new Database();

        // buscar a lista de categorias da loja
        $categorias = $this->lista_categorias();

        $sql = "SELECT * FROM produtos ";
        $sql .= "WHERE visivel = 1 ";

        if (in_array($categoria, $categorias)) {
            $sql .= "AND categoria = '$categoria'";
        }

        $produtos = $bd->select($sql);
        return $produtos;
    }

    // ===========================================================
    public function lista_categorias()
    {

        // devolve a lista de categorias existentes na base de dados
        $bd = new Database();
        $resultados = $bd->select("SELECT DISTINCT categoria FROM produtos");
        $categorias = [];
        foreach ($resultados as $resultado) {
            array_push($categorias, $resultado->categoria);
        }
        return $categorias;
    }

    // ===========================================================
    public function verificar_stock_produto($id_produto)
    {

        $bd = new Database();
        $parametros = [
            ':id_produto' => $id_produto
        ];
        $resultados = $bd->select("
            SELECT * FROM produtos 
            WHERE id_produto = :id_produto
            AND visivel = 1
            AND stock > 0
        ", $parametros);

        return count($resultados) != 0 ? true : false;
    }

    // ===========================================================
    public function buscar_produtos_por_ids($ids)
    {

        $bd = new Database();
        return $bd->select("
            SELECT * FROM produtos
            WHERE id_produto IN ($ids)
        ");
    }

    // ===========================================================
    public function buscar_dados_produto($id_produto)
    {

        $parametros = [
            'id_produto' => $id_produto
        ];

        $bd = new Database();
        $resultados = $bd->select("
                SELECT 
                id_produto,
                nome_produto,
                preco,
                categoria,
                imagem,
                visivel,
                stock,
                descricao,
                created_at,
                updated_at
                FROM produtos 
                WHERE id_produto = :id_produto
            ", $parametros);
        return $resultados[0];
    }

    // ===========================================================
    public function verificar_se_nome_existe_noutro_produto($id_produto, $nome_produto)
    {

        // verificar se existe a conta de email noutra conta de cliente
        $parametros = [
            ':id_produto' => $id_produto,
            ':nome_produto' => $nome_produto
        ];
        $bd = new Database();
        $resultados = $bd->select("
            SELECT id_cliente
            FROM produtos
            WHERE id_produto <> :id_produto
            AND nome_produto = :nome_produto
        ", $parametros);

        if (count($resultados) != 0) {
            return true;
        } else {
            return false;
        }
    }

    // ===========================================================
    public function atualizar_dados_produto($id_produto, $categoria, $nome_produto, $descricao, $imagem, $preco, $stock, $visivel)
    {
        $bd = new Database();
        $parametros = [
            ':id_produto' => $id_produto,
            ':categoria' => $categoria,
            ':nome_produto' => $nome_produto,
            ':descricao' => $descricao,
            ':imagem' => $imagem,
            ':preco' => $preco,
            ':stock' => $stock,
            ':visivel' => $visivel

        ];

        if (isset($_FILES['ficheirof'])) {

            $name = $_FILES["ficheirof"]["name"];

            $target_dir = "../../public/assets/images/produtos/";
            $target_file = $target_dir . basename($_FILES["ficheirof"]["name"]);
            // Select file type
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Valid file extensions
            $extensions_arr = array("jpg", "jpeg", "png", "gif");

            // Check extension
            if (in_array($imageFileType, $extensions_arr)) {
                // Upload file
                if (move_uploaded_file($_FILES["ficheirof"]["tmp_name"], $target_file));
            }
        }

        $bd->update(
            "
            UPDATE produtos
            SET
                categoria = :categoria,
                nome_produto = :nome_produto,
                descricao = :descricao,
                imagem = :imagem,
                preco = :preco,
                stock = :stock,
                visivel = :visivel,
                updated_at = NOW()
            WHERE id_produto = :id_produto
            ",
            $parametros
        );

        // redirecionar para a página do perfil
        Store::redirect('detalhe_produto', true);
    }
}
