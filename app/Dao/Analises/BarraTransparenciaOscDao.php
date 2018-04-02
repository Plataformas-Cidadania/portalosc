<?php

namespace App\Dao\Analises;

use App\Dao\DaoPostgres;

class BarraTransparenciaOscDao extends DaoPostgres
{
    public function obterBarraTransparenciaOsc($idOsc)
    {
    	$query = 'SELECT * FROM portal.vw_osc_barra_transparencia WHERE id_osc = ?::INTEGER;';
        $params = [$idOsc];
        
        return $this->executarQuery($query, true, $params);
    }
}