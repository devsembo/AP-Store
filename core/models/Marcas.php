<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class Marcas{

    //=============================================
    public function listar_marcas(){
        $bd = new Database();

        $mostra_marca = $bd->select("
            SELECT * FROM marcas
            WHERE visivel = 1
        "); return $mostra_marca;
    }
}