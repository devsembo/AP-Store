<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class Produtos_destaque
{


    // ===========================================================
    public function mostrar_produtos_em_destaque()
    {
        $bd = new Database();

        $produto = $bd->select("
            SELECT * FROM produtos_destaque
            WHERE visivel = 1
            ");
        return $produto;
    }

    // ===========================================================
    public function mostrar_produtos_em_destaque_Sec()
    {
        $bd = new Database();

        $produto_sec = $bd->select("
            SELECT * FROM produtos_sec
            WHERE visivel = 1
            ");
        return $produto_sec;

    }

        // ===========================================================
        public function mostrar_produtos_recomendados()
        {
            $bd = new Database();
    
            $recomendados = $bd->select("
                SELECT * FROM recomendados
                WHERE visivel = 1
                ");
            return $recomendados;
    
        }
    

}