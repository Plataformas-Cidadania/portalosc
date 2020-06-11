<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_area_atuacao_projeto
 * @property int $id_projeto
 * @property int $cd_subarea_atuacao
 * @property string $ft_area_atuacao_projeto
 * @property boolean $bo_oficial
 * @property Osc.tbProjeto $osc.tbProjeto
 * @property Syst.dcSubareaAtuacao $syst.dcSubareaAtuacao
 */
class AreaAtuacaoProjeto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_area_atuacao_projeto';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_area_atuacao_projeto';

    /**
     * @var array
     */
    protected $fillable = ['id_projeto', 'cd_subarea_atuacao', 'ft_area_atuacao_projeto', 'bo_oficial'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Projeto()
    {
        return $this->belongsTo('App\Models\Osc\Projeto', 'id_projeto', 'id_projeto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function SubareaAtuacao()
    {
        return $this->belongsTo('App\Models\Syst\DCSubareaAtuacao', 'cd_subarea_atuacao', 'cd_subarea_atuacao');
    }
}
