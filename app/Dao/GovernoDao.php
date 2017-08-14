<?php

namespace App\Dao;

use App\Dao\DaoMongoDb;

class GovernoDao extends DaoMongoDb
{
    public function inserirParceria($json)
    {
    	return $this->executarInsert($json);
    }
}
