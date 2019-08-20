<?php

trait HasOscTests
{
    public function getIdOscDadosGerais()
    {
        $idOsc = env('ID_OSC_DADOS_GERAIS');
        if (!$idOsc) {
            throw new \InvalidArgumentException(
                'É obrigatório definir a variável de ambiente ID_OSC_DADOS_GERAIS com um id de OSC válido'
            );
        }

        return $idOsc;
    }

    public function getIdsGeoOsc()
    {
        $ids = env('IDS_GEO_OSC');
        if (!$ids) {
            throw new \InvalidArgumentException(
                'É obrigatório definir a variável de ambiente IDS_GEO_OSC com ao menos um id de OSC válido'
            );
        }

        return explode(',', $ids);
    }
}