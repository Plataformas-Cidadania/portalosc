<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $cd_conferencia
 * @property string $tx_nome_conferencia
 * @property Osc.tbParticipacaoSocialConferencium[] $osc.tbParticipacaoSocialConferencias
 */
class DCConferencia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'syst.dc_conferencia';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cd_conferencia';

    /**
     * @var array
     */
    protected $fillable = ['tx_nome_conferencia'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participacao_social_conferencias()
    {
        return $this->hasMany('App\Models\Osc\ParticipacaoSocialConferencia', 'cd_conferencia', 'cd_conferencia');
    }
}
