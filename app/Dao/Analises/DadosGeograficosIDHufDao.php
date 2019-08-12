<?php

namespace App\Dao\Analises;

use App\Dao\DaoPostgres;
//use Illuminate\Support\Facades\DB;

class DadosGeograficosIDHufDao extends DaoPostgres {

    public function obterDadosGeograficosIDHuf($modelo){

        $result = array();

        $query = 'SELECT * FROM ipeadata.obter_dados_geograficos_idh_uf();';

        $result = $this->executarQuery($query, true);

        return $result;
    }
}