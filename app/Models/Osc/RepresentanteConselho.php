<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_representante_conselho
 * @property int $id_osc
 * @property int $id_participacao_social_conselho
 * @property string $tx_nome_representante_conselho
 * @property string $ft_nome_representante_conselho
 * @property boolean $bo_oficial
 * @property Osc.tbParticipacaoSocialConselho $osc.tbParticipacaoSocialConselho
 * @property Osc.tbOsc $osc.tbOsc
 */
class RepresentanteConselho extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_representante_conselho';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_representante_conselho';

    /**
     * @var array
     */
    protected $fillable = ['id_osc', 'id_participacao_social_conselho', 'tx_nome_representante_conselho', 'ft_nome_representante_conselho', 'bo_oficial'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ParticipacaoSocialConselho()
    {
        return $this->belongsTo('App\Models\Osc\ParticipacaoSocialConselho', 'id_participacao_social_conselho', 'id_conselho');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Osc()
    {
        return $this->belongsTo('App\Models\Osc\Osc', 'id_osc', 'id_osc');
    }
}
