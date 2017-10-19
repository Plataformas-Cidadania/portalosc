<?php

namespace App\Dao;

use App\Dao\DaoMongoDb;

class GovernoDao extends DaoMongoDb
{
    public function inserirAtualizarParceria($json)
    {
        return $this->executarUpsert($json);
    }
}
