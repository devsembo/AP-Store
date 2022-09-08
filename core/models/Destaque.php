<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class Destaque
{

    public function mostar_destaque()
    {
        // buscar as informações dos prodtudos a base de dados  
        $bd = new Database();

        $destaque = $bd->select("
            SELECT * FROM imagem_destaque
            WHERE visivel = 1
            ");
        return $destaque;
    }
}
