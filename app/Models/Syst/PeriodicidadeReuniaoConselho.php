<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $cd_periodicidade_reuniao_conselho
 * @property string $tx_nome_periodicidade_reuniao_conselho
 * @property Osc.tbParticipacaoSocialConselho[] $osc.tbParticipacaoSocialConselhos
 */
class PeriodicidadeReuniaoConselho extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'syst.dc_periodicidade_reuniao_conselho';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cd_periodicidade_reuniao_conselho';

    /**
     * @var array
     */
    protected $fillable = ['tx_nome_periodicidade_reuniao_conselho'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ParticipacaoSocialConselhos()
    {
        return $this->hasMany('App\Models\Osc\ParticipacaoSocialConselho', 'cd_periodicidade_reuniao_conselho', 'cd_periodicidade_reuniao_conselho');
    }
}
