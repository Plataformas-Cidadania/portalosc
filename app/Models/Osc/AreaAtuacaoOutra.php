<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_area_atuacao_outra
 * @property int $id_osc
 * @property int $id_area_atuacao_declarada
 * @property string $ft_area_atuacao_outra
 * @property Osc.tbAreaAtuacaoDeclarada $osc.tbAreaAtuacaoDeclarada
 * @property Osc.tbOsc $osc.tbOsc
 * @property Osc.tbAreaAtuacaoOutraProjeto[] $osc.tbAreaAtuacaoOutraProjetos
 */
class AreaAtuacaoOutra extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_area_atuacao_outra';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_area_atuacao_outra';

    /**
     * @var array
     */
    protected $fillable = ['id_osc', 'id_area_atuacao_declarada', 'ft_area_atuacao_outra'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function osc.tbAreaAtuacaoDeclarada()
    {
        return $this->belongsTo('App\Models\Osc\Osc.tbAreaAtuacaoDeclarada', 'id_area_atuacao_declarada', 'id_area_atuacao_declarada');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function osc.tbOsc()
    {
        return $this->belongsTo('App\Models\Osc\Osc.tbOsc', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbAreaAtuacaoOutraProjetos()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbAreaAtuacaoOutraProjeto', 'id_area_atuacao_outra', 'id_area_atuacao_outra');
    }
}
