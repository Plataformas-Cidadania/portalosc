<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_conselho_outro
 * @property int $id_conselho
 * @property string $tx_nome_conselho
 * @property string $ft_nome_conselho
 * @property Osc.tbParticipacaoSocialConselho $osc.tbParticipacaoSocialConselho
 */
class ParticipacaoSocialConselhoOutro extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_participacao_social_conselho_outro';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_conselho_outro';

    /**
     * @var array
     */
    protected $fillable = ['id_conselho', 'tx_nome_conselho', 'ft_nome_conselho'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ParticipacaoSocialConselho()
    {
        return $this->belongsTo('App\Models\Osc\ParticipacaoSocialConselho', 'id_conselho', 'id_conselho');
    }
}
