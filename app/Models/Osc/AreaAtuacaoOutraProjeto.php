<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_area_atuacao_outra_projeto
 * @property int $id_projeto
 * @property int $id_area_atuacao_outra
 * @property string $ft_area_atuacao_outra_projeto
 * @property Osc.tbProjeto $osc.tbProjeto
 * @property Osc.tbAreaAtuacaoOutra $osc.tbAreaAtuacaoOutra
 */
class AreaAtuacaoOutraProjeto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_area_atuacao_outra_projeto';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_area_atuacao_outra_projeto';

    /**
     * @var array
     */
    protected $fillable = ['id_projeto', 'id_area_atuacao_outra', 'ft_area_atuacao_outra_projeto'];

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
    public function AreaAtuacaoOutra()
    {
        return $this->belongsTo('App\Models\Osc\AreaAtuacaoOutra', 'id_area_atuacao_outra', 'id_area_atuacao_outra');
    }
}
