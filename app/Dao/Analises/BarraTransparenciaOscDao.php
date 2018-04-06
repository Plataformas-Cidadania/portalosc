<?php

namespace App\Dao\Analises;

use App\Dao\DaoPostgres;

class BarraTransparenciaOscDao extends DaoPostgres
{
    public function obterBarraTransparenciaOsc($idOsc)
    {
    	$query = 'SELECT * FROM portal.obter_barra_transparencia_osc(?::INTEGER)';
        $params = [$idOsc];
        
        return $this->executarQuery($query, true, $params);
    }
}