<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $cd_conselho
 * @property string $tx_nome_conselho
 * @property string $tx_nome_orgao_vinculado
 * @property Osc.tbParticipacaoSocialConselho[] $osc.tbParticipacaoSocialConselhos
 */
class DCConselho extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'syst.dc_conselho';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cd_conselho';

    /**
     * @var array
     */
    protected $fillable = ['tx_nome_conselho', 'tx_nome_orgao_vinculado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ParticipacaoSocialConselhos()
    {
        return $this->hasMany('App\Models\Osc\ParticipacaoSocialConselho', 'cd_conselho', 'cd_conselho');
    }
}
