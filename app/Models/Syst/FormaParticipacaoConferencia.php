<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $cd_forma_participacao_conferencia
 * @property string $tx_nome_forma_participacao_conferencia
 * @property Osc.tbParticipacaoSocialConferencium[] $osc.tbParticipacaoSocialConferencias
 */
class FormaParticipacaoConferencia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'syst.dc_forma_participacao_conferencia';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cd_forma_participacao_conferencia';

    /**
     * @var array
     */
    protected $fillable = ['tx_nome_forma_participacao_conferencia'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbParticipacaoSocialConferencias()
    {
        return $this->hasMany('App\Models\Syst\Osc.tbParticipacaoSocialConferencium', 'cd_forma_participacao_conferencia', 'cd_forma_participacao_conferencia');
    }
}
