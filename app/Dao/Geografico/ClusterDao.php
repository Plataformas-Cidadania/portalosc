<?php

namespace App\Dao\Geografico;

use App\Enums\TipoRegiaoEnum;
use App\Dao\DaoPostgres;

class ClusterDao extends DaoPostgres{
    public function obterCluster($tipoRegiao, $idRegiao){
        $result = null;
        
        if(!is_int($tipoRegiao)){
            if($tipoRegiao == 'regiao'){
                $tipoRegiao = TipoRegiaoEnum::REGIAO;
            }elseif($tipoRegiao == 'estado'){
                $tipoRegiao = TipoRegiaoEnum::ESTADO;
            }elseif($tipoRegiao == 'municipio'){
                $tipoRegiao = TipoRegiaoEnum::MUNICIPIO;
            }
        }
        
        if($idRegiao == null){
            $idRegiao = 0;
        }
        
        $query = 'SELECT * FROM portal.obter_geo_cluster(?::INTEGER, ?::INTEGER);';
        $result = $this->executarQuery($query, false, [$tipoRegiao, $idRegiao]);
        
        return $result;
    }
}