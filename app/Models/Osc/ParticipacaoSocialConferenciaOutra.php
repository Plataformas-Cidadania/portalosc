<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_conferencia_outra
 * @property int $id_conferencia
 * @property string $tx_nome_conferencia
 * @property string $ft_nome_conferencia
 * @property Osc.tbParticipacaoSocialConferencium $osc.tbParticipacaoSocialConferencium
 */
class ParticipacaoSocialConferenciaOutra extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_participacao_social_conferencia_outra';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_conferencia_outra';

    /**
     * @var array
     */
    protected $fillable = ['id_conferencia', 'tx_nome_conferencia', 'ft_nome_conferencia'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function participacao_social_conferencia()
    {
        return $this->belongsTo('App\Models\Osc\ParticipacaoSocialConferencia', 'id_conferencia', 'id_conferencia');
    }
}
