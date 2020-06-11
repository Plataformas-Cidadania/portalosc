<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $cd_area_atuacao
 * @property string $tx_nome_area_atuacao
 * @property Osc.tbAreaAtuacao[] $osc.tbAreaAtuacaos
 * @property Syst.dcSubareaAtuacao[] $syst.dcSubareaAtuacaos
 */
class DCAreaAtuacao extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'syst.dc_area_atuacao';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cd_area_atuacao';

    /**
     * @var array
     */
    protected $fillable = ['tx_nome_area_atuacao'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function areas_atuacao()
    {
        return $this->hasMany('App\Models\Osc\AreaAtuacao', 'cd_area_atuacao', 'cd_area_atuacao');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subareas_atuacao()
    {
        return $this->hasMany('App\Models\Syst\DCSubareaAtuacao', 'cd_area_atuacao', 'cd_area_atuacao');
    }
}
