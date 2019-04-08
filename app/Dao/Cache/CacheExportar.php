<?php

namespace App\Dao\Cache;

use App\Dao\DaoPostgres;

class CacheExportar extends DaoPostgres {
    public function obterExportar($modelo) {
    	$result = array();
        
        $chave = $modelo->chave;
        
		$query = 'SELECT * FROM cache.obter_cache_exportar(?::TEXT);';
		$params = [$chave];
        $result = $this->executarQuery($query, true, $params);
        
        return $result;
    }

    public function inserirExportar($modelo) {
        $result = array();

        $chave = $modelo->chave;
        $valor = $modelo->valor;

        $query = 'SELECT * FROM cache.inserir_cache_exportar(?::TEXT, ?::TEXT);';
        $params = [$chave, $valor];
        $result = $this->executarQuery($query, true, $params);

        return $result;
    }
}