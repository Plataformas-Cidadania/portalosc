<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $cd_situacao_imovel
 * @property string $tx_nome_situacao_imovel
 * @property Osc.tbDadosGerai[] $osc.tbDadosGerais
 */
class SituacaoImovel extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'syst.dc_situacao_imovel';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cd_situacao_imovel';

    /**
     * @var array
     */
    protected $fillable = ['tx_nome_situacao_imovel'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function DadosGerais()
    {
        return $this->hasMany('App\Models\Osc\DadosGerai', 'cd_situacao_imovel_osc', 'cd_situacao_imovel');
    }
}
