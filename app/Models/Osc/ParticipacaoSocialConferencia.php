<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_conferencia
 * @property int $cd_conferencia
 * @property int $id_osc
 * @property int $cd_forma_participacao_conferencia
 * @property string $ft_conferencia
 * @property string $dt_ano_realizacao
 * @property string $ft_ano_realizacao
 * @property string $ft_forma_participacao_conferencia
 * @property boolean $bo_oficial
 * @property Syst.dcConferencium $syst.dcConferencium
 * @property Syst.dcFormaParticipacaoConferencium $syst.dcFormaParticipacaoConferencium
 * @property Osc.tbOsc $osc.tbOsc
 * @property Osc.tbParticipacaoSocialConferenciaOutra[] $osc.tbParticipacaoSocialConferenciaOutras
 */
class ParticipacaoSocialConferencia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_participacao_social_conferencia';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_conferencia';

    /**
     * @var array
     */
    protected $fillable = ['cd_conferencia', 'id_osc', 'cd_forma_participacao_conferencia', 'ft_conferencia', 'dt_ano_realizacao', 'ft_ano_realizacao', 'ft_forma_participacao_conferencia', 'bo_oficial'];


    protected $with = [
        'dc_conferencia',
        'dc_forma_participacao_conferencia'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dc_conferencia()
    {
        return $this->belongsTo('App\Models\Syst\DCConferencia', 'cd_conferencia', 'cd_conferencia');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dc_forma_participacao_conferencia()
    {
        return $this->belongsTo('App\Models\Syst\DCFormaParticipacaoConferencia', 'cd_forma_participacao_conferencia', 'cd_forma_participacao_conferencia');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Osc()
    {
        return $this->belongsTo('App\Models\Osc\Osc', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dc_outros_espacos_participacao_social()
    {
        return $this->hasMany('App\Models\Osc\ParticipacaoSocialConferenciaOutra', 'id_conferencia', 'id_conferencia');
    }
}
