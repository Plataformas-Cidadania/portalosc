<?php

namespace App\Dao\Menu;

use App\Dao\DaoPostgres;

class MenuGeograficoDao extends DaoPostgres{
    private $queriesGeografico = array(
        'municipio' => [
            'query' => 'SELECT * FROM portal.obter_menu_municipio(?::TEXT, ?::INTEGER, ?::INTEGER);', 
            'unique' => false
        ],
        'estado' => [
            'query' => 'SELECT * FROM portal.obter_menu_estado(?::TEXT, ?::INTEGER, ?::INTEGER);', 
            'unique' => false
        ],
        'regiao' => [
            'query' => 'SELECT * FROM portal.obter_menu_regiao(?::TEXT, ?::INTEGER, ?::INTEGER);', 
            'unique' => false
        ]
    );
    
    public function obterMenuGeografico($tipoRegiao, $parametro, $limit, $offset){
        $resultado = null;
        
        $tipoRegiao = str_replace([' ', '_', '-'], '', $tipoRegiao);
        if(array_key_exists($tipoRegiao, $this->queriesGeografico)){
            $queryList = $this->queriesGeografico[$tipoRegiao];
            $query = $queryList['query'];
            $unique = $queryList['unique'];
            $params = [$parametro, $limit, $offset];
            $resultado = $this->executarQuery($query, $unique, $params);
        }
        
        return $resultado;
    }
}