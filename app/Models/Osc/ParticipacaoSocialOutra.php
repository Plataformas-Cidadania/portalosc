<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_participacao_social_outra
 * @property int $id_osc
 * @property string $tx_nome_participacao_social_outra
 * @property string $ft_participacao_social_outra
 * @property boolean $bo_oficial
 * @property boolean $bo_nao_possui
 * @property Osc.tbOsc $osc.tbOsc
 */
class ParticipacaoSocialOutra extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_participacao_social_outra';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_participacao_social_outra';

    /**
     * @var array
     */
    protected $fillable = ['id_osc', 'tx_nome_participacao_social_outra', 'ft_participacao_social_outra', 'bo_oficial', 'bo_nao_possui'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Osc()
    {
        return $this->belongsTo('App\Models\Osc\Osc', 'id_osc', 'id_osc');
    }
}
