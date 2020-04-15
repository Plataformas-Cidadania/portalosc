<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_financiador_projeto
 * @property int $id_projeto
 * @property string $tx_nome_financiador
 * @property string $ft_nome_financiador
 * @property boolean $bo_oficial
 * @property Osc.tbProjeto $osc.tbProjeto
 */
class FinanciadorProjeto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_financiador_projeto';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_financiador_projeto';

    /**
     * @var array
     */
    protected $fillable = ['id_projeto', 'tx_nome_financiador', 'ft_nome_financiador', 'bo_oficial'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Projeto()
    {
        return $this->belongsTo('App\Models\Osc\Projeto', 'id_projeto', 'id_projeto');
    }
}
