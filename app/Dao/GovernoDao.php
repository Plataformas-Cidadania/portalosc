<?php

namespace App\Dao;

use App\Dao\DaoMongoDb;

class GovernoDao extends DaoMongoDb
{
    public function inserirAtualizarParceria($dados)
    {
        $query = array(
            'id_parceria' => $dados['id_parceria'],
            'id_localidade' => $dados['id_localidade']
        );
        
        return $this->executarUpsert($dados, $query);
    }
}
