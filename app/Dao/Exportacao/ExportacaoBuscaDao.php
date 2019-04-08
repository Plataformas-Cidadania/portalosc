<?php

namespace App\Dao\Exportacao;

use App\Dao\DaoPostgres;

class ExportacaoBuscaDao extends DaoPostgres{
    public function exportarBusca($modelo){
        $listaOsc = '';
        if(gettype($modelo->listaOsc) == 'array') {
            $listaOsc = '{' . implode(",", $modelo->listaOsc) . '}';
        } else {
            $listaOsc = $modelo->listaOsc;
        }
        
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