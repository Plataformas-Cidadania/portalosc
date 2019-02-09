<?php

namespace App\Dao\Exportacao;

use App\Dao\DaoPostgres;

class ExportacaoBuscaDao extends DaoPostgres{
    public function ExportarBusca($modelo){
        $listaOsc = '{' . implode(",", $modelo->listaOsc) . '}';
        $variaveisAdicionais = '{' . implode(",", $modelo->variaveisAdicionais) . '}';

        $query = '
            SELECT *
            FROM portal.obter_exportacao_busca(?::INTEGER[], ?::INTEGER[])
        ';

        $params = [$listaOsc, $variaveisAdicionais];
        
        $resultadoQuery = $this->executarQuery($query, true, $params);

        return $resultadoQuery;
    }
}