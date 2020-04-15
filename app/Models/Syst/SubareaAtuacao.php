<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $cd_subarea_atuacao
 * @property int $cd_area_atuacao
 * @property string $tx_nome_subarea_atuacao
 * @property Syst.dcAreaAtuacao $syst.dcAreaAtuacao
 * @property Osc.tbAreaAtuacao[] $osc.tbAreaAtuacaos
 * @property Osc.tbAreaAtuacaoProjeto[] $osc.tbAreaAtuacaoProjetos
 */
class SubareaAtuacao extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'syst.dc_subarea_atuacao';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cd_subarea_atuacao';

    /**
     * @var array
     */
    protected $fillable = ['cd_area_atuacao', 'tx_nome_subarea_atuacao'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function AreaAtuacao()
    {
        return $this->belongsTo('App\Models\Syst\AreaAtuacao', 'cd_area_atuacao', 'cd_area_atuacao');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function AreaAtuacaos()
    {
        return $this->hasMany('App\Models\Osc\AreaAtuacao', 'cd_subarea_atuacao', 'cd_subarea_atuacao');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function AreaAtuacaoProjetos()
    {
        return $this->hasMany('App\Models\Osc\AreaAtuacaoProjeto', 'cd_subarea_atuacao', 'cd_subarea_atuacao');
    }
}
