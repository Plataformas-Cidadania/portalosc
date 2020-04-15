<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_area_atuacao
 * @property int $id_osc
 * @property int $cd_area_atuacao
 * @property int $cd_subarea_atuacao
 * @property string $ft_area_atuacao
 * @property boolean $bo_oficial
 * @property string $tx_nome_outra
 * @property Syst.dcAreaAtuacao $syst.dcAreaAtuacao
 * @property Syst.dcSubareaAtuacao $syst.dcSubareaAtuacao
 * @property Osc.tbOsc $osc.tbOsc
 */
class AreaAtuacao extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_area_atuacao';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_area_atuacao';

    /**
     * @var array
     */
    protected $fillable = ['id_osc', 'cd_area_atuacao', 'cd_subarea_atuacao', 'ft_area_atuacao', 'bo_oficial', 'tx_nome_outra'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function AreaAtuacao()
    {
        return $this->belongsTo('App\Models\Syst\AreaAtuacao', 'cd_area_atuacao', 'cd_area_atuacao');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function SubareaAtuacao()
    {
        return $this->belongsTo('App\Models\Syst\SubareaAtuacao', 'cd_subarea_atuacao', 'cd_subarea_atuacao');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Osc()
    {
        return $this->belongsTo('App\Models\Osc\Osc', 'id_osc', 'id_osc');
    }
}
