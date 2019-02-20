<?php

namespace App\Dao\Componente;

use App\Dao\DaoPostgres;

class ComponenteDao extends DaoPostgres{
    private $queries = array(
        'metasobjetivoprojeto' => [
            'query' => 'SELECT cd_meta_projeto, tx_codigo_meta_projeto || \' \' || tx_nome_meta_projeto AS tx_nome_meta_projeto FROM syst.dc_meta_projeto WHERE cd_objetivo_projeto = ?::INTEGER ORDER BY cd_meta_projeto;', 
            'unique' => false
        ]
    );
    
    public function obterComponente($componente, $parametro = null){
        $resultado = null;
        
        $componenteAjustado = str_replace([' ', '_', '-'], '', $componente);

        if($parametro && array_key_exists($componenteAjustado, $this->queries)){
            $queryList = $this->queries[$componenteAjustado];
            
            $query = $queryList['query'];
            $unique = $queryList['unique'];
            $params = [$parametro];

            $resultado = $this->executarQuery($query, $unique, $params);
        }
        
        return $resultado;
    }
}