<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_localizacao_projeto
 * @property int $id_projeto
 * @property int $id_regiao_localizacao_projeto
 * @property string $ft_regiao_localizacao_projeto
 * @property string $tx_nome_regiao_localizacao_projeto
 * @property string $ft_nome_regiao_localizacao_projeto
 * @property boolean $bo_localizacao_prioritaria
 * @property string $ft_localizacao_prioritaria
 * @property boolean $bo_oficial
 * @property Osc.tbProjeto $osc.tbProjeto
 */
class LocalizacaoProjeto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_localizacao_projeto';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_localizacao_projeto';

    /**
     * @var array
     */
    protected $fillable = ['id_projeto', 'id_regiao_localizacao_projeto', 'ft_regiao_localizacao_projeto', 'tx_nome_regiao_localizacao_projeto', 'ft_nome_regiao_localizacao_projeto', 'bo_localizacao_prioritaria', 'ft_localizacao_prioritaria', 'bo_oficial'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Projeto()
    {
        return $this->belongsTo('App\Models\Osc\Projeto', 'id_projeto', 'id_projeto');
    }
}
